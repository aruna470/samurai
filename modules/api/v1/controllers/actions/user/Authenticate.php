<?php
/**
 * Authenticate class
 *
 * Authenticate User. Both system users and normal users login  via this action class.
 *
 * @author  Nasmy Nizam <nasmy@keeneye.solutions>
 */

namespace app\modules\api\v1\controllers\actions\user;


use app\models\DeviceInfo;
use app\modules\api\v1\components\ApiStatusMessages;
use app\modules\api\v1\components\Messages;
use app\modules\api\v1\models\RoleApi;
use app\modules\api\v1\models\RolePermissionApi;
use app\modules\api\v1\models\UserApi;
use Yii;
use yii\base\Action;

class Authenticate extends Action
{
    public function run()
    {
        $params = json_decode(Yii::$app->request->rawBody, true);
        $model = new UserApi();
        $model->scenario = UserApi::SCENARIO_API_AUTH;
        $model->attributes = $params;


        $statusCode = ApiStatusMessages::FAILED;
        $statusMsg = null;
        $data = [];
        $attribute = null;
        $permissions = [];
        $device = null;
        
        // validate user according to login type
        if ($model->validateModel()) {

            $model = $model->authUser();

            if (!empty($model)) {
                $token = $model->id . '-' . uniqid();
                $model->accessToken = $token;
                $model->lastAccess = Yii::$app->util->getUtcDateTime();

                if ($model->saveModel()) {
                    if (!empty($params['deviceInfo'])) {
                        $deviceModel = new DeviceInfo();
                        $deviceModel->attributes = $params['deviceInfo'];
                        $device = DeviceInfo::find()
                            ->where(['userId' => $model->id, 'uuId' => $deviceModel->uuId])
                            ->one();

                        if (!empty($device)) {
                            $device->saveModel();
                        } else {
                            $deviceModel->userId = $model->id;
                            $deviceModel->saveModel();
                        }
                    }

                    $statusCode = ApiStatusMessages::SUCCESS;
                    $data['user'] = Messages::user($model);

                    // check if the user is system user only send permissions information
                    if ($params['type'] == UserApi::SYSTEM_USER) {
                        $roleModel = RoleApi::findOne($model->roleName);
                        $roleModel->modelPermissions = RolePermissionApi::findAll(['roleName' => $roleModel->name]);

                        foreach ($roleModel->modelPermissions as $permission) {
                            $permissions[] = $permission->permissionName;
                        }

                        $data['user']['role'] = Messages::role($roleModel, $permissions);
                    }
                }
            } else {
                $statusCode = ApiStatusMessages::AUTH_FAILED;
                Yii::$app->appLog->writeLog('Invalid password or invalid user type');
            }
        } else {
            $statusCode = $model->statusCode;
            $attribute = $model->invalAttrib;
            Yii::$app->appLog->writeLog('User Authentication Failed');
        }

        $response = Messages::commonStatus($statusCode, $statusMsg, $data, $attribute);
        $this->controller->sendResponse($response);
    }
}
?>