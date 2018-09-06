<?php

use yii\db\Schema;
use yii\db\Migration;

class m170829_091900_alter_User_table extends Migration
{
    public function up()
    {
        $this->addColumn('User', 'accessToken', $this->string(30));
    }

    public function down()
    {
        $this->dropColumn('User', 'accessToken');
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
