<?php

use yii\db\Schema;
use yii\db\Migration;

class m170825_092214_create_RolePermission_table extends Migration
{
    public function up()
    {
        // Creates RolePermission table
        $this->createTable('RolePermission', [
            'roleName' => $this->string(30)->notNull(),
            'permissionName' => $this->string(30)->notNull(),
            'createdAt' => $this->dateTime(),
            'updatedAt' => $this->dateTime(),
            'createdById' => $this->integer(11),
            'updatedById' => $this->integer(11),
            'PRIMARY KEY (`roleName`, `permissionName`)',
            'INDEX `fk_RolePermission_Role1_idx` (`roleName` ASC)',
            'INDEX `fk_RolePermission_Permission1_idx` (`permissionName` ASC)',
        ], 'ENGINE=InnoDB CHARSET=utf8');

        // Add foreign key for table `RolePermission`
        $this->addForeignKey(
            'fk_RolePermission_Permission1',
            'RolePermission',
            'permissionName',
            'Permission',
            'name',
            'NO ACTION'
        );

        // Add foreign key for table `RolePermission`
        $this->addForeignKey(
            'fk_RolePermission_Role1',
            'RolePermission',
            'roleName',
            'Role',
            'name',
            'NO ACTION'
        );
    }

    public function down()
    {
        // Drops foreign key for table `RolePermission`
        $this->dropForeignKey(
            'fk_RolePermission_Permission1',
            'RolePermission'
        );

        // Drops foreign key for table `RolePermission`
        $this->dropForeignKey(
            'fk_RolePermission_Role1',
            'RolePermission'
        );

        // Drop `RolePermission` table
        $this->dropTable('RolePermission');
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
