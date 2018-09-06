<?php

namespace app\models;

use Yii;
use app\models\Base;

/**
 * This is the model class for table "VideoActivity".
 *
 * @property integer $id
 * @property integer $videoId
 * @property integer $userId
 * @property integer $duration
 * @property string $datetime
 * @property integer $rewards
 * @property string $deviceId
 * @property string $videoRefId
 *
 * @property User $user
 * @property Video $video
 */
class VideoActivity extends Base
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'VideoActivity';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['videoRefId', 'deviceId','status'], 'required'],
            [['videoId', 'userId', 'duration', 'rewards'], 'integer'],
            [['datetime'], 'safe'],
            [['deviceId'], 'string', 'max' => 255],
            [['videoRefId'], 'string', 'max' => 50],
            [['userId'], 'exist', 'skipOnError' => true, 'targetClass' => User::className(), 'targetAttribute' => ['userId' => 'id']],
            [['videoId'], 'exist', 'skipOnError' => true, 'targetClass' => Video::className(), 'targetAttribute' => ['videoId' => 'id']],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'videoId' => 'Video ID',
            'userId' => 'User ID',
            'duration' => 'Duration',
            'datetime' => 'Datetime',
            'rewards' => 'Rewards',
            'deviceId' => 'Device ID',
            'videoRefId' => 'Video Ref ID',
            'status' => 'Status'
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getUser()
    {
        return $this->hasOne(User::className(), ['id' => 'userId']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getVideo()
    {
        return $this->hasOne(Video::className(), ['id' => 'videoId']);
    }
}
