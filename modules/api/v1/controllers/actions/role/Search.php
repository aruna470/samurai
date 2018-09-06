<?php
/**
 * Search class
 *
 * Search Role. system users can only Search permissions via this action class.
 *
 * @author  Nasmy Nizam <nasmy@keeneye.solutions>
 */

namespace app\modules\api\v1\controllers\actions\role;


use app\modules\api\v1\components\ApiStatusMessages;
use app\modules\api\v1\components\Messages;
use app\modules\api\v1\models\PermissionApi;
use app\modules\api\v1\models\RoleApi;
use Yii;
use yii\base\Action;

class Search extends Action
{
    public function run() {
        $roleSearch = new RoleApi();
        $roleSearch->scenario = RoleApi::SCENARIO_API_SEARCH;
        $roleSearch->load(['RoleApi' => Yii::$app->request->get()]);
        $statusCode = ApiStatusMessages::FAILED;

        $statusMsg = null;
        $attribute = null;
        $roles = null;
        $total = null;
        $data = [];

        if ($roleSearch->validateModel()) {
            $results = $roleSearch->apiSearch();
            $roles = $results['roles'];
            $total = $results['total'];
            $roleList = [];
            if (!empty($roles)) {
                foreach ($roles as $role) {
                    $roleList[] = Messages::role($role);
                }

                $statusCode = ApiStatusMessages::SUCCESS;
                $data = Messages::searchResult($total, $roleList, "roles");
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