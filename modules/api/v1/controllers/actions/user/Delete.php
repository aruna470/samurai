<?php
/**
 * Delete class
 *
 * Delete Existing User. Both system users and normal users update via this action class.
 *
 * @author  Nasmy Nizam <nasmy@keeneye.solutions>
 */

namespace app\modules\api\v1\controllers\actions\user;


use app\modules\api\v1\components\ApiStatusMessages;
use app\modules\api\v1\components\Messages;
use app\modules\api\v1\models\UserApi;
use Yii;
use yii\base\Action;

class Delete extends Action
{
    public function run()
    {
        $userId = Yii::$app->request->get('id');
        $model = UserApi::findOne($userId);
        $user = $this->controller->user;

        $response = [];
        $statusMsg = null;
        $attribute = null;
        $data = [];
        $statusCode = ApiStatusMessages::FAILED;

        if (!empty($model)) {
            if ($user->type == UserApi::SYSTEM_USER) {
                if (!$model->deleteModel()) {
                    $statusCode = ApiStatusMessages::USER_IN_USE;
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