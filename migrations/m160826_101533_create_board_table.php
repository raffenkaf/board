<?php

use yii\db\Migration;

/**
 * Handles the creation for table `board`.
 * Has foreign keys to the tables:
 *
 * - `user`
 */
class m160826_101533_create_board_table extends Migration
{
    /**
     * @inheritdoc
     */
    public function up()
    {
        $this->createTable('board', [
            'id' => $this->primaryKey(),
            'create_user_id' => $this->integer()->notNull(),
        ]);

        // creates index for column `create_user_id`
        $this->createIndex(
            'idx-board-create_user_id',
            'board',
            'create_user_id'
        );

        // add foreign key for table `user`
        $this->addForeignKey(
            'fk-board-create_user_id',
            'board',
            'create_user_id',
            'user',
            'id',
            'CASCADE'
        );
    }

    /**
     * @inheritdoc
     */
    public function down()
    {
        // drops foreign key for table `user`
        $this->dropForeignKey(
            'fk-board-create_user_id',
            'board'
        );

        // drops index for column `create_user_id`
        $this->dropIndex(
            'idx-board-create_user_id',
            'board'
        );

        $this->dropTable('board');
    }
}
