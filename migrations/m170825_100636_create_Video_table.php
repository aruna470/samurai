<?php

use yii\db\Schema;
use yii\db\Migration;

class m170825_100636_create_Video_table extends Migration
{
    public function up()
    {
        $this->execute('SET FOREIGN_KEY_CHECKS=0');

        // Creates Video table
        $this->createTable('Video', [
            'id' => $this->primaryKey(11),
            'name' => $this->string(45),
            'videoCategoryId' => $this->integer(2),
            'videoReferenceId' => $this->string(45),
            'url' => $this->text(),
            'source' => $this->smallInteger(1),
            'rewardPoints' => $this->integer(5),
            'createdAt' => $this->dateTime(),
            'updatedAt' => $this->dateTime(),
            'updatedById' => $this->integer(11),
            'INDEX `fk_Video_User1_idx` (`updatedById` ASC)',
            'INDEX `fk_Video_VideoCategory1_idx` (`videoCategoryId` ASC)'
        ], 'ENGINE=InnoDB CHARSET=utf8');

        // Add foreign key for table `Video`
        $this->addForeignKey(
            'fk_Video_User1',
            'Video',
            'updatedById',
            'User',
            'id',
            'NO ACTION'
        );

        // Add foreign key for table `Video`
        $this->addForeignKey(
            'fk_Video_VideoCategory1',
            'Video',
            'videoCategoryId',
            'VideoCategory',
            'id',
            'NO ACTION'
        );

        $this->execute('SET FOREIGN_KEY_CHECKS=1');
    }

    public function down()
    {
        // Drops foreign key for table `User`
        $this->dropForeignKey(
            'fk_Video_User1',
            'Video'
        );

        // Drops foreign key for table `User`
        $this->dropForeignKey(
            'fk_Video_VideoCategory1',
            'Video'
        );

        // Drops index for column `updatedById`
        $this->dropIndex(
            'fk_Video_User1_idx',
            'Video'
        );

        // Drops index for column `videoCategoryId`
        $this->dropIndex(
            'fk_Video_VideoCategory1_idx',
            'Video'
        );

        // Drops user table
        $this->dropTable('Video');
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
