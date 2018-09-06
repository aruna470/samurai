<?php

/**
 * Create class
 *
 * Add new Permission to the system. system users can only add permissions via this action class.
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

class Create extends Action
{
    public function run()
    {
        $params = json_decode(Yii::$app->request->rawBody, true);
        $model = new PermissionApi();
        $user = $this->controller->user;

        $model->scenario = PermissionApi::SCENARIO_API_CREATE;
        $model->attributes = $params;
        $statusCode = ApiStatusMessages::FAILED;
        $statusMsg = null;
        $attribute = null;

        // Only allow SYSTEM_USER to create permissions
        if (!empty($user) && $user->type == UserApi::SYSTEM_USER) {
            if ($model->saveModel()) {
                $statusCode = ApiStatusMessages::SUCCESS;
            } else {
                $attribute = $model->invalAttrib;
                $statusCode = $model->statusCode;
                Yii::$app->appLog->writeLog('Permission create failed.');
            }
        } else {
            $statusCode = ApiStatusMessages::PERMISSION_DENIED;
            Yii::$app->appLog->writeLog('User not authorized to access.');
        }

        $response = Messages::commonStatus($statusCode, $statusMsg, [], $attribute);
        $this->controller->sendResponse($response);
    }
}