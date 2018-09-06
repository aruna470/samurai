<?php

use yii\db\Schema;
use yii\db\Migration;

class m170828_042833_create_Redeem_table extends Migration
{
    public function up()
    {
        // Creates Redeem table
        $this->createTable('Redeem', [
            'id' => $this->primaryKey(11),
            'userId' => $this->integer(11),
            'redeemedAmount' => $this->integer(11),
            'createdAt' => $this->dateTime(),
            'INDEX `fk_Redeem_User1_idx` (`userId` ASC)',
        ], 'ENGINE=InnoDB CHARSET=utf8');

        // Add foreign key for table `Redeem`
        $this->addForeignKey(
            'fk_Redeem_User1',
            'Redeem',
            'userId',
            'User',
            'id',
            'NO ACTION'
        );
    }

    public function down()
    {
        // Drops foreign key for table `Redeem`
        $this->dropForeignKey(
            'fk_Redeem_User1',
            'Redeem'
        );

        // Drops Redeem table
        $this->dropTable('Redeem');
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
