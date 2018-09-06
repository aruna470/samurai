<?php
/**
 * Update class
 *
 * Update existing Permission. System users can update permissions via this action class.
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

class Update extends Action
{
    public function run() {
        $params = json_decode(Yii::$app->request->rawBody, true);
        $user = $this->controller->user;
        $permissionName = Yii::$app->request->get('name');

        $model = PermissionApi::findOne($permissionName);
        $statusCode = ApiStatusMessages::FAILED;
        $statusMsg = null;
        $attribute = null;

        if (!empty($model)) {
            if ($user->type == UserApi::SYSTEM_USER) {
                $model->scenario = PermissionApi::SCENARIO_API_UPDATE;
                $model->attributes = $params;

                if ($model->saveModel()) {
                    $statusCode = ApiStatusMessages::SUCCESS;
                    Yii::$app->appLog->writeLog('Updated successfully.');
                } else {
                    $attribute = $model->invalAttrib;
                    $statusCode = $model->statusCode;
                    Yii::$app->appLog->writeLog('Permission update failed.');
                }
            } else {
                $statusCode = ApiStatusMessages::PERMISSION_DENIED;
                Yii::$app->appLog->writeLog('Permission denied.');
            }
        } else {
            $statusCode = ApiStatusMessages::RECORD_NOT_EXISTS;
            Yii::$app->appLog->writeLog('Record not exists.');
        }

        $response = Messages::commonStatus($statusCode, $statusMsg, [], $attribute);
        $this->controller->sendResponse($response);
    }
}