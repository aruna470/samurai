<?php

namespace app\modules\api\v1\controllers;


class PermissionController extends ApiBaseController
{
    public function actions(){
        return array(
            'create' => 'app\modules\api\v1\controllers\actions\permission\Create',
            'update' => 'app\modules\api\v1\controllers\actions\permission\Update',
            'view' => 'app\modules\api\v1\controllers\actions\permission\View',
            'delete' => 'app\modules\api\v1\controllers\actions\permission\Delete',
            'search' => 'app\modules\api\v1\controllers\actions\permission\Search',
        );
    }
}