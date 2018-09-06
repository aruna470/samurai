<?php

namespace app\modules\api\v1\controllers;

class UserController extends ApiBaseController
{
    public function actions(){
        return array(
            'create' => 'app\modules\api\v1\controllers\actions\user\Create',
            'update' => 'app\modules\api\v1\controllers\actions\user\Update',
            'view' => 'app\modules\api\v1\controllers\actions\user\View',
            'delete' => 'app\modules\api\v1\controllers\actions\user\Delete',
            'authenticate' => 'app\modules\api\v1\controllers\actions\user\Authenticate',
            'search' => 'app\modules\api\v1\controllers\actions\user\Search',
            'forgot-password' => 'app\modules\api\v1\controllers\actions\user\ForgotPassword',
            'reset-password' => 'app\modules\api\v1\controllers\actions\user\ResetPassword',
        );
    }
}
