Installation
------------

The preferred way to install this extension is through [composer](http://getcomposer.org/download/).

Either run

```
php composer.phar require --prefer-dist pravda1979/yii2-metrika "*"
```

or add

```
"pravda1979/yii2-metrika": "*"
```

to the require section of your `composer.json` file.

Use:
====

Config YandexMetrika:
---------------------

```
    'container' => [
        'definitions' => [
            \pravda1979\metrika\api\YandexApi::class => [
                'ids' => '12345678',
                'token' => '***************************',
            ],
            \pravda1979\metrika\interfaces\DataInterface::class => \pravda1979\metrika\data\YandexData::class,
        ],
    ],
```

Config Dummy:
-------------

```
    'container' => [
        'definitions' => [
            \pravda1979\metrika\interfaces\DataInterface::class => \pravda1979\metrika\data\DummyData::class,
        ],
    ],
```


Widget:
-------

```
    <?= MetrikaWidget::widget([
        'method' => MetrikaWidget::METHOD_PAGEVIEWS,
        // optionally you can change dataLoader:
        // 'dataLoader' => new \pravda1979\metrika\data\YandexData(),
        // 'dataLoader' => new \pravda1979\metrika\data\DummyData(),
    ]) ?>
```
