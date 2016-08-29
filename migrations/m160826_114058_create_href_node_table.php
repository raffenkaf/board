<?php

use yii\db\Migration;

/**
 * Handles the creation for table `href_node`.
 * Has foreign keys to the tables:
 *
 * - `board`
 */
class m160826_114058_create_href_node_table extends Migration
{
    /**
     * @inheritdoc
     */
    public function up()
    {
        $this->createTable('href_node', [
            'id' => $this->primaryKey(),
            'msg' => $this->text()->notNull(),
            'font-size' => $this->string(10)->defaultValue('16px')->notNull(),
            'color' => $this->string(20)->defaultValue('#000000')->notNull(),
            'bgcolor' => $this->string(20)->defaultValue('#ffffff'),
            'x_coordinate' => $this->string(10)->defaultValue('0px')->notNull(),
            'y_coordinate' => $this->string(10)->defaultValue('0px')->notNull(),
            'address' => $this->string()->notNull(),
            'board_id' => $this->integer()->notNull(),
        ]);

        // creates index for column `board_id`
        $this->createIndex(
            'idx-href_node-board_id',
            'href_node',
            'board_id'
        );

        // add foreign key for table `board`
        $this->addForeignKey(
            'fk-href_node-board_id',
            'href_node',
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
            'fk-href_node-board_id',
            'href_node'
        );

        // drops index for column `board_id`
        $this->dropIndex(
            'idx-href_node-board_id',
            'href_node'
        );

        $this->dropTable('href_node');
    }
}
