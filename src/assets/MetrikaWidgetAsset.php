<?php


namespace pravda1979\metrika\assets;


use yii\web\AssetBundle;
use yii\web\JqueryAsset;

class MetrikaWidgetAsset extends AssetBundle
{
    /**
     * @var string
     */
    public $sourcePath = '@pravda1979/metrika/assets/dist/';

    /**
     * @var array
     */
    public $publishOptions = [
        'forceCopy' => YII_DEBUG,
    ];

    /**
     * @var array
     */
    public $js = [
        'js/getChartData.js'
    ];

    /**
     * @var array
     */
    public $depends = [
        JqueryAsset::class,
    ];
}
