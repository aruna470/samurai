<?php
/**
 * Search class
 *
 * Search Users. system users can only Search Users via this action class.
 *
 * @author  Nasmy Nizam <nasmy@keeneye.solutions>
 */

namespace app\modules\api\v1\controllers\actions\user;


use app\modules\api\v1\components\ApiStatusMessages;
use app\modules\api\v1\components\Messages;
use app\modules\api\v1\models\UserApi;
use Yii;
use yii\base\Action;

class Search extends Action
{
    public function run()
    {
        $userSearch = new UserApi();
        $userSearch->scenario = UserApi::SCENARIO_API_SEARCH;
        $userSearch->load(['UserApi' => Yii::$app->request->get()]);
        $statusCode = ApiStatusMessages::FAILED;

        $statusMsg = null;
        $attribute = null;
        $permissions = null;
        $total = null;
        $data = [];

        if ($userSearch->validateModel()) {
            $results = $userSearch->apiSearch();
            $users = $results['users'];
            $total = $results['total'];
            $userList = [];
            if (!empty($users)) {
                foreach ($users as $user) {
                    $userList[] = Messages::user($user);
                }

                $statusCode = ApiStatusMessages::SUCCESS;
                $data = Messages::searchResult($total, $userList, "users");
            } else {
                $statusCode = ApiStatusMessages::RECORD_NOT_EXISTS;
                Yii::$app->appLog->writeLog('Record not exists');
            }
        } else {
            Yii::$app->appLog->writeLog('Search failed');
        }

        $response = Messages::commonStatus($statusCode, $statusMsg, $data, $attribute);
        $this->controller->sendResponse($response);
    }

}