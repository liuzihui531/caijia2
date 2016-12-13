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
        $group_count = array();
        $all_count = array();
        foreach ($count_model as $k=>$v){
            $group_count[$top2sub[$v['cat_id']]][$v['cat_id']] = $v['count'];
            $all_count[$top2sub[$v['cat_id']]] += $v['count'];
        }
        $this->render('report',array('goods_data'=>$goods_data,'group_count'=>$group_count,'all_count'=>$all_count));
    }

}
