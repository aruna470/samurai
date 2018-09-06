<?php

use yii\db\Schema;
use yii\db\Migration;

class m171120_074843_add_videoId_column_to_VideoActivity_table extends Migration
{
    public function up()
    {
        $this->addColumn('VideoActivity', 'videoRefId', $this->string(50));
    }

    public function down()
    {
        $this->dropColumn('VideoActivity', 'videoRefId');
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
