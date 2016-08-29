<?php

use yii\db\Migration;

/**
 * Handles adding board_id to table `chat`.
 * Has foreign keys to the tables:
 *
 * - `board`
 */
class m160826_153508_add_board_id_column_to_chat_table extends Migration
{
    /**
     * @inheritdoc
     */
    public function up()
    {
        $this->addColumn('chat', 'board_id', $this->integer());

        // creates index for column `board_id`
        $this->createIndex(
            'idx-chat-board_id',
            'chat',
            'board_id'
        );

        // add foreign key for table `board`
        $this->addForeignKey(
            'fk-chat-board_id',
            'chat',
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
            'fk-chat-board_id',
            'chat'
        );

        // drops index for column `board_id`
        $this->dropIndex(
            'idx-chat-board_id',
            'chat'
        );

        $this->dropColumn('chat', 'board_id');
    }
}
