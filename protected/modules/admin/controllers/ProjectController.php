<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of Project_CategoryController
 *
 * @author Dell
 */
class ProjectController extends AdminBaseController {

    public $page_name = "项目";

    //put your code here
    public function actionIndex() {
        $this->breadcrumbs = array($this->page_name . '管理');
        $name = Yii::app()->request->getParam('name','');
        $criteria = new CDbCriteria();
        if($name){
            $criteria->addSearchCondition('name', $name);
        }
        $model = Project::model()->findAll($criteria);
        $this->render('index', array('model' => $model));
    }

    public function actionCreate() {
        $this->breadcrumbs = array('添加' . $this->page_name);
        $model = new Project();
        $this->render('_form',array('model' => $model));
    }

    public function actionUpdate() {
        $this->breadcrumbs = array('修改' . $this->page_name);
        $id = Yii::app()->request->getParam('id', 0);
        $model = Project::model()->findByPk($id);
        $this->checkEmpty($model);
        //处理采价时间字段
        $first = $this->handleCaijiaTime($model->first);
        $second = $this->handleCaijiaTime($model->second);
        $this->render('_form', array('model' => $model,'first' => $first,'second' => $second));
    }

    public function actionSave() {
        $id = Yii::app()->request->getParam('id', 0);
        $post = Yii::app()->request->getPost('Project');
        $first = Yii::app()->request->getPost('First', array());
        $second = Yii::app()->request->getPost('Second', array());
        if ($id) {
            $model = Project::model()->findByPk($id);
        } else {
            $model = new Project();
            $model->created = time();
        }
        $transaction = Yii::app()->db->beginTransaction();
        try {
            $model->attributes = $post;
            $model->first = $this->getCaijiaTime($first,1);
            $model->second = $this->getCaijiaTime($second,2);
            $model->depart_ids = $post['depart_ids'] ? implode(',', $post['depart_ids']) : "";
            $model->goodscate_ids = implode(',', $post['goodscate_ids']);
            $model->save();
            $r1 = ProjectDepartRelation::batchInsert($model->id, $post['depart_ids']);
            $r2 = ProjectGoodscateRelation::batchInsert($model->id, $post['goodscate_ids']);
            if (!$r1 || !$r2 || $model->hasErrors()) {
                throw new Exception(Utils::getFirstError($model->errors));
            }
            $transaction->commit();
            $this->handleResult(1, '操作成功', $this->createUrl('index'));
        } catch (Exception $ex) {
            $transaction->rollback();
            $this->handleResult(0, '操作失败,原因:' . $ex->getMessage());
        }
    }

    public function actionDelete() {
        $id = Yii::app()->request->getParam('id', '');
        $id = (array) $id;
        $criteria = new CDbCriteria();
        $criteria->addInCondition('id', $id);
        $res = Project::model()->deleteAll($criteria);
        if ($res) {
            $this->handleResult(1, '操作成功');
        } else {
            $this->handleResult(0, '操作失败');
        }
    }

    /**
     * 获取采价时间并处理入库
     * @param  array $time 前端获取的采价时间
     * @param  int $type 1是第一次，2是第二次
     * @return string
     * 
     */
    private function getCaijiaTime($time,$type=1){
        $all = 0;
        foreach ($time as $key => $val) {
            $hour = intval($val[0]);
            $miniute = intval($val[1]);
            $all = $all + $hour + $miniute;
            if($hour >= 24 || $hour < 0 || $miniute >= 60 || $miniute < 0){
                throw new Exception('采价时间不在正常范围内');
            }
        }
        $endGtstart = strtotime(date("Y-m-d")." ".$time['start'][0].":".$time['start'][1]) >= strtotime(date("Y-m-d")." ".$time['end'][0].":".$time['end'][1]);
        if( (($type == 2 && $all != 0) || $type == 1) && $endGtstart){
            throw new Exception("第{$type}次采价开始时间不能大于结束时间");
        }
        if($type == 2 && $all == 0){
            return '';
        }
        return $time['start'][0].":".$time['start'][1].'-'.$time['end'][0].":".$time['end'][1];
    }
    
    private function handleCaijiaTime($str){
        if(!$str)
            return false;
        list($start,$end) = explode('-', $str);
        return  array(
            'start' => explode(":", $start),
            'end' => explode(":", $end),
        );
    }

}
