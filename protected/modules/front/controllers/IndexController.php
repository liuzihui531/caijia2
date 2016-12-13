<?php
/**
 * Description of IndexController
 *
 * @author Administrator
 */
class IndexController extends FrontBaseController{
    public function actionIndex(){
    	$this->pageTitle = '<img src="/static/front/img/logo.png" />';
    	//通知公告
    	$announceModel = Announce::getAnnounce(10,'id desc');
    	//采价项目
    	$userProject = Project::getUserProject(Yii::app()->user->id);
        $this->render("index",array(
        	'announceModel' => $announceModel,
        	'userProject' => $userProject,
        ));
    }
}
