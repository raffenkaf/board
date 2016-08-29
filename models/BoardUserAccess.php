<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "board_user_access".
 *
 * @property integer $id
 * @property integer $user_id
 * @property integer $board_id
 *
 * @property Board $board
 * @property User $user
 */
class BoardUserAccess extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'board_user_access';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['user_id', 'board_id'], 'required'],
            [['user_id', 'board_id'], 'integer'],
            [['board_id'], 'exist', 'skipOnError' => true, 'targetClass' => Board::className(), 'targetAttribute' => ['board_id' => 'id']],
            [['user_id'], 'exist', 'skipOnError' => true, 'targetClass' => User::className(), 'targetAttribute' => ['user_id' => 'id']],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'user_id' => 'User ID',
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

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getUser()
    {
        return $this->hasOne(User::className(), ['id' => 'user_id']);
    }
}
