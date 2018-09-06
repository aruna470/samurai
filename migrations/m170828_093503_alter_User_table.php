<?php

use yii\db\Schema;
use yii\db\Migration;

class m170828_093503_alter_User_table extends Migration
{
    public function up()
    {
        $this->execute('ALTER TABLE `User` CHANGE `password` `password` VARCHAR(100) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL ');
    }

    public function down()
    {
        $this->execute('ALTER TABLE `User` CHANGE `password` `password` VARCHAR(15) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL ');
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
