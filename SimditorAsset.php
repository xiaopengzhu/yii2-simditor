<?php

namespace zxp\simditor;

use yii\web\AssetBundle;

class Simditor extends AssetBundle
{
    public $sourcePath = __DIR__.'/assets';

    public $js = [
        'scripts/simditor.min.js',
        'scripts/uploader.js',
        'scripts/module.min.js',
        'scripts/hotkeys.min.js',
    ];

    public $css = [
        'styles/simditor.css'
    ];

    public $depends = [
        'yii\web\YiiAsset',
    ];

    public function registerAssetFiles($view)
    {
        parent::registerAssetFiles($view); // TODO: Change the autogenerated stub
    }
}