<?php
/**
 * View class
 *
 * View permission . System users can view permissions via this action class.
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

class View extends Action
{
    public function run()
    {
        $permissionName = Yii::$app->request->get('name');
        $model = PermissionApi::findOne($permissionName);
        $user = $this->controller->user;

        $statusCode = ApiStatusMessages::FAILED;
        $response = [];
        $statusMsg = null;
        $attribute = null;
        $data = [];

        if (!empty($model)) {
            if ($user->type == UserApi::SYSTEM_USER) {
                $statusCode = ApiStatusMessages::SUCCESS;
                $data['permission'] = Messages::permission($model);
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