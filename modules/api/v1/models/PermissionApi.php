<?php

namespace app\modules\api\v1\models;


use app\models\Permission;
use app\modules\api\v1\components\ApiStatusMessages;
use yii\data\ActiveDataProvider;

class PermissionApi extends Permission
{
    const SCENARIO_API_CREATE = 'apiCreate';
    const SCENARIO_API_UPDATE = 'apiUpdate';
    const SCENARIO_API_SEARCH = 'apiSearch';

    public $limit = 10;
    public $page = 1;

    public function rules()
    {
        $scenarioList = [self::SCENARIO_API_CREATE, self::SCENARIO_API_UPDATE];

        return [
            //Permission Create/Update
            [['name', 'createdAt', 'description', 'category'], 'required',
                'message' => ApiStatusMessages::MISSING_MANDATORY_FIELD, 'on' => $scenarioList],
            [['name'], 'string', 'max' => 30, 'on' => $scenarioList,
                'tooLong' => ApiStatusMessages::EXCEED_CHARACTER_LIMIT],
            [['description'], 'string', 'max' => 60, 'on' => $scenarioList,
                'tooLong' => ApiStatusMessages::EXCEED_CHARACTER_LIMIT],
            [['category'], 'string', 'max' => 30, 'on' => $scenarioList,
                'tooLong' => ApiStatusMessages::EXCEED_CHARACTER_LIMIT],
            [['name'], 'unique', 'on' => $scenarioList,
                'message' => ApiStatusMessages::NAME_EXISTS],

            // API Search
            [['limit', 'page'], 'required', 'message' => ApiStatusMessages::MISSING_MANDATORY_FIELD,
                'on' => self::SCENARIO_API_SEARCH],
            [['limit', 'page'], 'integer', 'message' => ApiStatusMessages::VALIDATION_FAILED,
                'on' => self::SCENARIO_API_SEARCH],
            [['name', 'description', 'category'], 'safe', 'on' => self::SCENARIO_API_SEARCH]
        ];
    }

    /**
     * Search for API requests
     * @return mixed
     */
    public function apiSearch()
    {
        $offset = ($this->page - 1) * $this->limit;
        $query = Permission::find();
        $query->andFilterWhere(['like', 'name', $this->name])
            ->andFilterWhere(['like', 'description', $this->description])
            ->andFilterWhere(['like', 'category', $this->category]);
        $query->limit($this->limit);

        $query->offset($offset);
        $total = $query->count();
        $permissions = $query->all();

        return ['total' => $total, 'permissions' => $permissions];
    }


}