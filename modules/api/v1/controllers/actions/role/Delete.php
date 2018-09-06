<?php
/**
 * Delete class
 *
 * Delete existing Role. System users can delete Role via this action class.
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

class Delete extends Action
{
    public function run()
    {
        $roleName = Yii::$app->request->get('name');
        $model = RoleApi::findOne($roleName);
        $user = $this->controller->user;

        $statusCode = ApiStatusMessages::FAILED;
        $statusMsg = null;
        $attribute = null;

        // Get user details to check whether role is assigned to any user.
        if (isset($model->name)) {
            $userModel = UserApi::findOne(['roleName' => $model->name]);
        } else {
            $userModel = null;
        }

        if (!empty($model)) {
            if ($user->type == UserApi::SYSTEM_USER) {
                if (empty($userModel)) {
                    $allSuccess = true;
                    $transaction = Yii::$app->db->beginTransaction();
                    $rolePermissionModel = RolePermissionApi::findAll(['roleName' => $model->name]);

                    if (!empty($rolePermissionModel)) {
                        RolePermissionApi::deleteAll(['roleName' => $model->name]);
                    }

                    if (!$model->deleteModel()) {
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
                    Yii::$app->appLog->writeLog('First delete users associated with this role');
                    $statusCode = ApiStatusMessages::ROLE_IN_USE;
                }
            } else {
                $statusCode = ApiStatusMessages::PERMISSION_DENIED;
            }
        } else {
            $statusCode = ApiStatusMessages::RECORD_NOT_EXISTS;
        }

        $response = Messages::commonStatus($statusCode, $statusMsg, [], $attribute);
        $this->controller->sendResponse($response);
    }
}