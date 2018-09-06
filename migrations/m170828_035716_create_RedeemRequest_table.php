<?php

use yii\db\Schema;
use yii\db\Migration;

class m170828_035716_create_RedeemRequest_table extends Migration
{
    public function up()
    {
        // Creates Reward table
        $this->createTable('RedeemRequest', [
            'id' => $this->primaryKey(11),
            'requestedById' => $this->integer(11),
            'requestedAmount' => $this->integer(11),
            'createdAt' => $this->dateTime(),
            'status' => $this->smallInteger(1),
            'createdById' => $this->integer(11),
            'updatedAt' => $this->dateTime(),
            'updatedById' => $this->integer(11),
            'INDEX `fk_redeemRequest_User1_idx` (`requestedById` ASC)',
            'INDEX `fk_redeemRequest_User2_idx` (`createdById` ASC)',
            'INDEX `fk_redeemRequest_User3_idx` (`updatedById` ASC)',
        ], 'ENGINE=InnoDB CHARSET=utf8');

        // Add foreign key for table `RedeemRequest`
        $this->addForeignKey(
            'fk_RedeemRequest_User1',
            'RedeemRequest',
            'requestedById',
            'User',
            'id',
            'NO ACTION'
        );

        // Add foreign key for table `RedeemRequest`
        $this->addForeignKey(
            'fk_redeemRequest_User2',
            'RedeemRequest',
            'createdById',
            'User',
            'id',
            'NO ACTION'
        );

        // Add foreign key for table `RedeemRequest`
        $this->addForeignKey(
            'fk_redeemRequest_User3',
            'RedeemRequest',
            'updatedById',
            'User',
            'id',
            'NO ACTION'
        );
    }

    public function down()
    {
        // Drops foreign key for table `RedeemRequest`
        $this->dropForeignKey(
            'fk_RedeemRequest_User1',
            'RedeemRequest'
        );

        // Drops foreign key for table `RedeemRequest`
        $this->dropForeignKey(
            'fk_redeemRequest_User2',
            'RedeemRequest'
        );

        // Drops foreign key for table `RedeemRequest`
        $this->dropForeignKey(
            'fk_redeemRequest_User3',
            'RedeemRequest'
        );

        // Drops user table
        $this->dropTable('RedeemRequest');
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
