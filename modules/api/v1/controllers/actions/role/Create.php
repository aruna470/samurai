<?php

/**
 * Create class
 *
 * Add new Role to the system. system users can only add Role via this action class.
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


class Create extends Action
{
    public function run()
    {
        $params = json_decode(Yii::$app->request->rawBody, true);
        $roleModel = new RoleApi();
        $user = $this->controller->user;
        $roleModel->scenario = RoleApi::SCENARIO_API_CREATE;
        $roleModel->attributes = $params;

        $statusCode = ApiStatusMessages::FAILED;
        $statusMsg = null;
        $attribute = null;

        if ($user->type == UserApi::SYSTEM_USER) {
            $transaction = Yii::$app->db->beginTransaction();
            $allSuccess = true;
            if ($roleModel->saveModel()) {
                if (!empty($params['permissions'])) {
                    foreach ($params['permissions'] as $permission) {
                        $roleModelPermission = new RolePermissionApi();
                        $roleModelPermission->attributes = $params;
                        $roleModelPermission->roleName = $roleModel->name;
                        $roleModelPermission->permissionName = $permission;
                        if ($roleModelPermission->saveModel()) {
                            $allSuccess = true;
                        } else {
                            Yii::$app->appLog->writeLog('Role Permission create failed.');
                            $allSuccess = false;
                            break;
                        }
                    }
                } else {
                    $allSuccess = true;
                }

            } else {
                $attribute = $roleModel->invalAttrib;
                $statusCode = $roleModel->statusCode;
                Yii::$app->appLog->writeLog('Role create failed.');
                $allSuccess = false;
            }

            if ($allSuccess) {
                $transaction->commit();
                $statusCode = ApiStatusMessages::SUCCESS;
                Yii::$app->appLog->writeLog('Commit transaction');
            } else {
                $transaction->rollBack();
                Yii::$app->appLog->writeLog('Rollback transaction');
            }


        } else {
            $statusCode = ApiStatusMessages::PERMISSION_DENIED;
        }

        $response = Messages::commonStatus($statusCode, $statusMsg, [], $attribute);
        $this->controller->sendResponse($response);
    }
}