<?php

use yii\db\Schema;
use yii\db\Migration;

class m170828_095426_alter_User_table extends Migration
{
    public function up()
    {
        $this->dropColumn('User', 'userType');
    }

    public function down()
    {
        $this->addColumn('User', 'userType', $this->integer(1));
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
