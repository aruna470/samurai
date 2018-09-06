<?php

use yii\db\Schema;
use yii\db\Migration;

class m170919_101229_alter_User_table extends Migration
{
    public function up()
    {
        $this->addColumn('User', 'userOwnDeviceTypes', $this->string(10));
    }

    public function down()
    {
        $this->dropColumn('User', 'userOwnDeviceTypes');
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
