<?php
/**
 * Messages class
 *
 * Prepare JSON messages to be sent
 *
 * @author  Aruna Attanayake <aruna@keeneye.solutions>
 */

namespace app\modules\api\v1\components;

use yii\base\Component;

class Messages extends Component
{
    /**
     * Common response message
     * @param string $code Status code
     * @param string $message Status message
     * @param array $data Extra params to be sent along with common response
     * @param string $attribute Attribute name associated with the error
     * @return mixed
     */
    public static function commonStatus($code, $message = '', $data = [], $attribute = '')
    {
        $data = empty($data) ? (object) null : $data;
        $msg = [
            'code' => $code,
            'message' => $message,
            'data' => $data,
            'attribute' => $attribute
        ];

        return $msg;
    }

    /**
     * @param $user
     * @param $deviceInfo
     * @return array
     */
    public static function user($user, $deviceInfo = [])
    {
        return [
            'id' => $user->id,
            'firstName' => $user->firstName,
            'lastName' => $user->lastName,
            'username' => $user->username,
            'email' => $user->email,
            'sysEmail' => $user->sysEmail,
            'timeZone' => $user->timeZone,
            'roleName' => $user->roleName,
            'type' => $user->type,
            'status' => $user->status,
            'phone' => $user->phone,
            'gender' => $user->gender,
            'dob' => $user->dob,
            'createdAt' => $user->createdAt,
            'updatedAt' => $user->updatedAt,
            'createdById' => $user->createdById,
            'updatedById' => $user->updatedById,
            'lastAccess' => $user->lastAccess,
            'address' => $user->address,
            'accessToken' => $user->accessToken,
            'userOwnDeviceTypes' => $user->userOwnDeviceTypes
        ];
    }

    /**
     * @param $model
     * @return array
     */
    public static function deviceInfo($model)
    {
        return [
            'uuId' => $model->uuId,
            'type' => $model->type,
            'token' => $model->token,
            'createdAt' => $model->createdAt,
            'updatedAt' => $model->updatedAt,
        ];
    }

    /**
     * @param $permission
     * @return array
     */
    public static function permission($permission)
    {
        return [
            'name' => $permission->name,
            'description' => $permission->description,
            'category' => $permission->category,
            'createdAt' => $permission->createdAt,
            'updatedAt' => $permission->updatedAt,
            'createdById' => $permission->createdById,
            'updatedById' => $permission->updatedById
        ];
    }

    /**
     * @param $logs
     * @return array
     */
    public static function VideoActivityLogs($logs){
        return [
            'videoRefId' => $logs->videoRefId,
            'deviceId' => $logs->deviceId,
            'datetime' => $logs->datetime,
            'firstName' => $logs->user->firstName,
            'lastName' => $logs->user->lastName,
            'status'=>$logs->status
        ];
    }

    /**
     * @param $role
     * @param $permissions
     * @return array
     */
    public static function role($role, $permissions = [])
    {
        return [
            'name' => $role->name,
            'description' => $role->description,
            'createdAt' => $role->createdAt,
            'updatedAt' => $role->updatedAt,
            'createdById' => $role->createdById,
            'updatedById' => $role->updatedById,
            'permissions' => $permissions
        ];
    }

    /**
     * Search result
     * @param integer $total Total record count
     * @param array $data Result set
     * @param string $dataListName Name of object list
     * @return array
     */
    public static function searchResult($total, $data ,$dataListName = 'data')
    {
        return [
            'total' => $total,
            $dataListName => $data
        ];
    }
}
?>