<?php

/**
 * Create class
 *
 * Add new Video Activity to the system. Both system users and normal users add via this action class.
 *
 * @author  Nasmy Ahamed <nasmy@keeneye.solutions>
 */
namespace app\modules\api\v1\controllers\actions\videoActivity;

use app\modules\api\v1\components\ApiStatusMessages;
use app\modules\api\v1\components\Messages;
use app\modules\api\v1\models\VideoActivityApi;
use Yii;
use yii\base\Action;

class Create extends Action
{
    public function run()
    {
        $params = json_decode(Yii::$app->request->rawBody, true);
        $model = new VideoActivityApi();
        $user = $this->controller->user;
        $model->scenario = VideoActivityApi::SCENARIO_API_CREATE;
        $model->attributes = $params;
        $statusCode = ApiStatusMessages::FAILED;
        $statusMsg = null;
        $attribute = null;
        $data[] = $params;

        if (!empty($user)) {
            $model->userId = $user->id;
            $model->datetime = Yii::$app->util->getUtcDateTime();
            if ($model->saveModel()) {
                $statusCode = ApiStatusMessages::SUCCESS;
            } else {
                $attribute = $model->invalAttrib;
                $statusCode = $model->statusCode;
                Yii::$app->appLog->writeLog('Log Created failed.');
            }
        } else {
            $statusCode = ApiStatusMessages::PERMISSION_DENIED;
            Yii::$app->appLog->writeLog('User not authorized to access.');
        }

        $response = Messages::commonStatus($statusCode, $statusMsg, [], $attribute);
        $this->controller->sendResponse($response);
    }
}