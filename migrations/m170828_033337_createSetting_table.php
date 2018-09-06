<?php

use yii\db\Schema;
use yii\db\Migration;

class m170828_033337_createSetting_table extends Migration
{
    public function up()
    {
        // Creates Setting table
        $this->createTable('Setting', [
            'key' => $this->string(20),
            'value' => $this->string(100),
            'PRIMARY KEY (`key`)'
        ], 'ENGINE=InnoDB CHARSET=utf8');
    }

    public function down()
    {
        // Drops Setting table
        $this->dropTable('Setting');
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
