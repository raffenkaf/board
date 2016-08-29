<?php

use yii\db\Migration;

/**
 * Handles adding name to table `board`.
 */
class m160826_135214_add_name_column_to_board_table extends Migration
{
    /**
     * @inheritdoc
     */
    public function up()
    {
        $this->addColumn('board', 'name', $this->string()->notNull());
    }

    /**
     * @inheritdoc
     */
    public function down()
    {
        $this->dropColumn('board', 'name');
    }
}
