<?php

use yii\db\Schema;
use yii\db\Migration;

class m170920_033445_drop_DeviceInfo_table extends Migration
{
    public function up()
    {
        $this->dropColumn('DeviceInfo', 'token');
    }

    public function down()
    {
        echo "m170920_033445_drop_DeviceInfo_table cannot be reverted.\n";

        return false;
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
