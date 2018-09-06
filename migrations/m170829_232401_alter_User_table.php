<?php

use yii\db\Schema;
use yii\db\Migration;

class m170829_232401_alter_User_table extends Migration
{
    public function up()
    {
        $this->addColumn('User', 'fbId', $this->string(30));
        $this->addColumn('User', 'gender', $this->smallInteger(1));
        $this->addColumn('User', 'dob', $this->date());
        $this->addColumn('User', 'loginType', $this->smallInteger(1));
    }

    public function down()
    {
        $this->dropColumn('User', 'fbId');
        $this->dropColumn('User', 'gender');
        $this->dropColumn('User', 'dob');
        $this->dropColumn('User', 'loginType');
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
