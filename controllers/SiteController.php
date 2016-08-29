<?php

namespace app\controllers;

use Yii;
use yii\filters\AccessControl;
use yii\web\Controller;
use yii\filters\VerbFilter;
use app\models\Board;
use app\models\BoardUserAccess;

class SiteController extends Controller
{
    /**
     * @inheritdoc
     */
    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::className(),
                'only' => ['logout', 'index'],
                'rules' => [
                    [
                        'allow' => true,
                        'actions' => ['login', 'signup'],
                        'roles' => ['?'],
                    ],
                	[
                		'actions' => ['logout', 'index'],
                		'allow' => true,
                		'roles' => ['@'],
                	],
                ],
            ],
//             'verbs' => [
//                 'class' => VerbFilter::className(),
//                 'actions' => [
//                     'logout' => ['post'],
//                 ],
//             ],
        ];
    }

    /**
     * @inheritdoc
     */
    public function actions()
    {
        return [
            'error' => [
                'class' => 'yii\web\ErrorAction',
            ],
//             'captcha' => [
//                 'class' => 'yii\captcha\CaptchaAction',
//                 'fixedVerifyCode' => YII_ENV_TEST ? 'testme' : null,
//             ],
        ];
    }

    public function actionIndex()
    {
    	$model = new Board();
    	if ($model->load(Yii::$app->request->post())) {
    		$bUAmodel = new BoardUserAccess();
    		$model->create_user_id = Yii::$app->user->getIdentity()->id;
    		if (!$model->save()) {    			
    			return $this->render('index', ['model'=>$model]);
    		}
    		$bUAmodel->board_id = $model->id;
    		$bUAmodel->user_id = Yii::$app->user->getIdentity()->id;
    		$bUAmodel->save();
    		return $this->redirect(['site/board', 'id' => $model->id]);
    	}
        return $this->render('index', ['model'=>$model]);
    }
}
