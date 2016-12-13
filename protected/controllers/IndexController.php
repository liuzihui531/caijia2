<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
Class IndexController extends IndexBaseController{
    public function actionIndex(){
    	$a = "0.1";
    	var_dump(is_numeric($a));exit;
        $this->render('index');
    }
}
