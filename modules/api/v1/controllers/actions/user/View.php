<?php
/**
 * View class
 *
 * View user from the system. Both system users and normal users view via this action class.
 *
 * @Author  Nasmy Nizam <nasmy@keeneye.solutions>
 */

namespace app\modules\api\v1\controllers\actions\user;

use Yii;
use yii\base\Action;
use app\modules\api\v1\models\UserApi;
use app\modules\api\v1\components\ApiStatusMessages;
use app\modules\api\v1\components\Messages;

class View extends Action
{
    public function run()
    {
        $userId = Yii::$app->request->get('id');
        $model = UserApi::findOne($userId);
        $response = [];
        $statusMsg = null;
        $attribute = null;
        $data = [];

        if (!empty($model)) {
            $statusCode = ApiStatusMessages::SUCCESS;
            $data['user'] = Messages::user($model);
        } else {
            $statusCode = ApiStatusMessages::RECORD_NOT_EXISTS;
            Yii::$app->appLog->writeLog('Record not exists.');
        }

        $response = Messages::commonStatus($statusCode, $statusMsg, $data, $attribute);
        $this->controller->sendResponse($response);
    }
}