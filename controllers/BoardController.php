<?php

namespace app\controllers;

use Yii;
use yii\web\Controller;
use app\models\Board;
use app\models\TextNode;
use app\models\HrefNode;
use app\models\ImgNode;
use app\models\User;
use app\models\BoardUserAccess;

class BoardController extends Controller
{
    public function actionIndex()
    {
        $model = Board::findOne(Yii::$app->request->get('id'));
        $accessFlag = false;
        foreach ($model->boardUserAccesses as $bUA) {
            if ($bUA->user_id == Yii::$app->user->getIdentity()->id) {
                $accessFlag=true;
            }
        }
        if (!$accessFlag) {
            $this->goHome();
        }
        return $this->render('index', ['model'=>$model]);
    }
    
    public function actionAddNode() 
    {
    	switch (Yii::$app->request->post('type')){
    		case 'txt':
    			$model = new TextNode();
    			break;
    		case 'ref':
    			$model = new HrefNode();
    			break;
    	}
    	foreach (Yii::$app->request->post() as $param => $value){
    		if ($param == 'type') {
    			continue;
    		}
    		$model->$param = $value;
    	}
    	$model->save();
    	
    	echo $model->id;
    }
    
    public function actionEditNode()
    {
    	switch (Yii::$app->request->post('type')){
    		case 'txt':
    			$model = TextNode::findOne(Yii::$app->request->post('id'));
    			break;
    		case 'ref':
    			$model = HrefNode::findOne(Yii::$app->request->post('id'));
    			break;
    	}
    	foreach (Yii::$app->request->post() as $param => $value){
    		if ($param == 'type') {
    			continue;
    		}
    		$model->$param = $value;
    	}
    	$model->save();
    	 
    	echo $model->id;
    }
    
    public function actionDeleteNode()
    {
    	switch (Yii::$app->request->post('type')){
    		case 'txt':
    			$model = TextNode::findOne(Yii::$app->request->post('node_id'));
    			break;
    		case 'ref':
    			$model = HrefNode::findOne(Yii::$app->request->post('node_id'));
    			break;
    	}
    	$model->delete();    	
    }
    
    public function actionAddImgNode()
    {
    	$model = new ImgNode();    	
    	foreach (Yii::$app->request->post() as $param => $value){
            if ($param == '_csrf' || $value == "") {
    			continue;
    		} 
    		$model->$param = $value;
    	}
    	$model->path = ImgNode::uploadImage();
    	$model->save();
    	$model = ImgNode::findOne($model->id);
    	echo json_encode($model->attributes);
    }
    
    public function actionEditImage()
    {
    	$model = ImgNode::findOne(Yii::$app->request->post('node_id'));
    	foreach (Yii::$app->request->post() as $param => $value){
            if ($param == '_csrf' || $value == "" || $param == 'node_id') {
    			continue;
    		} 
    		$model->$param = $value;
    	}

    	if ($_FILES['img']['name'] != "") {
    		$model->path = ImgNode::uploadImage();
    	}    	
    	$model->save();
    	$model = ImgNode::findOne($model->id);
    	echo json_encode($model->attributes);
    }
    
    public function actionDeleteImgNode()
    {
        $model = ImgNode::findOne(Yii::$app->request->post('node_id'));
        $model->deleteFile();
    	$model->delete();
    }    

    public function actionAddUser() {
    	$modelUser = User::find()
    	             ->where(['login' => Yii::$app->request->post('login')])
    	             ->one();
    	if (!is_null($modelUser)) {
    		$model = new BoardUserAccess();
    		$model->user_id = $modelUser->id;
    		$model->board_id = Yii::$app->request->post('boardId');
    		$model->save();
    	}

    }
}