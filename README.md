yii2 simditor extension
=======================
yii2 simditor extension

simditor 2.3.6

Installation
------------

The preferred way to install this extension is through [composer](http://getcomposer.org/download/).

Either run

```
composer require --prefer-dist zxp/yii2-simditor:^1.0
```

or add

```
"zxp/yii2-simditor": "^1.0"
```

to the require section of your `composer.json` file.


Usage
-----

Once the extension is installed, simply use it in your code by  :

```php
<?= \zxp\simditor\Simditor::widget(); ?>
or
<?= $form->field($model, 'content')->widget(Simditor::className(), [
    'options' => [
        'value' => 'test',
    ],
    'pluginOptions' => [
        'toolbar' => ['title', 'bold']
    ]
]);?>
```
Upload Setting
---
Add in controller
```php
public function actions()
{
        return [
            'upload' => [
                'class' => 'zxp\simditor\SimditorAction',
                'config' => [
                    'uploadDir' => '@webroot/upload/editor',
                    'uploadUrl' => '@web/upload/editor'
                ]
            ]
        ];
}
```