<?php

namespace zxp\simditor;

use Yii;
use yii\base\Action;
use yii\web\Response;

class SimditorAction extends Action
{
    public $config = [];

    public function run()
    {
        Yii::$app->response->format = Response::FORMAT_JSON;
        if (isset($_FILES)) {
            $model = new UploadModel($this->config);
            if ($model->upload()) {
                $res = $model->getResponse();
                return ['success' => true, 'msg' => 'upload success', 'file_path' => $res['filelink']];
            } else {
                return ['success'];
            }
        }
    }
}