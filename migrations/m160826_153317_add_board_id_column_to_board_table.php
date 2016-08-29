<?php

use yii\db\Migration;

/**
 * Handles adding board_id to table `board`.
 * Has foreign keys to the tables:
 *
 * - `board`
 */
class m160826_153317_add_board_id_column_to_board_table extends Migration
{
    /**
     * @inheritdoc
     */
    public function up()
    {
        $this->addColumn('board', 'board_id', $this->integer());

        // creates index for column `board_id`
        $this->createIndex(
            'idx-board-board_id',
            'board',
            'board_id'
        );

        // add foreign key for table `board`
        $this->addForeignKey(
            'fk-board-board_id',
            'board',
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
            'fk-board-board_id',
            'board'
        );

        // drops index for column `board_id`
        $this->dropIndex(
            'idx-board-board_id',
            'board'
        );

        $this->dropColumn('board', 'board_id');
    }
}
