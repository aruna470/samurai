<?php

namespace app\modules\api\v1\controllers;


class RoleController extends ApiBaseController
{
    public function actions(){
        return array(
            'create' => 'app\modules\api\v1\controllers\actions\role\Create',
            'update' => 'app\modules\api\v1\controllers\actions\role\Update',
            'view' => 'app\modules\api\v1\controllers\actions\role\View',
            'delete' => 'app\modules\api\v1\controllers\actions\role\Delete',
            'search' => 'app\modules\api\v1\controllers\actions\role\Search'
        );
    }



}