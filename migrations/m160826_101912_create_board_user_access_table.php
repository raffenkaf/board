<?php

use yii\db\Migration;

/**
 * Handles the creation for table `board_user_access`.
 * Has foreign keys to the tables:
 *
 * - `user`
 * - `board`
 */
class m160826_101912_create_board_user_access_table extends Migration
{
    /**
     * @inheritdoc
     */
    public function up()
    {
        $this->createTable('board_user_access', [
            'id' => $this->primaryKey(),
            'user_id' => $this->integer()->notNull(),
            'board_id' => $this->integer()->notNull(),
        ]);

        // creates index for column `user_id`
        $this->createIndex(
            'idx-board_user_access-user_id',
            'board_user_access',
            'user_id'
        );

        // add foreign key for table `user`
        $this->addForeignKey(
            'fk-board_user_access-user_id',
            'board_user_access',
            'user_id',
            'user',
            'id',
            'CASCADE'
        );

        // creates index for column `board_id`
        $this->createIndex(
            'idx-board_user_access-board_id',
            'board_user_access',
            'board_id'
        );

        // add foreign key for table `board`
        $this->addForeignKey(
            'fk-board_user_access-board_id',
            'board_user_access',
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
        // drops foreign key for table `user`
        $this->dropForeignKey(
            'fk-board_user_access-user_id',
            'board_user_access'
        );

        // drops index for column `user_id`
        $this->dropIndex(
            'idx-board_user_access-user_id',
            'board_user_access'
        );

        // drops foreign key for table `board`
        $this->dropForeignKey(
            'fk-board_user_access-board_id',
            'board_user_access'
        );

        // drops index for column `board_id`
        $this->dropIndex(
            'idx-board_user_access-board_id',
            'board_user_access'
        );

        $this->dropTable('board_user_access');
    }
}
