<?php

namespace app\modules\api\v1\controllers\actions\user;

use Yii;
use yii\base\Action;
use app\components\Mail;
use app\modules\api\v1\models\UserApi;
use app\modules\api\v1\components\Messages;
use app\modules\api\v1\components\ApiStatusMessages;
use yii\helpers\Html;


class ForgotPassword extends Action
{
    public function run()
    {
        $params = json_decode(Yii::$app->request->rawBody, true);
        $mail = new Mail();
        $user = new UserApi();
        $user->scenario = UserApi::SCENARIO_API_FORGOT_PASSWORD;
        $user->attributes = $params;
        $statusCode = ApiStatusMessages::FAILED;
        $statusMsg = null;
        $attribute = null;

        if ($user->validateModel()) {
            $model = $user->getUserByEmail($user->email);
            if (!empty($model)) {
                $token = uniqid() . $model->id;
                $model->passwordResetToken = $token;
                if ($model->saveModel()) {
                    $url = Yii::$app->params['passwordRestUrl'] . '?q=' . $token;
                    $link = Html::a(Yii::t('mail', 'Reset password', []), $url);
                    if ($mail->sendForgotPasswordEmail($user->email, $link)) {
                        $statusCode = ApiStatusMessages::SUCCESS;
                    }
                }
            } else {
                $statusCode = ApiStatusMessages::RECORD_NOT_EXISTS;
                Yii::$app->appLog->writeLog('No user found for the email.', ['email' => $user->email]);
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