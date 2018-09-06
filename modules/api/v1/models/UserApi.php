<?php

namespace app\modules\api\v1\models;

use app\models\User;
use app\modules\api\v1\models\RoleApi;
use app\modules\api\v1\components\ApiStatusMessages;
use Faker\Provider\zh_TW\DateTime;
use Yii;
use yii\helpers\Security;


class UserApi extends User
{
    // Scenario types
    const SCENARIO_API_CREATE = 'apiCreate';
    const SCENARIO_API_UPDATE = 'apiUpdate';
    const SCENARIO_API_AUTH = 'apiAuth';
    const SCENARIO_API_SEARCH = 'apiSearch';
    const SCENARIO_API_FORGOT_PASSWORD = 'apiForgotPassword';
    const SCENARIO_API_RESET_PASSWORD = 'apiResetPassword';

    // User login types
    const LT_EMAIL = 1;
    const LT_FACEBOOK = 2;

    // Gender types
    const MALE = 1;
    const FEMALE = 2;

    // User types
    const SYSTEM_USER = 1;
    const NORMAL_USER = 2;

    // User statuses
    const ACTIVE = 1;
    const INACTIVE = 2;

    // Device types
    const DT_ROKU = 1;
    const DT_APPLE_TV = 2;
    const DT_CHROMECAST = 3;
    const DT_AMAZON_FIRE = 4;
    const DT_XBOX = 5;
    const DT_PS = 6;
    const DT_SMART_TV = 7;

    // Pagination params
    public $limit = 10;
    public $page = 1;

    public $formPassword;

    /**
     * @inheritdoc
     */
    public function rules()
    {
        $scenarioList = [self::SCENARIO_API_CREATE , self::SCENARIO_API_UPDATE];

        return [
            // User Create/Update
            [['type', 'createdAt', 'firstName', 'lastName'], 'required',
                'message' => ApiStatusMessages::MISSING_MANDATORY_FIELD, 'on' => $scenarioList],
            [['sysEmail'], 'required', 'when' => function ($model) {
                return $model->type == self::SYSTEM_USER;
            }, 'message' => ApiStatusMessages::MISSING_MANDATORY_FIELD, 'on' => $scenarioList],
            [['email', 'sysEmail'], 'email', 'message' => ApiStatusMessages::INVALID_EMAIL,
                'on' => $scenarioList],
            [['type', 'status', 'createdById', 'updatedById', 'gender'], 'integer', 'on' => $scenarioList,
                'message' => ApiStatusMessages::INVALID_DATA_TYPE],
            [['username', 'timeZone', 'roleName'], 'string', 'max' => 15, 'on' => $scenarioList,
                'tooLong' => ApiStatusMessages::EXCEED_CHARACTER_LIMIT],
            [['password'], 'string', 'max' => 100, 'min' => 7, 'on' => $scenarioList,
                'tooLong' => ApiStatusMessages::EXCEED_CHARACTER_LIMIT,
                'tooShort' => ApiStatusMessages::MINIMUM_CHARACTER_LIMIT_NOT_MEET],
            [['firstName', 'lastName', 'fbId'], 'string', 'max' => 30, 'on' => $scenarioList,
                'tooLong' => ApiStatusMessages::EXCEED_CHARACTER_LIMIT],
            [['email', 'sysEmail', 'address'], 'string', 'max' => 60, 'on' => $scenarioList,
                'tooLong' => ApiStatusMessages::EXCEED_CHARACTER_LIMIT],
            [['phone'], 'string', 'max' => 20, 'on' => $scenarioList,
                'tooLong' => ApiStatusMessages::EXCEED_CHARACTER_LIMIT],
            [['email', 'sysEmail'], 'unique', 'on' => $scenarioList,
                'message' => ApiStatusMessages::EMAIL_EXISTS],
            [['phone'], 'match', 'pattern' => '/^\+\d+$/', 'message' => ApiStatusMessages::VALIDATION_FAILED,
                'on' => $scenarioList],
            [['dob'], 'match', 'pattern' => '/^\d{4}-\d{2}-\d{2}+$/',
                'message' => ApiStatusMessages::VALIDATION_FAILED,  'on' => $scenarioList],
            [['dob'], 'validateDob', 'on' => $scenarioList],
            [['gender'], 'in', 'range' => [self::MALE, self::FEMALE],
                'message' => ApiStatusMessages::VALIDATION_FAILED,  'on' => $scenarioList],
            [['userOwnDeviceTypes'], 'match', 'pattern' => '/^[1-8](,[1-7])*$/', 'on' => $scenarioList,
                'message' => ApiStatusMessages::VALIDATION_FAILED],

            // API - User authentication
            [['type'], 'required', 'message' => ApiStatusMessages::MISSING_MANDATORY_FIELD,
                'on' => [self::SCENARIO_API_AUTH]],
            [['type'], 'checkDependantFields', 'message' => ApiStatusMessages::MISSING_MANDATORY_FIELD,
                'on' => [self::SCENARIO_API_AUTH]],
            [['email', 'sysEmail', 'fbId', 'password', 'loginType'], 'safe', 'on' => [self::SCENARIO_API_AUTH]],

            // API Search
            [['limit', 'page'], 'required', 'message' => ApiStatusMessages::MISSING_MANDATORY_FIELD,
                'on' => self::SCENARIO_API_SEARCH],
            [['limit', 'page'], 'integer', 'message' => ApiStatusMessages::VALIDATION_FAILED,
                'on' => self::SCENARIO_API_SEARCH],
            [['firstName', 'lastName', 'email', 'sysEmail', 'timeZone',
                'roleName', 'type', 'status', 'createdAt', 'updatedAt', 'phone', 'address'], 'safe',
                'on' => [self::SCENARIO_API_SEARCH]],

            // API - Forgot password
            [['email'], 'required', 'message' => ApiStatusMessages::MISSING_MANDATORY_FIELD,
                'on' => [self::SCENARIO_API_FORGOT_PASSWORD]],
            [['email'], 'email', 'message' => ApiStatusMessages::INVALID_EMAIL,
                'on' => [self::SCENARIO_API_FORGOT_PASSWORD]],

            // API - Reset password
            [['passwordResetToken', 'password'], 'required', 'message' => ApiStatusMessages::MISSING_MANDATORY_FIELD,
                'on' => [self::SCENARIO_API_RESET_PASSWORD]],
        ];
    }

    public function validateDob($attribute)
    {
        $dob = new \DateTime($this->dob);
        $curDate = new \DateTime();
        if ($dob > $curDate) {
            $this->addError($attribute, ApiStatusMessages::VALIDATION_FAILED);
        }
    }

    /**
     * Authenticate user, depending on different login types
     * @return mixed
     */
    public function authUser()
    {
        $model = false;

        if ($this->type == UserApi::SYSTEM_USER) {
            $model = $this->authSysEmail();
        } else if ($this->type == UserApi::NORMAL_USER) {
            switch ($this->loginType) {
                case self::LT_EMAIL:
                    $model = $this->authEmail();
                    break;
                case self::LT_FACEBOOK:
                    $model = $this->authFacebook();
                    break;
            }
        }

        return $model;
    }

    /**
     * Email authentication
     * @return mixed
     */
    public function authEmail()
    {
        $model = UserApi::find()->where('email = :email', [':email' => $this->email])->one();

        if (!empty($model)) {
            if (Yii::$app->getSecurity()->validatePassword($this->password, $model->password)) {
                return $model;
            }
        }

        return false;
    }

    /**
     * System User Email authentication
     * @return mixed
     */
    public function authSysEmail()
    {
        $model = UserApi::find()->where('sysEmail = :sysEmail', [':sysEmail' => $this->sysEmail])->one();

        if (!empty($model)) {
            if (Yii::$app->getSecurity()->validatePassword($this->password, $model->password)) {
                return $model;
            }
        }

        return false;
    }

    /**
     * Facebook authentication
     * @return mixed
     */
    public function authFacebook()
    {
        $model = UserApi::find()->where('fbId = :fbId', [':fbId' => $this->fbId])->one();
        if (!empty($model)) {
            return $model;
        }

        return false;
    }

    /**
     * Validate required fields depending on login type & type
     */
    public function checkDependantFields()
    {
        switch ($this->type) {

            case self::SYSTEM_USER:
                if (null == $this->sysEmail) {
                    $this->addError('sysEmail', ApiStatusMessages::MISSING_MANDATORY_FIELD);
                }
                break;

            case self::NORMAL_USER:
                if (null == $this->loginType) {
                    $this->addError('loginType', ApiStatusMessages::MISSING_MANDATORY_FIELD);
                } else {
                    switch ($this->loginType) {
                        case self::LT_EMAIL:
                            if (null == $this->email) {
                                $this->addError('email', ApiStatusMessages::MISSING_MANDATORY_FIELD);
                            } else if (null == $this->password) {
                                $this->addError('password', ApiStatusMessages::MISSING_MANDATORY_FIELD);
                            }
                            break;
                        case self::LT_FACEBOOK:
                            if (null == $this->fbId) {
                                $this->addError('fbId', ApiStatusMessages::MISSING_MANDATORY_FIELD);
                            }
                            break;
                        default:
                            $this->addError('loginType', ApiStatusMessages::MISSING_MANDATORY_FIELD);
                            break;
                    }
                }
                break;

            default:
                $this->addError('type', ApiStatusMessages::MISSING_MANDATORY_FIELD);
                break;
        }
    }

    /**
     * In user creation check whether user has provided at least one login type
     * Either email/password, Facebook, LinkedIn or G+
     * @return boolean
     */
    public function isAnySignupParamExists()
    {
        $emailLogin = false;
        if ((null != $this->email || null != $this->sysEmail) && null != $this->password) {
            $emailLogin = true;
        }

        if (!$emailLogin && null == $this->fbId) {
            return false;
        }

        return true;
    }

    /**
     * Search for API requests
     * @return mixed
     */
    public function apiSearch()
    {
        $offset = ($this->page - 1) * $this->limit;
        $query = User::find();
        $query->andFilterWhere(['id' => $this->id])
            ->andFilterWhere(['like', 'firstName', $this->firstName])
            ->andFilterWhere(['like', 'lastName', $this->lastName])
            ->andFilterWhere(['like', 'email', $this->email])
            ->andFilterWhere(['like', 'sysEmail', $this->sysEmail])
            ->andFilterWhere(['like', 'address', $this->address])
            ->andFilterWhere(['like', 'phone', $this->phone])
            ->andFilterWhere(['like', 'roleName', $this->roleName])
            ->andFilterWhere(['type' => $this->type])
            ->andFilterWhere(['status' => $this->status]);

        if ($this->type == self::SYSTEM_USER) {
            $query->andWhere('roleName != :roleName', ['roleName' => RoleApi::SUPER_ADMIN]);
        }

        $query->limit($this->limit);

        $query->offset($offset);
        $total = $query->count();
        $users = $query->all();

        return ['total' => $total, 'users' => $users];
    }

    /**
     * Retrieve user profile by email
     * @param string $email
     * @return mixed
     */
    public function getUserByEmail($email)
    {
        $user = UserApi::find()
            ->andWhere(['email' => $email])
            ->one();

        return $user;
    }

    /**
     * Retrieve user profile by password reset token
     * @param string $token
     * @return mixed
     */
    public function getUserByPwResetToken($token)
    {
        $user = UserApi::find()
            ->andWhere(['passwordResetToken' => $token])
            ->one();

        return $user;
    }
}

