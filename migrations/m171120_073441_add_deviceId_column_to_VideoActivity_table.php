<?php

use yii\db\Schema;
use yii\db\Migration;

class m171120_073441_add_deviceId_column_to_VideoActivity_table extends Migration
{
    public function up()
    {
        $this->addColumn('VideoActivity', 'deviceId', $this->string(255));
    }

    public function down()
    {
        $this->dropColumn('VideoActivity', 'deviceId');
    }

}
