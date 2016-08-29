<?php

use yii\db\Migration;

/**
 * Handles the creation for table `chat`.
 */
class m160826_153046_create_chat_table extends Migration
{
    /**
     * @inheritdoc
     */
    public function up()
    {
        $this->createTable('chat', [
            'id' => $this->primaryKey(),
            'msg' => $this->text()->notNull(),
            'author' => $this->string(200)->notNull(),
            'created_at'=> $this->timestamp(),
        ]);
    }

    /**
     * @inheritdoc
     */
    public function down()
    {
        $this->dropTable('chat');
    }
}
