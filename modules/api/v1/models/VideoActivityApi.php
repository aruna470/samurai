<?php

namespace app\modules\api\v1\models;


use app\models\VideoActivity;
use app\modules\api\v1\components\ApiStatusMessages;

class VideoActivityApi extends VideoActivity
{
    const SCENARIO_API_CREATE = 'apiCreate';
    const SCENARIO_API_SEARCH = 'apiSearch';

    // Video States
    //const VIDEO_PLAYING = 1;
    //const VIDEO_PAUSE = 2;

    public $limit = 10;
    public $page = 1;

    public $firstName;
    public $lastName;


    public function rules()
    {
        $scenarioList = [self::SCENARIO_API_CREATE];

        return [
            [['videoRefId', 'deviceId', 'status'], 'required',
                'message' => ApiStatusMessages::MISSING_MANDATORY_FIELD, 'on' => $scenarioList],
            [['videoRefId'], 'string', 'max' => 50, 'on' => $scenarioList,
                'tooLong' => ApiStatusMessages::EXCEED_CHARACTER_LIMIT],
            [['deviceId'], 'string', 'max' => 255, 'on' => $scenarioList,
                'tooLong' => ApiStatusMessages::EXCEED_CHARACTER_LIMIT],
            [['status'], 'integer', 'on' => $scenarioList,
                'message' => ApiStatusMessages::INVALID_DATA_TYPE],

            // API Search
            [['limit', 'page'], 'required', 'message' => ApiStatusMessages::MISSING_MANDATORY_FIELD,
                'on' => self::SCENARIO_API_SEARCH],
            [['limit', 'page'], 'integer', 'message' => ApiStatusMessages::VALIDATION_FAILED,
                'on' => self::SCENARIO_API_SEARCH],
            [['videoRefId', 'deviceId', 'firstName', 'lastName'], 'safe', 'on' => self::SCENARIO_API_SEARCH]
        ];
    }

    /**
     * Search for API requests
     * @return mixed
     */
    public function apiSearch()
    {
        $offset = ($this->page - 1) * $this->limit;
        $query = VideoActivity::find();
        $query->andFilterWhere(['like', 'videoRefId', $this->videoRefId])
            ->andFilterWhere(['like', 'deviceId', $this->deviceId])
            ->andFilterWhere(['like', 'User.firstName', $this->firstName])
            ->andFilterWhere(['like', 'User.lastName', $this->lastName])
            ->andFilterWhere(['like', 'userId', $this->userId]);
        $query->limit($this->limit);
        $query->joinWith('user');

        $query->offset($offset);
        $total = $query->count();
        $logs = $query->all();

        return ['total' => $total, 'logs' => $logs];
    }


}