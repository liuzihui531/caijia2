<?php 
	class ProjectController extends FrontBaseController{
		public function actionPlace(){
			$this->pageTitle = '选择采价地点';
			//项目ID
			$id = Yii::app()->request->getParam('id',0);
			$projectModel = Project::model()->findByPk($id);
			//算出项目有哪些采价点
			$projectPlaceId = $projectModel->place_ids ? explode(",",$projectModel->place_ids) : array();
			//算出用户有哪些采价点
			$userModel = User::model()->findByPk(Yii::app()->user->id);
			$userPlaceId = $userModel->place_ids ? explode(",",$userModel->place_ids) : array();
			//取项目和用户的采价点交集就是这个用户需要采价的点
			$place_ids = array_intersect($userPlaceId,$projectPlaceId);
			$placeModel = array();
			$goodsCount = 0;
			if($place_ids){
				$criteria = new CDbCriteria();
				$criteria->addInCondition("id",$place_ids);
				$placeModel = Place::model()->findAll($criteria);
				//先算出这个项目有多少个品种，即商品分类的1级
				$goodsCateIds = $projectModel->goodscate_ids ? explode(",",$projectModel->goodscate_ids) : array();
				if($goodsCateIds){
					//再算出1级分类有多少商品
					$goodsCount = count($this->getGoodsByCateTopIds($goodsCateIds));
				}
			}
			$this->render("place",array('placeModel' => $placeModel,'goodsCount' => $goodsCount,'projectModel' => $projectModel));
		}

		public function actionGoods(){
			$projectId = Yii::app()->request->getParam("projectId",0);
			$placeId = Yii::app()->request->getParam("placeId",0);
			$projectModel = Project::model()->findByPk($projectId);
			$placeModel = Place::model()->findByPk($placeId);
			//一级分类
			$goodsCateIds = $projectModel->goodscate_ids ? explode(",",$projectModel->goodscate_ids) : array();
			$goodsModel = array();
			if($goodsCateIds){
				$goodsModel = $this->getGoodsByCateTopIds($goodsCateIds);
			}
                        $date = date("Ymd");
                        $price_log_model = PriceLog::model()->findByAttributes(array('date' => $date,'project_id' => $projectId));
                        $price_log_data = array();
                        if($price_log_model){
                            foreach ($price_log_model as $k => $v){
                                $price_log_data[$v->goods_id][$v->place_id] = $v->price;
                            }
                        }
			$this->render("goods",array("goodsModel" => $goodsModel,'projectModel' => $projectModel,'placeModel' => $placeModel,'price_log_data' => $price_log_data));
		}

		/**
		 * 上报价格
		 */
		public function actionPrice(){
			$project_id = Yii::app()->request->getParam("project_id",0);
			$place_id = Yii::app()->request->getParam("place_id",0);
			$goods_id = Yii::app()->request->getParam("goods_id",0);
			$price = Yii::app()->request->getParam("price",0);
			$goodsModel = Goods::model()->findByPk($goods_id);
			$projectModel = Project::model()->findByPk($project_id);
			$goodscate_id = $goodsModel->goodsCategory->pid;
			$date = date("Ymd");
			//这里验证一下goodscate_id是否在项目中,目前先省略
			$model = new PriceLog();
			//验证价格
			if(is_numeric($price)){
				if($price <= 0){
					$this->handleResult(0,'价格必须大于0');
				}
				$model->price = $price;
			}else{
				$model->price = 0;
				$model->reason = $price;
			}
			$project_dates = $projectModel->dates;
			$project_first = $projectModel->first;
			$project_second = $projectModel->second;
			list($first_start,$first_end) = explode("-",$project_first);
			list($second_start,$second_end) = explode("-",$project_second);
			$now = time();
			$nowDate = date("Ymd");
			$project_dates_arr = $project_dates ? explode(",", $project_dates) : array();
			if(!in_array($nowDate, $project_dates_arr)){
				$this->handleResult(0,'不在项目期间内，不能报价');
			}
			$first_start_time = strtotime(date("Y-m-d")." ".$first_start);
			$first_end_time = strtotime(date("Y-m-d")." ".$first_end);
			$second_start_time = strtotime(date("Y-m-d")." ".$second_start);
			$second_end_time = strtotime(date("Y-m-d")." ".$second_end);
			//判断price_operate_log的状态，是否满足修改的条件
			$priceOperateModel = PriceOperate::model()->findByAttributes(array('date'=>$date,'goods_id' => $goods_id));
			if($priceOperateModel && $projectModel->status > 0){
				$this->handleResult(0,'管理员已上报或者审核，无法修改');
			}
			$tmp = array();//是否是修改
			if($now >= $first_start_time && $now <= $first_end_time){
				$model->times = 1;
				//如果是第一次，要判断是否在当天有没有在第一次采价过
				$tmp = PriceLog::model()->findByAttributes(array("times"=>1,'goods_id' => $goods_id,'project_id' => $project_id,'place_id' => $place_id,'goodscate_id' => $goodscate_id,'date'=>$date));
				if($tmp){
					$tmp->price = $price;
					$tmp->created = time();
					$tmp->save();
					if($tmp->hasErrors()){
						$this->handleResult(0,Utils::getFirstError($tmp->errors));
					}else{
						$this->handleResult(1,'');
					}
				}
			}elseif($now >= $second_start_time && $now <= $second_end_time){
				$model->times = 2;
				//如果是第二次，要判断是否在当天有没有在第二次采价过
				$tmp = PriceLog::model()->findByAttributes(array("times"=>2,'goods_id' => $goods_id,'project_id' => $project_id,'place_id' => $place_id,'goodscate_id' => $goodscate_id,'date' => $date));
				if($tmp){
					$tmp->price = $price;
					$tmp->created = time();
					$tmp->save();
					if($tmp->hasErrors()){
						$this->handleResult(0,Utils::getFirstError($tmp->errors));
					}else{
						$this->handleResult(1,'');
					}
				}
			}else{
				//$this->handleResult(0,'不在项目时间段内，不能报价');
			}
			if(!$tmp){
				$model->project_id = $project_id;
				$model->place_id = $place_id;
				$model->goods_id = $goods_id;
				$model->price = $price;
				$model->goodscate_id = $goodscate_id;
				$model->project_dates = $project_dates;
				$model->project_first = $project_first;
				$model->project_second = $project_second;
				$model->project_name = $projectModel->name;
				$model->project_desc = $projectModel->desc;
				$model->user_type = 0;
				$model->user_id = Yii::app()->user->id;
				$model->created = time();
				$model->date = $date;
				$model->save();
				if($model->hasErrors()){
					$this->handleResult(0,Utils::getFirstError($model->errors));
				}else{
					$this->handleResult(1,'');
				}
			}
		}

		/**
		 * 通过一级商品分类获取商品列表
		 * @param  array $goodsCateIds 商品1级分类
		 * @return array
		 */
		private function getGoodsByCateTopIds($goodsCateIds){
			$criteria = new CDbCriteria();
			$criteria->addInCondition('pid',$goodsCateIds);
			$cateModel = GoodsCategory::model()->findAll($criteria);
			$goodsModel = array();
			if($cateModel){
				foreach ($cateModel as $key => $val) {
					$subCateIds[] = $val->id;
				}
				$criteria2 = new CDbCriteria();
				$criteria2->addInCondition('cat_id',$subCateIds);
				$goodsModel = Goods::model()->findAll($criteria2);
			}
			return $goodsModel;
		}
	}