<?php

namespace app\models;

use yii\db\ActiveRecord;
use yii\web\IdentityInterface;
use Yii;

class User extends ActiveRecord implements IdentityInterface
{
	public $password_repeat;
	
	private $auth_key;
	
    public static function tableName()
    {
        return 'user';
    }
    
    public function beforeSave($insert)
    {
    	if ($this->isNewRecord) {
    		$this->password_repeat = $this->password //Pass already checked
    		= \Yii::$app->security->generatePasswordHash($this->password);
    	} else {
    		$this->password_repeat = $this->password;
    	}
    	if (parent::beforeSave($insert)) {
    		if ($this->isNewRecord) {
    			$this->auth_key = \Yii::$app->security->generateRandomString();
    		}
    		return true;
    	}
    	return false;
    }

    public static function findIdentity($id)
    {
        return static::findOne($id);
    }

    public static function findIdentityByAccessToken($token, $type = null)
    {
        return static::findOne(['access_token' => $token]);
    }

    /**
     * @return int|string current user ID
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @return string current user auth key
     */
    public function getAuthKey()
    {
        return $this->auth_key;
    }
    
    public function getBoards()
    {
    	return $this->hasMany(Board::className(), ['create_user_id' => 'id']);
    }

    public function validateAuthKey($authKey)
    {
        return $this->getAuthKey() === $authKey;
    }
    
    public function validatePassword($password)
    {
    	return Yii::$app->getSecurity()->validatePassword($password, $this->password);
    }
    
	public function rules()
	{
		return [
				[['login', 'password', 'password_repeat', 'name'], 
						'required', 'message' => 'Данное поле являеться обязательным'],
				[['password'], 'string', 'min' => 3],
				['login', 'unique'],				
			    ['password_repeat', 'compare', 'compareAttribute'=>'password', 'message'=>"Пароли не совпадают"],				
		];
	}
	
	public function attributeLabels()
	{
		return [
				'login' => 'Логин',
				'password' => 'Пароль',
				'password_repeat' => 'Подтверждение пароля',
				'name' => 'Имя',				
		];
	}
}