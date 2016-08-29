<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "img_node".
 *
 * @property integer $id
 * @property string $path
 * @property string $x_coordinate
 * @property string $y_coordinate
 * @property string $width
 * @property string $height
 * @property integer $board_id
 *
 * @property Board $board
 */
class ImgNode extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'img_node';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['path', 'board_id'], 'required'],
            [['board_id'], 'integer'],
            [['path'], 'string', 'max' => 255],
            [['x_coordinate', 'y_coordinate', 'width', 'height'], 'string', 'max' => 10],
            [['board_id'], 'exist', 'skipOnError' => true, 'targetClass' => Board::className(), 'targetAttribute' => ['board_id' => 'id']],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'path' => 'path',
            'x_coordinate' => 'X Coordinate',
            'y_coordinate' => 'Y Coordinate',
            'width' => 'Width',
            'height' => 'Height',
            'board_id' => 'Board ID',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getBoard()
    {
        return $this->hasOne(Board::className(), ['id' => 'board_id']);
    }
    
    public static function uploadImage()
    {
    	$targetDir = "uploads/";
    	$imageFileType = strtolower(pathinfo($_FILES['img']['name'], PATHINFO_EXTENSION));
    	$targetFile = $targetDir.time().".".$imageFileType;
    	$uploadOk = true;
    	$needResize = false;
    	
    	// Allow certain file formats
    	if(
    		$imageFileType != "jpg" && 
    		$imageFileType != "png" && 
    		$imageFileType != "jpeg" && 
    		$imageFileType != "gif" ) {
    		return "Не соответсвует расширение";
    	}
    	
    	if (move_uploaded_file($_FILES["img"]["tmp_name"], $targetFile)) {
    	    return $targetFile;
    	} else {
    	    return "Файл не скопирован";
    	}
    }
    
    public function deleteFile(){
    	unlink($this->path);
    }
}
