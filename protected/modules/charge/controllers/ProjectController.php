<?php

class ProjectController extends ChargeBaseController {

    //put your code here
    public $page_name = "项目";

    public function actionIndex() {
        $this->breadcrumbs = array($this->page_name . '管理');
        $charge_id = Yii::app()->user->id;
        $charge_model = Charge::model()->findByPk($charge_id);
        $charge_project_model = ProjectDepartRelation::model()->with('project')->findAllByAttributes(array('depart_id' => $charge_model->depart_id));
        $this->render('index', array('charge_project_model' => $charge_project_model));
    }
    
    public function actionReport(){
        $id = Yii::app()->request->getParam('id',0);
        $model = Project::model()->findByPk($id);
        $goodscate_ids = $model->goodscate_ids;
        $goods = GoodsCategory::getGoodsCategory();
        $goods_unlimit = $goods['unlimit'];
        $goods_data = $goods['data'];
        $all = array();
        $top2sub = array();
        foreach($goods_unlimit as $k =>$v){
            if($v['level'] == 2){
                $top2sub[$v['id']] = $v['pid'];
            }
            if(in_array($v['pid'], explode(',',$goodscate_ids))){
                $all[] = $v['id'];
            }
        }
        $all_list = implode(',', $all);
        $count_model = Yii::app()->db->createCommand("SELECT cat_id,count(*) as count FROM `goods` group by cat_id having cat_id in ({$all_list});")->queryAll();
        $goods_model = Yii::app()->db->createCommand("select id,name,cat_id from goods where cat_id in (".  implode(",", $all).")")->queryAll();
        $goods_temp = array();
        if($goods_model){
            foreach ($goods_model as $k => $v){
                $goods_temp[$v['cat_id']][] = $v;
            }
        }
        $all_goods = array();//所有格式化好的商品
        $group_count = array();
        $all_count = array();
        foreach ($count_model as $k=>$v){
            $group_count[$top2sub[$v['cat_id']]][$v['cat_id']] = $v['count'];
            $all_count[$top2sub[$v['cat_id']]] += $v['count'];
            $all_goods[$top2sub[$v['cat_id']]][$v['cat_id']] = $goods_temp[$v['cat_id']];
        }
        //查询采价点
        $place_model = Yii::app()->db->createCommand("select id,name from place where id in (".$model->place_ids.")")->queryAll();
        //采价日志
        $date = "20161211";
        //价格等于0则不参与计算
        $sql = "select place_id,avg(price) as avg,date,project_id,goods_id,price from price_log group by place_id,goods_id having `date`='{$date}' and project_id=$id and price>0";
        $price_log_model = Yii::app()->db->createCommand($sql)->queryAll();
       
        $price_log_data = array();
        foreach ($price_log_model as $k => $v){
            $price_log_data[$v['goods_id']][$v['place_id']] = $v['avg'];
        }; 
        $yesterday = date("Ymd",  strtotime("-1 day",  strtotime($date)));
        $yesterday_model = Yii::app()->db->createCommand("select * from price_operate where date='{$yesterday}' and project_id={$id}")->queryAll();
        $yesterday_data = array();
        foreach ($yesterday_model as $k => $v){
            $yesterday_data[$v['goods_id']] = $v['avg'];
        };
        //查看审核状态
        $price_operate_model = Yii::app()->db->createCommand("select * from price_operate where project_id={$id} and date='{$date}'")->queryAll();
        $price_operate_data = array();
        if($price_operate_model){
            foreach ($price_operate_model as $k => $v){
                $price_operate_data[$v['goods_id']] = $v;
            }
        }
        $this->render('report',array(
            'goods_data'=>$goods_data,
            'group_count'=>$group_count,
            'all_count'=>$all_count,
            'all_goods' => $all_goods,
            'place_model' => $place_model,
            'price_log_data' => $price_log_data,
            'yesterday_data' => $yesterday_data,
            'date' => $date,
            'price_operate_data' => $price_operate_data,
            'project_id' => $id,
        ));
    }

}
