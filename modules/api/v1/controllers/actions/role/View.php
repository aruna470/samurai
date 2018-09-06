<?php
/**
 * View class
 *
 * View roles . System users can view roles via this action class.
 *
 * @author  Nasmy Nizam <nasmy@keeneye.solutions>
 */

namespace app\modules\api\v1\controllers\actions\role;


use app\modules\api\v1\components\ApiStatusMessages;
use app\modules\api\v1\components\Messages;
use app\modules\api\v1\models\RoleApi;
use app\modules\api\v1\models\RolePermissionApi;
use app\modules\api\v1\models\UserApi;
use Yii;
use yii\base\Action;

class View extends Action
{
    public function run()
    {
        $user = $this->controller->user;
        $roleName = Yii::$app->request->get('name');
        $model = RoleApi::findOne($roleName);
        $model->modelPermissions = RolePermissionApi::findAll(['roleName' => $roleName]);
        $permissions = [];

        foreach ($model->modelPermissions as $permission) {
            $permissions[] = $permission->permissionName;
        }

        $statusCode = ApiStatusMessages::FAILED;
        $response = [];
        $statusMsg = null;
        $attribute = null;
        $data = [];

        if (!empty($model)) {
            if ($user->type == UserApi::SYSTEM_USER) {
                $statusCode = ApiStatusMessages::SUCCESS;
                $data['role'] = Messages::role($model, $permissions);
            } else {
                $statusCode = ApiStatusMessages::PERMISSION_DENIED;
                Yii::$app->appLog->writeLog('Permission denied.');
            }
        } else {
            $statusCode = ApiStatusMessages::RECORD_NOT_EXISTS;
            Yii::$app->appLog->writeLog('Record not exists.');
        }

        $response = Messages::commonStatus($statusCode, $statusMsg, $data, $attribute);
        $this->controller->sendResponse($response);
    }


}