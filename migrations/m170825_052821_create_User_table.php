<?php

use yii\db\Schema;
use yii\db\Migration;

class m170825_052821_create_User_table extends Migration
{
    public function up()
    {
        $this->execute('SET FOREIGN_KEY_CHECKS=0');

        // Creates User table
        $this->createTable('User', [
            'id' => $this->primaryKey(11),
            'username' => $this->string(15)->unique(),
            'password' => $this->string(15),
            'firstName' => $this->string(30),
            'lastName' => $this->string(30),
            'email' => $this->string(60)->unique(),
            'sysEmail' => $this->string(60),
            'timeZone' => $this->string(15),
            'roleName' => $this->string(15),
            'type' => $this->smallInteger(1),
            'status' => $this->smallInteger(15),
            'phone' => $this->string(20),
            'createdAt' => $this->dateTime(),
            'updatedAt' => $this->dateTime(),
            'createdById' => $this->integer(11),
            'updatedById' => $this->integer(11),
            'lastAccess' => $this->dateTime(),
            'address' => $this->string(60),
            'userType' => $this->integer(11),
        ], 'ENGINE=InnoDB CHARSET=utf8');

        // Creates index for column `roleName`
        $this->createIndex(
            'fk_User_Role1_idx',
            'User',
            'roleName'
        );

        // Add foreign key for table `User`
        $this->addForeignKey(
            'fk_User_Role1',
            'User',
            'roleName',
            'Role',
            'name',
            'NO ACTION'
        );

        $this->execute('SET FOREIGN_KEY_CHECKS=1');
    }

    public function down()
    {
        // Drops foreign key for table `User`
        $this->dropForeignKey(
            'fk_User_Role1',
            'User'
        );

        // Drops index for column `roleName`
        $this->dropIndex(
            'fk_User_Role1_idx',
            'User'
        );

        // Drops user table
        $this->dropTable('User');
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
