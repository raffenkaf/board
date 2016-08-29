<?php

use yii\db\Migration;

/**
 * Handles the creation for table `text_node`.
 * Has foreign keys to the tables:
 *
 * - `board`
 */
class m160826_114019_create_text_node_table extends Migration
{
    /**
     * @inheritdoc
     */
    public function up()
    {
        $this->createTable('text_node', [
            'id' => $this->primaryKey(),
            'msg' => $this->text()->notNull(),
            'font-size' => $this->string(10)->defaultValue('16px')->notNull(),
            'color' => $this->string(20)->defaultValue('#000000')->notNull(),
            'bgcolor' => $this->string(20)->defaultValue('#ffffff'),
            'x_coordinate' => $this->string(10)->defaultValue('0px')->notNull(),
            'y_coordinate' => $this->string(10)->defaultValue('0px')->notNull(),
            'board_id' => $this->integer()->notNull(),
        ]);

        // creates index for column `board_id`
        $this->createIndex(
            'idx-text_node-board_id',
            'text_node',
            'board_id'
        );

        // add foreign key for table `board`
        $this->addForeignKey(
            'fk-text_node-board_id',
            'text_node',
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
            'fk-text_node-board_id',
            'text_node'
        );

        // drops index for column `board_id`
        $this->dropIndex(
            'idx-text_node-board_id',
            'text_node'
        );

        $this->dropTable('text_node');
    }
}
