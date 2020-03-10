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

Config:
-------

config file:

```
'container' => [
    'definitions' => [
        
        // Widget
        \pravda1979\metrika\widgets\MetrikaWidget::class => [
            'url' => '/metrika/get-chart-data',
        ],
        
        // Yandex Api
        \pravda1979\metrika\api\YandexApi::class => [
            'ids' => '12345678',
            'token' => '***************************',
        ],

        // Yandex dataLoader
        \pravda1979\metrika\data\YandexData::class => [
            // optional params
            'period' => \pravda1979\metrika\abstracts\AbstractData::PERIOD_MONTH,
            'useCache' => false,
        ],

        // Default dataLoader
        \pravda1979\metrika\abstracts\AbstractData::class => \pravda1979\metrika\data\YandexData::class,
        
    ],
],
```

action in controller:

```
/**
 * @return array
 */
public function actions()
{
    return [
        'get-chart-data' => [
            'class' => ActionGetChartData::class,
        ]
    ];
}
```


    
Widget:
-------

```
<div class="col-md-6">
    <?= MetrikaWidget::widget([
        'method' => MetrikaWidget::METHOD_PAGEVIEWS,
        // optional params: 
        // 'label' => 'Хиты',
        // 'viewFile' => 'path/to/fiewFile',
        // 'filterViewFile' => 'path/to/filterViewFile',
        // 'url' => 'url/to/action',
        // 'dataLoader' => new \pravda1979\metrika\data\YandexData(['period' => \pravda1979\metrika\data\YandexData::PERIOD_YEAR]),
        // 'dataLoader' => new \pravda1979\metrika\data\DummyData(),
        // 'showFilter' => false,
    ]) ?>
</div>
<div class="col-md-6">
    <?= MetrikaWidget::widget([
        'method' => MetrikaWidget::METHOD_SESSIONS,
        'label' => 'Визиты',
    ]) ?>
</div>
```
