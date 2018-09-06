<?php
/**
 * Delete class
 *
 * Delete permission. System users can delete the permissions via this action class.
 *
 * @author  Nasmy Nizam <nasmy@keeneye.solutions>
 */

namespace app\modules\api\v1\controllers\actions\permission;


use app\modules\api\v1\components\ApiStatusMessages;
use app\modules\api\v1\components\Messages;
use app\modules\api\v1\models\PermissionApi;
use app\modules\api\v1\models\UserApi;
use Yii;
use yii\base\Action;

class Delete extends Action
{
    public function run()
    {
        $permissionName = Yii::$app->request->get('name');
        $model = PermissionApi::findOne($permissionName);
        $user = $this->controller->user;

        $response = [];
        $statusMsg = null;
        $attribute = null;
        $data = [];
        $statusCode = ApiStatusMessages::FAILED;

        if (!empty($model)) {
            if ($user->type == UserApi::SYSTEM_USER) {
                if (!$model->deleteModel()) {
                    $statusCode = ApiStatusMessages::PERMISSION_IN_USE;
                } else {
                    $statusCode = ApiStatusMessages::SUCCESS;
                }
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