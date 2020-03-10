<?php


namespace pravda1979\metrika\actions;


use pravda1979\metrika\widgets\MetrikaWidget;
use Yii;
use yii\base\Action;

/**
 * Class ActionGetChartData
 * @package pravda1979\metrika\actions
 */
class ActionGetChartData extends Action
{
    /**
     * @param string $method
     * @param string $dataLoaderClass
     * @return \yii\web\Response
     * @throws \yii\base\Exception
     * @throws \yii\base\InvalidConfigException
     */
    public function run(string $method, string $dataLoaderClass)
    {
        $dataLoader = Yii::createObject($dataLoaderClass);
        $dataLoader->load(\Yii::$app->request->get());
        $dataLoader->validate();

        $widget = Yii::createObject([
            'class' => MetrikaWidget::class,
            'method' => $method,
            'dataLoader' => $dataLoader,
        ]);

        $data = $widget->getData();

        return $this->controller->asJson($data);
    }
}