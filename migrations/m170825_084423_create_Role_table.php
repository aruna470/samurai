<?php

use yii\db\Schema;
use yii\db\Migration;

class m170825_084423_create_Role_table extends Migration
{
    public function up()
    {
        // Creates Role table
        $this->createTable('Role', [
            'name' => $this->string(30)->notNull(),
            'description' => $this->string(60)->notNull(),
            'createdAt' => $this->dateTime(),
            'updatedAt' => $this->dateTime(),
            'createdById' => $this->integer(11),
            'updatedById' => $this->integer(11),
            'PRIMARY KEY (name)',
            'UNIQUE INDEX `name_UNIQUE` (`name` ASC)',
        ], 'ENGINE=InnoDB CHARSET=utf8');
    }

    public function down()
    {
        $this->execute('SET FOREIGN_KEY_CHECKS=0');

        // Drops Role table
        $this->dropTable('Role');

        $this->execute('SET FOREIGN_KEY_CHECKS=1');
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
