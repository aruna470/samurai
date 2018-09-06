<?php
/**
 * Update class
 *
 * Update Existing User. Both system users and normal users update via this action class.
 *
 * @author  Nasmy Nizam <nasmy@keeneye.solutions>
 */

namespace app\modules\api\v1\controllers\actions\user;

use app\modules\api\v1\components\ApiStatusMessages;
use app\modules\api\v1\components\Messages;
use app\modules\api\v1\models\UserApi;
use Yii;
use yii\base\Action;

class Update extends Action
{
    public function run()
    {
        $params = json_decode(Yii::$app->request->rawBody, true);
        $user = $this->controller->user;
        $userId = $user->id;
        $requestUserId = Yii::$app->request->get('id');
        $model = UserApi::findOne($requestUserId);
        $statusCode = ApiStatusMessages::FAILED;
        $statusMsg = null;
        $attribute = null;

        // Only super admin or particular user can update the record
        if (!empty($model) && $requestUserId == $userId || $user->type == UserApi::SYSTEM_USER) {
            $model->scenario = UserApi::SCENARIO_API_UPDATE;
            $curPassword = $model->password;
            $curEmail = $model->email;
            $model->attributes = $params;

            // Do not allow normal users to change the email. If so it should be verified
            if (!empty($params['email']) && $user->type == UserApi::NORMAL_USER) {
                $model->email = $curEmail;
            }

            // If password is empty set the existing password otherwise it will erase the existing password
            if (empty($params['password'])) {
                $model->password = $curPassword;
            }

            // If password is not empty then set the new password
            if ('' != @$params['password'] && $model->type == UserApi::SYSTEM_USER) {
                $model->formPassword = $model->password;
                $model->password = $model->encryptPassword($model->formPassword);
            }

            if ($model->saveModel()) {
                $statusCode = ApiStatusMessages::SUCCESS;
                Yii::$app->appLog->writeLog('Updated Successfully.');
            } else {
                $attribute = $model->invalAttrib;
                $statusCode = $model->statusCode;
                Yii::$app->appLog->writeLog('User Update failed.');
            }
        } else {
            $statusCode = ApiStatusMessages::RECORD_NOT_EXISTS;
            Yii::$app->appLog->writeLog('Record not exists or update not allowed');
        }

        $response = Messages::commonStatus($statusCode, $statusMsg, [], $attribute);
        $this->controller->sendResponse($response);
    }
}