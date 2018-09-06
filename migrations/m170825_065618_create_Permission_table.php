<?php

use yii\db\Schema;
use yii\db\Migration;

class m170825_065618_create_Permission_table extends Migration
{
    public function up()
    {
        // Creates Permission table
        $this->createTable('Permission', [
            'name' => $this->string(30)->notNull(),
            'description' => $this->string(60)->notNull(),
            'category' => $this->string(30)->notNull(),
            'createdAt' => $this->dateTime(),
            'updatedAt' => $this->dateTime(),
            'createdById' => $this->integer(11),
            'updatedById' => $this->integer(11),
            'PRIMARY KEY (name)',
        ], 'ENGINE=InnoDB CHARSET=utf8');
    }

    public function down()
    {
        // Drops permission table
        $this->dropTable('Permission');
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
