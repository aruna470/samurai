<?php

namespace app\modules\api\v1\controllers\actions\user;

use Yii;
use yii\base\Action;
use app\components\Mail;
use app\modules\api\v1\models\UserApi;
use app\modules\api\v1\components\Messages;
use app\modules\api\v1\components\ApiStatusMessages;


class ResetPassword extends Action
{
    public function run()
    {
        $params = json_decode(Yii::$app->request->rawBody, true);
        $mail = new Mail();
        $user = new UserApi();
        $user->scenario = UserApi::SCENARIO_API_RESET_PASSWORD;
        $statusCode = ApiStatusMessages::FAILED;
        $statusMsg = null;
        $attribute = null;

        $user->attributes = $params;

        if ($user->validateModel()) {
            $model = $user->getUserByPwResetToken($user->passwordResetToken);
            if (!empty($model)) {
                $model->password = $model->encryptPassword($user->password);
                if ($model->saveModel()) {
                    $statusCode = ApiStatusMessages::SUCCESS;
                    $mail->sendPasswordResetEmail($model->email, $model->firstName);
                }
            } else {
                $statusCode = ApiStatusMessages::RECORD_NOT_EXISTS;
                Yii::$app->appLog->writeLog('No user found for the token.', ['token' => $user->passwordResetToken]);
            }
        } else {
            $attribute = $user->invalAttrib;
            $statusCode = $user->statusCode;
            Yii::$app->appLog->writeLog('Validation failed');
        }

        $response = Messages::commonStatus($statusCode, $statusMsg, [], $attribute);
        $this->controller->sendResponse($response);
    }
}
?>