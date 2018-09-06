<?php

use yii\db\Schema;
use yii\db\Migration;

class m170825_103639_create_VideoCategory_table extends Migration
{
    public function up()
    {
        // Creates VideoCategory table
        $this->createTable('VideoCategory', [
            'id' => $this->primaryKey(11),
            'name' => $this->string(45),
        ], 'ENGINE=InnoDB CHARSET=utf8');
    }

    public function down()
    {
        $this->execute('SET FOREIGN_KEY_CHECKS=0');

        // Drops user table
        $this->dropTable('VideoCategory');

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
