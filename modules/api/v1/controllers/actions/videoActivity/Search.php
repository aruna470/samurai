<?php
/**
 * Search class
 *
 * Search Video Activity Logs. system users can only Search permissions via this action class.
 *
 * @author  Nasmy Nizam <nasmy@keeneye.solutions>
 */

namespace app\modules\api\v1\controllers\actions\videoActivity;

use app\modules\api\v1\components\ApiStatusMessages;
use app\modules\api\v1\components\Messages;
use app\modules\api\v1\models\UserApi;
use app\modules\api\v1\models\VideoActivityApi;
use Yii;
use yii\base\Action;

class Search extends Action
{
    public function run()
    {
        $videoActivitySearch = new VideoActivityApi();
        $user = $this->controller->user;

        $videoActivitySearch->scenario = VideoActivityApi::SCENARIO_API_SEARCH;
        $videoActivitySearch->load(['VideoActivityApi' => Yii::$app->request->get()]);
        $statusCode = ApiStatusMessages::FAILED;

        $statusMsg = null;
        $attribute = null;
        $permissions = null;
        $total = null;
        $data = [];

        if (!empty($user) && $user->type == UserApi::SYSTEM_USER) {
            if ($videoActivitySearch->validateModel()) {
                $results = $videoActivitySearch->apiSearch();
                $logs = $results['logs'];
                $total = $results['total'];
                $logList = [];
                if (!empty($logs)) {
                    foreach ($logs as $log) {
                        $logList[] = Messages::VideoActivityLogs($log);
                    }

                    $statusCode = ApiStatusMessages::SUCCESS;
                    $data = Messages::searchResult($total, $logList, "logs");
                } else {
                    $statusCode = ApiStatusMessages::RECORD_NOT_EXISTS;
                    Yii::$app->appLog->writeLog('Record not exists');
                }
            } else {
                Yii::$app->appLog->writeLog('Search failed');
            }
        } else {
            $statusCode = ApiStatusMessages::PERMISSION_DENIED;
            Yii::$app->appLog->writeLog('User not authorized to access.');
        }

        $response = Messages::commonStatus($statusCode, $statusMsg, $data, $attribute);
        $this->controller->sendResponse($response);
    }

}