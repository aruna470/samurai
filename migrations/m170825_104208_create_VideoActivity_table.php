<?php

use yii\db\Schema;
use yii\db\Migration;

class m170825_104208_create_VideoActivity_table extends Migration
{
    public function up()
    {
        // Creates VideoActivity table
        $this->createTable('VideoActivity', [
            'id' => $this->primaryKey(11),
            'videoId' => $this->integer(11),
            'userId' => $this->integer(11),
            'duration' => $this->integer(11),
            'datetime' => $this->dateTime(),
            'rewards' => $this->integer(11),
            'INDEX `fk_VideoActivity_User1_idx` (`userId` ASC)',
            'INDEX `fk_VideoActivity_Video1_idx` (`videoId` ASC)'
        ], 'ENGINE=InnoDB CHARSET=utf8');

        // Add foreign key for table `VideoActivity`
        $this->addForeignKey(
            'fk_VideoActivity_User1',
            'VideoActivity',
            'userId',
            'User',
            'id',
            'NO ACTION'
        );

        // Add foreign key for table `VideoActivity`
        $this->addForeignKey(
            'fk_VideoActivity_Video1',
            'VideoActivity',
            'videoId',
            'Video',
            'id',
            'NO ACTION'
        );
    }

    public function down()
    {
        // Drops foreign key for table `VideoActivity`
        $this->dropForeignKey(
            'fk_VideoActivity_User1',
            'VideoActivity'
        );

        // Drops foreign key for table `VideoActivity`
        $this->dropForeignKey(
            'fk_VideoActivity_Video1',
            'VideoActivity'
        );

        // Drops index for column `updatedById`
        $this->dropIndex(
            'fk_VideoActivity_User1_idx',
            'VideoActivity'
        );

        // Drops index for column `videoCategoryId`
        $this->dropIndex(
            'fk_VideoActivity_Video1_idx',
            'VideoActivity'
        );


        // Drops user table
        $this->dropTable('VideoActivity');
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
