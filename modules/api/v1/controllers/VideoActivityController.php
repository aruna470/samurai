<?php

namespace app\modules\api\v1\controllers;


class VideoActivityController extends ApiBaseController
{
    public function actions()
    {
        return array(
            'create' => 'app\modules\api\v1\controllers\actions\videoActivity\Create',
            'search' => 'app\modules\api\v1\controllers\actions\videoActivity\Search',
        );
    }

}
