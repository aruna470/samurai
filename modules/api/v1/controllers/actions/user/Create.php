<?php
/**
 * Create class
 *
 * Add new user to the system. Both system users and normal users add via this action class.
 *
 * @author  Aruna Attanayake <aruna@keeneye.solutions>
 */

namespace app\modules\api\v1\controllers\actions\user;


use Yii;
use yii\base\Action;
use app\components\Mail;
use app\modules\api\v1\models\UserApi;
use app\modules\api\v1\components\Messages;
use app\modules\api\v1\components\ApiStatusMessages;

class Create extends Action
{
    public function run()
    {
        $params = json_decode(Yii::$app->request->rawBody, true);
        $model = new UserApi();
        $mail = new Mail();
        $model->scenario = UserApi::SCENARIO_API_CREATE;
        $model->attributes = $params;

        // Default status code and message
        $statusCode = ApiStatusMessages::FAILED;
        $statusMsg = null;
        $attribute = null;

        if ($model->isAnySignupParamExists()) {
            $model->timeZone = Yii::$app->params['defaultTimeZone'];

            // Set default status
            $model->status = null == $model->status ? UserApi::INACTIVE : $model->status;

            if ($model->validateModel()) {
                if (null != $model->password) {
                    $model->formPassword = $model->password;
                    $model->password = $model->encryptPassword($model->formPassword);
                }

                if ($model->saveModel()) {
                    $statusCode = ApiStatusMessages::SUCCESS;
                    // Send signup email only to normal users
                    if ($model->type == UserApi::NORMAL_USER) {
                        $mail->sendSignupEmail($model->email, $model->firstName);
                    }

                    Yii::$app->appLog->writeLog('User created.');
                } else {
                    $attribute = $model->invalAttrib;
                    $statusCode = $model->statusCode;
                    Yii::$app->appLog->writeLog('User create failed.');
                }
            } else {
                $attribute = $model->invalAttrib;
                $statusCode = $model->statusCode;
                Yii::$app->appLog->writeLog('User create failed.');
            }
        } else {
            $statusCode = ApiStatusMessages::MISSING_MANDATORY_FIELD;
            $statusMsg = 'Missing social login id or email/password combination';
        }

        $response = Messages::commonStatus($statusCode, $statusMsg, [], $attribute);
        $this->controller->sendResponse($response);
    }
}
?>