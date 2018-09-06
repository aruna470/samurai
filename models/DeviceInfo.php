<?php

namespace app\models;

use Yii;
use app\models\Base;

/**
 * This is the model class for table "DeviceInfo".
 *
 * @property integer $id
 * @property integer $userId
 * @property string $uuId
 * @property string $type
 * @property string $token
 * @property string $createdAt
 * @property string $updatedAt
 *
 * @property User $user
 */
class DeviceInfo extends Base
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'DeviceInfo';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['userId'], 'integer'],
            [['createdAt', 'updatedAt'], 'safe'],
            [['uuId'], 'string', 'max' => 100],
            [['type'], 'string', 'max' => 30],
            [['userId'], 'exist', 'skipOnError' => true, 'targetClass' => User::className(), 'targetAttribute' => ['userId' => 'id']],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'userId' => 'User ID',
            'uuId' => 'Uu ID',
            'type' => 'Type',
            'createdAt' => 'Created At',
            'updatedAt' => 'Updated At',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getUser()
    {
        return $this->hasOne(User::className(), ['id' => 'userId']);
    }
}
