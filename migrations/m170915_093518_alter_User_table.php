<?php

use yii\db\Schema;
use yii\db\Migration;

class m170915_093518_alter_User_table extends Migration
{
    public function up()
    {
        $this->addColumn('User', 'passwordResetToken', $this->string(20));
    }

    public function down()
    {
        $this->dropColumn('User', 'passwordResetToken');
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
