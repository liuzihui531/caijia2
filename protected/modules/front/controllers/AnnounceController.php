<?php 
	class AnnounceController extends FrontBaseController{
		public function actionIndex(){
			$model = Announce::getAnnounce(50,'id desc');
			$this->render("index",array(
				'model' => $model
			));
		}
		public function actionView($id){
			$this->pageTitle = '通知公告';
			$model = Announce::model()->findByPk($id);
			$this->render("view",array('model' => $model));
		}
	}