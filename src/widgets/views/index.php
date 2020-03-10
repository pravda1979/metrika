<?php

/** @var $this \yii\web\View */
/** @var $data array */
/** @var $options array */
/** @var $label string */
/** @var $filterViewFile string */
/** @var $dataLoader \pravda1979\metrika\abstracts\AbstractData */
/** @var $method string */
/** @var $url string */
/** @var $showFilter boolean */

/** @var $chartId string */

use miloschuman\highcharts\Highcharts;

\pravda1979\metrika\assets\MetrikaWidgetAsset::register($this);

?>
<div class="metrika-widget-container"
     data-url="<?= \yii\helpers\Url::to([$url, 'method' => $method, 'dataLoaderClass' => $dataLoader::className()]) ?>"
     data-chartId="<?= $chartId ?>">

    <div class="metrika-widget-title">
        <?= $label ?>
    </div>

    <div class="metrika-widget-search">
        <?php if ($showFilter) {
            echo $this->render($filterViewFile, [
                'dataLoader' => $dataLoader,
                'method' => $method,
                'chartId' => $chartId,
                'url' => $url,
            ]);
        } ?>
    </div>

    <div class="metrika-widget-chart">
        <?= Highcharts::widget([
            'id' => $chartId,
            'options' => [
                'title' => '',
            ],
        ]); ?>
    </div>
</div>
