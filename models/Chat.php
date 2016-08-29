<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "chat".
 *
 * @property integer $id
 * @property string $msg
 * @property string $author
 * @property string $created_at
 * @property integer $board_id
 *
 * @property Board $board
 */
class Chat extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'chat';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['msg', 'author'], 'required'],
            [['msg'], 'string'],
            [['created_at'], 'safe'],
            [['board_id'], 'integer'],
            [['author'], 'string', 'max' => 200],
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
            'msg' => 'Msg',
            'author' => 'Author',
            'created_at' => 'Created At',
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
}
