<?php
/**
 * Update class
 *
 * Update existing Role. System users can update Role via this action class.
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

class Update extends Action
{
    public function run()
    {
        $params = json_decode(Yii::$app->request->rawBody, true);
        $user = $this->controller->user;
        $roleName = Yii::$app->request->get('name');
        $model = RoleApi::findOne($roleName);

        $statusCode = ApiStatusMessages::FAILED;
        $statusMsg = null;
        $attribute = null;

        if (!empty($model)) {
            if ($user->type == UserApi::SYSTEM_USER) {
                $model->scenario = RoleApi::SCENARIO_API_UPDATE;
                $model->attributes = $params;

                $transaction = Yii::$app->db->beginTransaction();
                $allSuccess = true;
                RolePermissionApi::deleteAll(['roleName' => $roleName]);
                if ($model->saveModel()) {
                    foreach ($params['permissions'] as $permission) {
                        $modelRolePermission = new RolePermissionApi();
                        $modelRolePermission->roleName = $model->name;
                        $modelRolePermission->permissionName = $permission;
                        if (!$modelRolePermission->saveModel()) {
                            $allSuccess = false;
                            break;
                        }
                    }
                } else {
                    $attribute = $model->invalAttrib;
                    $statusCode = $model->statusCode;
                    Yii::$app->appLog->writeLog('Role create failed.');
                    $allSuccess = false;
                }

                // Check transaction Success or not
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
        } else {
            $statusCode = ApiStatusMessages::FAILED;
        }

        $response = Messages::commonStatus($statusCode, $statusMsg, [], $attribute);
        $this->controller->sendResponse($response);
    }

}