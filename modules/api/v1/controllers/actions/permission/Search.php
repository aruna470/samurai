<?php
/**
 * Search class
 *
 * Search Permissions. system users can only Search permissions via this action class.
 *
 * @author  Nasmy Nizam <nasmy@keeneye.solutions>
 */

namespace app\modules\api\v1\controllers\actions\permission;


use app\modules\api\v1\components\ApiStatusMessages;
use app\modules\api\v1\components\Messages;
use app\modules\api\v1\models\PermissionApi;
use Yii;
use yii\base\Action;

class Search extends Action
{
    public function run()
    {
        $permissionSearch = new PermissionApi();
        $permissionSearch->scenario = PermissionApi::SCENARIO_API_SEARCH;
        $permissionSearch->load(['PermissionApi' => Yii::$app->request->get()]);
        $statusCode = ApiStatusMessages::FAILED;

        $statusMsg = null;
        $attribute = null;
        $permissions = null;
        $total = null;
        $data = [];

        if ($permissionSearch->validateModel()) {
            $results = $permissionSearch->apiSearch();
            $permissions = $results['permissions'];
            $total = $results['total'];
            $permissionList = [];
            if (!empty($permissions)) {
                foreach ($permissions as $permission) {
                    $permissionList[] = Messages::permission($permission);
                }

                $statusCode = ApiStatusMessages::SUCCESS;
                $data = Messages::searchResult($total, $permissionList, "permissions");
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