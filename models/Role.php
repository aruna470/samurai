<?php

namespace app\models;

use Yii;
use app\models\Base;

/**
 * This is the model class for table "Role".
 *
 * @property string $name
 * @property string $description
 * @property string $createdAt
 * @property string $updatedAt
 * @property integer $createdById
 * @property integer $updatedById
 *
 * @property RolePermission[] $rolePermissions
 * @property Permission[] $permissionNames
 */
class Role extends Base
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'Role';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['name', 'description'], 'required'],
            [['createdAt', 'updatedAt'], 'safe'],
            [['createdById', 'updatedById'], 'integer'],
            [['name'], 'string', 'max' => 30],
            [['description'], 'string', 'max' => 60],
            [['name'], 'unique'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'name' => 'Name',
            'description' => 'Description',
            'createdAt' => 'Created At',
            'updatedAt' => 'Updated At',
            'createdById' => 'Created By ID',
            'updatedById' => 'Updated By ID',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getRolePermissions()
    {
        return $this->hasMany(RolePermission::className(), ['roleName' => 'name']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getPermissionNames()
    {
        return $this->hasMany(Permission::className(), ['name' => 'permissionName'])->viaTable('RolePermission', ['roleName' => 'name']);
    }



    /*public static function find()
    {
        return new RoleQuery(get_called_class());
    }*/
}
