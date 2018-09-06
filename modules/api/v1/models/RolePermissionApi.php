<?php

namespace app\modules\api\v1\models;


use app\models\RolePermission;
use app\modules\api\v1\components\ApiStatusMessages;

class RolePermissionApi extends RolePermission
{
    const SCENARIO_API_CREATE = 'apiCreate';
    const SCENARIO_API_UPDATE = 'apiUpdate';

    public function rules()
    {
        $scenarioList = [self::SCENARIO_API_CREATE, self::SCENARIO_API_UPDATE];

        return [
            //Role Create/Update
            [['roleName', 'createdAt', 'permissionName'], 'required',
                'message' => ApiStatusMessages::MISSING_MANDATORY_FIELD, 'on' => $scenarioList],
            [['roleName'], 'string', 'max' => 30, 'on' => $scenarioList,
                'tooLong' => ApiStatusMessages::EXCEED_CHARACTER_LIMIT],
            [['permissionName'], 'string', 'max' => 30, 'on' => $scenarioList,
                'tooLong' => ApiStatusMessages::EXCEED_CHARACTER_LIMIT],
        ];
    }


}