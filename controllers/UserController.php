<?php

namespace app\controllers;

use yii\web\Controller;
use app\models\User;
use app\models\LoginForm;
use Yii;

class UserController extends Controller
{

	public function actionLogin()
	{
		$this->layout = 'empty';
		$model = new LoginForm();
		if ($model->load(Yii::$app->request->post()) && $model->login()) {
			return $this->goBack();
		}
		return $this->render('login', [
				'model' => $model,
		]);
	}
	
	public function actionSignup()
	{
		$this->layout = 'empty';
		$model = new User();
		if ($model->load(Yii::$app->request->post())) {
			
			if (!$model->save()) {
				return $this->render('signup', [
						'model' => $model,
				]);
			}
		
			return $this->redirect('/user/login');
		}
		 
		return $this->render('signup', [
				'model' => $model,
		]);
	}
	
	public function actionLogout()
	{
		Yii::$app->user->logout();
	
		return $this->goHome();
	}
}