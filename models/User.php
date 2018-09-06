<?php

namespace app\models;

use Yii;
use app\models\Base;

/**
 * This is the model class for table "User".
 *
 * @property integer $id
 * @property string $username
 * @property string $password
 * @property string $firstName
 * @property string $lastName
 * @property string $email
 * @property string $sysEmail
 * @property string $timeZone
 * @property string $roleName
 * @property integer $type
 * @property integer $status
 * @property string $phone
 * @property string $createdAt
 * @property string $updatedAt
 * @property integer $createdById
 * @property integer $updatedById
 * @property string $lastAccess
 * @property string $address
 * @property integer $userType
 * @property string accessToken
 *
 * @property Redeem[] $redeems
 * @property RedeemRequest[] $redeemRequests
 * @property RedeemRequest[] $redeemRequests0
 * @property RedeemRequest[] $redeemRequests1
 * @property Reward $reward
 * @property Role $roleName0
 * @property VideoActivity[] $videoActivities
 */
class User extends Base
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'User';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['type', 'status', 'createdById', 'updatedById', 'userType'], 'integer'],
            [['createdAt', 'updatedAt', 'lastAccess', 'accessToken'], 'safe'],
            [['username', 'password', 'timeZone', 'roleName'], 'string', 'max' => 15],
            [['firstName', 'lastName'], 'string', 'max' => 30],
            [['email', 'sysEmail', 'address'], 'string', 'max' => 60],
            [['phone'], 'string', 'max' => 20],
            [['username'], 'unique'],
            [['email'], 'unique'],
            [['roleName'], 'exist', 'skipOnError' => true, 'targetClass' => Role::className(), 'targetAttribute' => ['roleName' => 'name']],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'username' => 'Username',
            'password' => 'Password',
            'firstName' => 'First Name',
            'lastName' => 'Last Name',
            'email' => 'Email',
            'sysEmail' => 'Sys Email',
            'timeZone' => 'Time Zone',
            'roleName' => 'Role Name',
            'type' => 'Type',
            'status' => 'Status',
            'phone' => 'Phone',
            'createdAt' => 'Created At',
            'updatedAt' => 'Updated At',
            'createdById' => 'Created By ID',
            'updatedById' => 'Updated By ID',
            'lastAccess' => 'Last Access',
            'address' => 'Address',
            'userType' => 'User Type',
            'accessToken' => 'Access Token'
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getRedeems()
    {
        return $this->hasMany(Redeem::className(), ['userId' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getRedeemRequests()
    {
        return $this->hasMany(RedeemRequest::className(), ['requestedById' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getRedeemRequests0()
    {
        return $this->hasMany(RedeemRequest::className(), ['createdById' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getRedeemRequests1()
    {
        return $this->hasMany(RedeemRequest::className(), ['updatedById' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getReward()
    {
        return $this->hasOne(Reward::className(), ['userId' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getRoleName0()
    {
        return $this->hasOne(Role::className(), ['name' => 'roleName']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getVideoActivities()
    {
        return $this->hasMany(VideoActivity::className(), ['userId' => 'id']);
    }

    /**
     * Encrypt password
     * @return string crypt encrypted password.
     */
    public function encryptPassword($password = '')
    {
        return Yii::$app->getSecurity()->generatePasswordHash($password);
    }

}
