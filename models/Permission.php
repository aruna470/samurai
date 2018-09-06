<?php

namespace app\models;

use Yii;
use app\models\Base;

/**
 * This is the model class for table "Permission".
 *
 * @property string $name
 * @property string $description
 * @property string $category
 * @property string $createdAt
 * @property string $updatedAt
 * @property integer $createdById
 * @property integer $updatedById
 *
 * @property RolePermission[] $rolePermissions
 * @property Role[] $roleNames
 */
class Permission extends Base
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'Permission';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['name', 'description', 'category'], 'required'],
            [['createdAt', 'updatedAt'], 'safe'],
            [['createdById', 'updatedById'], 'integer'],
            [['name', 'category'], 'string', 'max' => 30],
            [['description'], 'string', 'max' => 60],
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
            'category' => 'Category',
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
        return $this->hasMany(RolePermission::className(), ['permissionName' => 'name']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getRoleNames()
    {
        return $this->hasMany(Role::className(), ['name' => 'roleName'])->viaTable('RolePermission', ['permissionName' => 'name']);
    }
}
