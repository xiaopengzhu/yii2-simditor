<?php

namespace zxp\simditor;

use Yii;
use yii\base\Action;
use yii\helpers\ArrayHelper;
use yii\web\Response;

class SimditorAction extends Action
{
    public $config = [];

    public function init()
    {
        $_config = [
            'urlPrefix'=> Yii::getAlias('@web'),
            'uploadRoot' => Yii::getAlias('@webroot'),
            'pathFormat' => ''
        ];
        $this->config = ArrayHelper::merge($_config, $this->config);
        parent::init();
    }

    public function actionUpload()
    {
        if (is_uploaded_file($_FILES[ 'upload_file' ][ 'tmp_name' ])) {
            $file = $_FILES[ 'upload_file' ];

            $urlPrefix = $this->config['urlPrefix'];
            $uploadRoot = $this->config['uploadRoot'];
            $newPath = '/upload/editor/'.$file['name'];

            if (move_uploaded_file($file['tmp_name'], $uploadRoot.$newPath)) {
                return ['success' => true, 'msg' => 'ok', 'file_path' => $urlPrefix.$newPath];
            }
        }
    }

    public function run()
    {
        if (Yii::$app->request->get('callback',false)) {
            Yii::$app->response->format = Response::FORMAT_JSONP;
        } else {
            Yii::$app->response->format = Response::FORMAT_JSON;
        }
        return $this->handleAction();
    }

    protected function handleAction()
    {
        $result= $this->actionUpload();
        return $result;
    }
}