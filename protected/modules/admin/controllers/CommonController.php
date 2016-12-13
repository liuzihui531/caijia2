<?php

class CommonController extends AdminBaseController {

    //put your code here
    public function actionIndex() {
        $type = Yii::app()->request->getParam('type', '');
        $id = Yii::app()->request->getParam("id", 0);
        if ($type == "user") {
            $model = User::model()->findByPk($id);
        } elseif ($type == 'project') {
            $model = Project::model()->findByPk($id);
        }
        if (Yii::app()->request->isPostRequest) {
            $place_ids = Yii::app()->request->getParam("place_ids", array());
            $model->place_ids = $place_ids ? implode(",", $place_ids) : "";
            $transaction = Yii::app()->db->beginTransaction();
            if ($type == "user") {
                $r = UserPlaceRelation::batchInsert($id, $place_ids);
            } elseif ($type == 'project') {
                $r = ProjectPlaceRelation::batchInsert($id, $place_ids);
            }
            $model->save();
            if (!$r || $model->hasErrors()) {
                $transaction->rollback();
                $this->handleResult(0, '操作失败', $this->createUrl('index', array('id' => $id, 'type' => $type)));
            } else {
                $transaction->commit();
                $this->handleResult(1, '操作成功', $this->createUrl('index', array('id' => $id, 'type' => $type)));
            }
        }
        $area = Area::getArea();
        $unlimit = $area['unlimit'];
        //Utils::printr($subUnlimit);
        $this->breadcrumbs = array('采价点管理');
        $placeModel = Place::model()->findAll();
        $placeData = array();
        if ($placeModel) {
            foreach ($placeModel as $key => $val) {
                $placeData[$val->areacode][$val->id] = $val->attributes;
            }
        }
        $modelPlaces = $model && $model->place_ids ? explode(",", $model->place_ids) : array();
        $this->render('index', array('unlimit' => $unlimit, 'placeData' => $placeData, 'modelPlaces' => $modelPlaces));
    }

    public function actionGoods() {
        $id = Yii::app()->request->getParam("id", 0);
        $model = Project::model()->findByPk($id);
        if (Yii::app()->request->isPostRequest) {
            $goods_ids = Yii::app()->request->getParam('goods_ids', array());
            $model->goods_ids = $goods_ids ? implode(',', $goods_ids) : "";
            $transaction = Yii::app()->db->beginTransaction();
            $r = ProjectGoodsRelation::batchInsert($id, $goods_ids);
            $model->save();
            if (!$r || $model->hasErrors()) {
                $transaction->rollback();
                $this->handleResult(0, '操作失败', $this->createUrl('goods', array('id' => $id)));
            } else {
                $transaction->commit();
                $this->handleResult(1, '操作成功', $this->createUrl('goods', array('id' => $id)));
            }
        }
        $goods_category = GoodsCategory::getGoodsCategory();
        $goods_category = $goods_category['unlimit'];
        $goodsModel = Goods::model()->findAll();
        $goodsData = array();
        if ($goodsModel) {
            foreach ($goodsModel as $key => $val) {
                $goodsData[$val->cat_id][$val->id] = $val->attributes;
            }
        }
        $modelGoodsIds = $model && $model->goods_ids ? explode(",", $model->goods_ids) : array();
        $this->render('goods', array('goods_category' => $goods_category, 'goodsData' => $goodsData, 'modelGoodsIds' => $modelGoodsIds));
    }

    public function actionDates() {
        $this->breadcrumbs = array('时间管理');
        $begin_date = Yii::app()->request->getParam('begin_date', '');
        $end_date = Yii::app()->request->getParam('end_date', '');
        $id = Yii::app()->request->getParam('id', 0);
        $type = Yii::app()->request->getParam('type', 0);
        $end_date = $end_date ? date('Ymd', strtotime($end_date)) : "";
        $begin_date = $begin_date ? date('Ymd', strtotime($begin_date)) : "";
        $project_model = Project::model()->findByPk($id);
        $date_list = array();
        $dates_arr = array();
        if ($project_model->dates) {
            $dates_arr = explode(",", $project_model->dates);
            if ($type != 1) {
                $begin_date = current($dates_arr);
                $end_date = end($dates_arr);
            }
        }
        if ($begin_date && $end_date) {
            $tmp = $begin_date;
            while (true) {
                if ($tmp <= $end_date) {
                    $date_list[] = $tmp;
                    $start_time = strtotime($tmp);
                    $tmp = date("Ymd", strtotime("+1 day", $start_time));
                } else {
                    break;
                }
            }
        }
        $this->render('dates', array('date_list' => $date_list, 'dates_arr' => $dates_arr, 'begin_date' => $begin_date, 'end_date' => $end_date));
    }

    public function actionDodates() {
        $dates = Yii::app()->request->getParam('Dates');
        $id = Yii::app()->request->getParam('id', 0);
        if ($id) {
            $transaction = Yii::app()->db->beginTransaction();
            $model = Project::model()->findByPk($id);
            $model->dates = implode(',', $dates);
            $model->save();
            $r = ProjectDateRelation::batchInsert($id, $dates);
            if (!$r || $model->hasErrors()) {
                $transaction->rollback();
                $this->handleResult(0, '操作失败');
            } else {
                $transaction->commit();
                $this->handleResult(1, '操作成功');
            }
        } else {
            $this->handleResult(0, '无此项目');
        }
    }

}
