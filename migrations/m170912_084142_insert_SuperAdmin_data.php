<?php

use yii\db\Schema;
use yii\db\Migration;

class m170912_084142_insert_SuperAdmin_data extends Migration
{
    public function up()
    {
        $this->insert('Role', [
            'name' => 'SuperAdmin',
            'description' => 'Super administrator',
            'createdAt' => date('Y-m-d H:i:s'),
        ]);

        $this->insert('User', [
            'id' => 1,
            'password' => '$2y$13$vtFvjwUC7/.CSHEwZvzFau1xzvd.tjM1HCZ6t9pGJoLPeIqPhXx/2', // password is test.123
            'firstName' => 'Super',
            'lastName' => 'Administrator',
            'sysEmail' => 'super@gmail.com',
            'timeZone' => 'Europe/Paris',
            'roleName' => 'SuperAdmin',
            'type' => 1,
            'status' => 1,
            'phone' => '+9477395698',
            'createdAt' => date('Y-m-d H:i:s'),
            'gender' => 1,
            'loginType' => 1
        ]);
    }

    public function down()
    {
        $this->delete('User', ['id' => 1]);
        $this->delete('Role', ['name' => 'SuperAdmin']);
    }


    /*
     * INSERT INTO `User` VALUES (1,NULL,'$2y$13$vtFvjwUC7/.CSHEwZvzFau1xzvd.tjM1HCZ6t9pGJoLPeIqPhXx/2','Super','Administrator',NULL,'super@gmail.com','Europe/Paris','SuperAdmin',1,1,'+9477395698','2017-08-31 08:44:18',NULL,NULL,NULL,NULL,NULL,NULL,1,'2001-03-03',1,NULL)
     */

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
