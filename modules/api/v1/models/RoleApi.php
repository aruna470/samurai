<?php

namespace app\modules\api\v1\models;

use Yii;
use app\models\Role;
use app\modules\api\v1\components\ApiStatusMessages;

class RoleApi extends Role
{
    const SCENARIO_API_CREATE = 'apiCreate';
    const SCENARIO_API_UPDATE = 'apiUpdate';
    const SCENARIO_API_SEARCH = 'apiSearch';

    // Default admin roles
    const SUPER_ADMIN = 'SuperAdmin';
    const SYSTEM_ADMIN = 'SystemAdmin';

    public $limit = 10;
    public $page = 1;

    // To get permissions from db
    public $modelPermissions = array();

    //To get User Permission
    public $userPermissions = array();

    public function rules()
    {
        $scenarioList = [self::SCENARIO_API_CREATE, self::SCENARIO_API_UPDATE];

        return [
            // Role Create/Update
            [['name', 'createdAt', 'description'], 'required',
                'message' => ApiStatusMessages::MISSING_MANDATORY_FIELD, 'on' => $scenarioList],
            [['name'], 'string', 'max' => 30, 'on' => $scenarioList,
                'tooLong' => ApiStatusMessages::EXCEED_CHARACTER_LIMIT],
            [['description'], 'string', 'max' => 60, 'on' => $scenarioList,
                'tooLong' => ApiStatusMessages::EXCEED_CHARACTER_LIMIT],
            [['name'], 'unique', 'on' => $scenarioList,
                'message' => ApiStatusMessages::NAME_EXISTS],
            [['modelPermissions'], 'safe', 'on' => self::SCENARIO_API_UPDATE],

            // API Search
            [['limit', 'page'], 'required', 'message' => ApiStatusMessages::MISSING_MANDATORY_FIELD,
                'on' => self::SCENARIO_API_SEARCH],
            [['limit', 'page'], 'integer', 'message' => ApiStatusMessages::VALIDATION_FAILED,
                'on' => self::SCENARIO_API_SEARCH],
            [['name', 'description'], 'safe', 'on' => self::SCENARIO_API_SEARCH]
        ];
    }


    public function apiSearch()
    {
        $offset = ($this->page - 1) * $this->limit;
        $query = Role::find();
        $query->andFilterWhere(['like', 'name', $this->name])
            ->andWhere('name != :name', ['name' => self::SUPER_ADMIN])
            ->andFilterWhere(['like', 'description', $this->description]);
        $query->limit($this->limit);

        $query->offset($offset);
        $total = $query->count();
        $roles = $query->all();

        return ['total' => $total, 'roles' => $roles];
    }


}