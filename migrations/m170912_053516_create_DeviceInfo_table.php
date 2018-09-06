<?php

use yii\db\Schema;
use yii\db\Migration;

class m170912_053516_create_DeviceInfo_table extends Migration
{
    public function up()
    {
        $this->execute('SET FOREIGN_KEY_CHECKS=0');

        // Creates User table
        $this->createTable('DeviceInfo', [
            'id' => $this->primaryKey(11),
            'userId' => $this->integer(11),
            'uuId' => $this->string(100),
            'type' => $this->string(30),
            'token' => $this->string(300),
            'createdAt' => $this->dateTime(),
            'updatedAt' => $this->dateTime(),
        ], 'ENGINE=InnoDB CHARSET=utf8');

        // Creates index for column `userId`
        $this->createIndex(
            'fk_DeviceInfo_User_idx',
            'DeviceInfo',
            'userId'
        );

        // Add foreign key for table `User`
        $this->addForeignKey(
            'fk_DeviceInfo_User',
            'DeviceInfo',
            'userId',
            'User',
            'id',
            'NO ACTION'
        );

        $this->execute('SET FOREIGN_KEY_CHECKS=1');

    }

    public function down()
    {

        // Drops foreign key for table `DeviceInfo`
        $this->dropForeignKey(
            'fk_DeviceInfo_User',
            'DeviceInfo'
        );

        // Drops index for column `userId`
        $this->dropIndex(
            'fk_DeviceInfo_User_idx',
            'User'
        );

        // Drops DeviceInfo table
        $this->dropTable('DeviceInfo');
    }
}
