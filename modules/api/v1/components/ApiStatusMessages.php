<?php
/**
 * ApiStatusMessages class
 *
 * Just contains the API error messages to be returned.
 *
 * @author  Aruna Attanayake <aruna@keeneye.solutions>
 */

namespace app\modules\api\v1\components;

use yii\base\Component;

class ApiStatusMessages extends Component
{
    // Common error codes
    const SUCCESS = 'SUCCESS';
    const AUTH_FAILED = 'AUTH_FAILED';
    const MISSING_MANDATORY_FIELD = 'MISSING_MANDATORY_ATTRIBUTE';
    const VALIDATION_FAILED = 'VALIDATION_FAILED';
    const RECORD_EXISTS = 'RECORD_EXISTS';
    const FAILED = 'FAILED';
    const RECORD_NOT_EXISTS = 'RECORD_NOT_EXISTS';
    const EMAIL_EXISTS = 'EMAIL_EXISTS';
    const NAME_EXISTS = 'NAME_EXISTS';
    const PHONE_EXISTS = 'PHONE_EXISTS';
    const INVALID_EMAIL = 'INVALID_EMAIL';
    const INVALID_DATA_TYPE = 'INVALID_DATA_TYPE';
    const EXCEED_CHARACTER_LIMIT = 'EXCEED_CHARACTER_LIMIT';
    const PERMISSION_DENIED = "PERMISSION_DENIED";
    const PERMISSION_IN_USE = "PERMISSION_IN_USE";
    const USER_IN_USE = "USER_IN_USE";
    const ROLE_IN_USE = "ROLE_IN_USE";
    const MINIMUM_CHARACTER_LIMIT_NOT_MEET = 'MINIMUM_CHARACTER_LIMIT_NOT_MEET';
}
?>