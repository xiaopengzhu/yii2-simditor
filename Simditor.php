<?php

namespace zxp\simditor;

use yii\base\Model;
use yii\base\Widget;
use yii\helpers\Html;
use yii\helpers\Json;
use yii\helpers\Url;
use yii\web\JsExpression;
use yii\web\View;

/**
 * Class Simditor
 * @package zxp\simditor
 * @auth zxp(xp_zhu@qq.com)
 * @since 1.0
 */
class Simditor extends Widget
{
    public $id;

    public $model;

    public $attribute;

    public $name;

    public $options = [];

    public $pluginOptions =[];

    public $toolbar = [
        'title',
        'bold',
        'italic',
        'underline',
        'strikethrough',
        'fontScale',
        'color',
        '|',
        'ol',
        'ul',
        'blockquote',
        'code',
        'table',
        '|',
        'link',
        'image',
        'hr',
        '|',
        'indent',
        'outdent',
        'alignment'
    ];

    /**
     * set id
     */
    public function init()
    {
        if (!isset($this->id)) {
            $this->id = $this->hasModel() ? Html::getInputId($this->model, $this->attribute) : $this->getId();
        }
        parent::init();
    }

    /**
     * @inheritdoc
     */
    public function run()
    {
        if ($this->hasModel()) {
            echo  Html::activeTextarea($this->model, $this->attribute, $this->options);
        } else {
            echo Html::textarea($this->name, '', $this->options);
        }

        $this->registerPlugin();
    }

    /**
     * register plugin by plugin options
     */
    protected function registerPlugin()
    {
        SimditorAsset::register($this->view);
        $this->pluginOptions['textarea'] = new JsExpression("$('#{$this->id}')");

        if (!isset($this->pluginOptions['toolbar']))
            $this->pluginOptions['toolbar'] = $this->toolbar;

        if (!isset($this->pluginOptions['pasteImage']))
            $this->pluginOptions['pasteImage'] = true;

        $this->pluginOptions['upload'] = [
            'url' => Url::to(['upload']),
        ];

        $pluginOptions = Json::encode($this->pluginOptions);

        $js = "var editor=new Simditor($pluginOptions);";
        $this->view->registerJs($js, View::POS_READY);
    }

    /**
     * @return bool
     */
    protected function hasModel()
    {
        return $this->model instanceof Model && $this->attribute !== null;
    }
}
