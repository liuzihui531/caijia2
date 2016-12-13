<?php

class MemberController extends FrontBaseController {

    public function actionIndex() {
        $this->pageTitle = 'LOOG';
        $this->render("index");
    }

    public function actionChangeAccount() {
        $this->pageTitle = 'LOOG';
        $model = User::model()->findByPk(Yii::app()->user->id);
        $this->render("changeaccount", array('model' => $model));
    }

    public function actionChangeAttr() {
        $this->pageTitle = 'LOOG';
        $model = User::model()->findByPk(Yii::app()->user->id);
        $field = Yii::app()->request->getParam("field", '');
        if (!$field) {
            $this->handleResult(0, '非法请求');
        }
        $this->render("changeattr", array(
            'model' => $model,
            'field' => $field,
        ));
    }

    public function actionDoChangeAttr() {
        $field = Yii::app()->request->getParam('Field', '');
        $model = User::model()->findByPk(Yii::app()->user->id);
        //判断是否修改生日
        if (isset($field['birthday'])) {
            $flag = true;
            foreach ($field['birthday'] as $key => $val) {
                if (empty($val)) {
                    $flag = false;
                    break;
                }
            }
            if (!$flag) {
                $this->handleResult(0, '生日必填');
            }
            $field['birthday'] = implode("", $field['birthday']);
            if (date("Ymd", strtotime($field['birthday'])) != $field['birthday']) {
                $this->handleResult(0, '生日信息有误');
            }
        } elseif (isset($field['password'])) {
            $field['oldpassword'] = $field['password']; //保存明码密码修改登录的cookie数据
            $field['password'] = Utils::password($field['password']);
        }
        $model->attributes = $field;
        $model->save();
        if ($model->hasErrors()) {
            $this->handleResult(0, Utils::getFirstError($model->errors));
        }
        if (isset($field['mobile'])) {
            $changeUsername = $this->changeLoginCookie($field['mobile'], 'username');
        } elseif (isset($field['password'])) {
            $changePassword = $this->changeLoginCookie($field['oldpassword'], 'password');
        }
        $this->handleResult(1, '操作成功');
    }

    public function actionHistoryRecord() {
        $user_id = Yii::app()->user->id;
        $date = date("Ymd", strtotime("-3 month"));
        $criteria = new CDbCriteria();
        $criteria->compare('user_id', $user_id);
        $criteria->compare('user_type', 0);
        $criteria->addCondition("date >= {$date}");
        $model = PriceLog::model()->findAll($criteria);
        $log_list = array();
        if ($model) {
            foreach ($model as $k => $v) {
                $dataKey = md5($v->project_id.$v->project_name.$v->project_desc);
                if(isset($log_list[$dataKey]) && !empty($log_list[$dataKey])){
                    $log_list[$dataKey]['logModel'][] = $v;
                }else{
                    $log_list[$dataKey] = array(
                        'project_name' => $v->project_name,
                        'project_desc' => $v->project_desc,
                        'project_id' => $v->project_id,
                        'logModel' => array($v),
                    );
                }
            }
        }
        $this->render('history_record', array('model' => $log_list));
    }

    private function changeLoginCookie($data, $type) {
        $userData = $this->getLoginCookie();
        $userData[$type] = $data;
        $this->setLoginCookie($userData);
    }

}
