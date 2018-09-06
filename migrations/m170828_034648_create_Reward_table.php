<?php

use yii\db\Schema;
use yii\db\Migration;

class m170828_034648_create_Reward_table extends Migration
{
    public function up()
    {
        // Creates Reward table
        $this->createTable('Reward', [
            'userId' => $this->integer(11),
            'totalRewards' => $this->integer(11),
            'redeemedRewards' => $this->integer(11),
            'rewardBalance' => $this->integer(11),
            'PRIMARY KEY (`userId`)'
        ], 'ENGINE=InnoDB CHARSET=utf8');

        // Add foreign key for table `Reward`
        $this->addForeignKey(
            'fk_Reward_User1',
            'Reward',
            'userId',
            'User',
            'id',
            'NO ACTION'
        );
    }

    public function down()
    {
        // Drops foreign key for table `Reward`
        $this->dropForeignKey(
            'fk_Reward_User1',
            'Reward'
        );

        // Drops Reward table
        $this->dropTable('Reward');
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
