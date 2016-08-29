<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "text_node".
 *
 * @property integer $id
 * @property string $msg
 * @property string $font-size
 * @property string $color
 * @property string $bgcolor
 * @property string $x_coordinate
 * @property string $y_coordinate
 * @property integer $board_id
 *
 * @property Board $board
 */
class TextNode extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'text_node';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['msg', 'board_id'], 'required'],
            [['msg'], 'string'],
            [['board_id'], 'integer'],
            [['font_size', 'x_coordinate', 'y_coordinate'], 'string', 'max' => 10],
            [['color', 'bgcolor'], 'string', 'max' => 20],
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
            'font_size' => 'Font Size',
            'color' => 'Color',
            'bgcolor' => 'Bgcolor',
            'x_coordinate' => 'X Coordinate',
            'y_coordinate' => 'Y Coordinate',
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
