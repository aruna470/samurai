<?php

use yii\db\Schema;
use yii\db\Migration;

class m171121_060106_add_status_column_to_VideoActivity_table extends Migration
{
    public function up()
    {
        $this->addColumn('VideoActivity', 'status', $this->integer());
    }

    public function down()
    {
        $this->dropColumn('VideoActivity', 'status');
    }

    /*
    // Use safeUp/safeDown to run migration code within a transaction
    public function safeUp()
    {
    }

    public function safeDown()
    {
    }
    */
}
