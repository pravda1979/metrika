<?php

use yii\widgets\ActiveForm;

/** @var $this \yii\web\View */
/** @var $dataLoader \pravda1979\metrika\abstracts\AbstractData */
/** @var $method string */
/** @var $chartId string */
/** @var $url string */

?>

<?php $form = ActiveForm::begin() ?>

<?= $form->field($dataLoader, 'period')->dropDownList($dataLoader::getPeriodAsDropdown(), [
    'class' => 'form-control chart-filter-input',
])->label(false) ?>

<?php $form = ActiveForm::end() ?>