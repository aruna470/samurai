<?php

namespace app\models;

use Yii;
use app\models\Base;

/**
 * This is the model class for table "RolePermission".
 *
 * @property string $roleName
 * @property string $permissionName
 * @property string $createdAt
 * @property string $updatedAt
 * @property integer $createdById
 * @property integer $updatedById
 *
 * @property Permission $permissionName0
 * @property Role $roleName0
 */
class RolePermission extends Base
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'RolePermission';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['roleName', 'permissionName'], 'required'],
            [['createdAt', 'updatedAt'], 'safe'],
            [['createdById', 'updatedById'], 'integer'],
            [['roleName', 'permissionName'], 'string', 'max' => 30],
            [['permissionName'], 'exist', 'skipOnError' => true, 'targetClass' => Permission::className(), 'targetAttribute' => ['permissionName' => 'name']],
            [['roleName'], 'exist', 'skipOnError' => true, 'targetClass' => Role::className(), 'targetAttribute' => ['roleName' => 'name']],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'roleName' => 'Role Name',
            'permissionName' => 'Permission Name',
            'createdAt' => 'Created At',
            'updatedAt' => 'Updated At',
            'createdById' => 'Created By ID',
            'updatedById' => 'Updated By ID',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getPermissionName()
    {
        return $this->hasOne(Permission::className(), ['name' => 'permissionName']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getRoleName()
    {
        return $this->hasOne(Role::className(), ['name' => 'roleName']);
    }

    /*public static function find()
    {
        return new RolePermissionQuery(get_called_class());
    }*/
}
