<?php

use yii\db\Migration;

/**
 * Handles the creation for table `img_node`.
 * Has foreign keys to the tables:
 *
 * - `board`
 */
class m160826_113941_create_img_node_table extends Migration
{
    /**
     * @inheritdoc
     */
    public function up()
    {
        $this->createTable('img_node', [
            'id' => $this->primaryKey(),
            'path' => $this->string()->notNull(),
            'x_coordinate' => $this->string(10)->defaultValue('0px')->notNull(),
            'y_coordinate' => $this->string(10)->defaultValue('10px')->notNull(),
            'width' => $this->string(10)->defaultValue('100px')->notNull(),
            'height' => $this->string(10)->defaultValue('50px'),
            'board_id' => $this->integer()->notNull(),
        ]);

        // creates index for column `board_id`
        $this->createIndex(
            'idx-img_node-board_id',
            'img_node',
            'board_id'
        );

        // add foreign key for table `board`
        $this->addForeignKey(
            'fk-img_node-board_id',
            'img_node',
            'board_id',
            'board',
            'id',
            'CASCADE'
        );
    }

    /**
     * @inheritdoc
     */
    public function down()
    {
        // drops foreign key for table `board`
        $this->dropForeignKey(
            'fk-img_node-board_id',
            'img_node'
        );

        // drops index for column `board_id`
        $this->dropIndex(
            'idx-img_node-board_id',
            'img_node'
        );

        $this->dropTable('img_node');
    }
}
