<?php

namespace pravda1979\metrika\data;

use pravda1979\metrika\abstracts\AbstractData;
use pravda1979\metrika\api\YandexApi;
use pravda1979\metrika\interfaces\ApiInterface;
use Yii;
use yii\base\Exception;
use yii\helpers\ArrayHelper;

/**
 * Class YandexData
 * @package pravda1979\metrika\data
 */
class YandexData extends AbstractData
{
    /** @var string */
    const FIRST_DATE = 'YandexMetrikaFirstDate';

    /** @var string */
    public $minDate = '2010-01-01';

    /** @var ApiInterface */
    private $api;

    /**
     * YandexData constructor.
     * @param array $config
     * @throws \yii\base\InvalidConfigException
     */
    public function __construct($config = [])
    {
        parent::__construct($config);
        $this->api = Yii::createObject(YandexApi::class);
    }


    /**
     * @return array
     * @throws Exception
     * @throws \yii\base\InvalidConfigException
     * @throws \yii\httpclient\Exception
     */
    public function getDataPageviews(): array
    {
        $params = $this->getParams(['metrics' => 'ym:pv:pageviews']);
        $key = [
            __METHOD__,
            __CLASS__,
            $params,
            $this->api->ids,
        ];

        $result = $this->getCachedData($key, function () use ($params) {
            $data = $this->api->getData('stat/v1/data/bytime', $params);
            return $this->convertData($data);
        }, $this->cacheDuration);

        return $result;

    }

    /**
     * @return array
     * @throws Exception
     * @throws \yii\base\InvalidConfigException
     * @throws \yii\httpclient\Exception
     */
    public function getDataVisits(): array
    {
        $params = $this->getParams(['metrics' => 'ym:s:visits']);
        $key = [
            __METHOD__,
            __CLASS__,
            $params,
            $this->api->ids,
        ];

        $result = $this->getCachedData($key, function () use ($params) {
            $data = $this->api->getData('stat/v1/data/bytime', $params);
            return $this->convertData($data);
        }, $this->cacheDuration);

        return $result;
    }

    /**
     * @param $params
     * @return array
     * @throws \yii\base\InvalidConfigException
     */
    private function getParams($params)
    {
        $result = array_merge([
            'group' => $this->getGroupValue(),
            'date1' => Yii::$app->formatter->asDate($this->getDate1Value(), 'php:Y-m-d'),
            'date2' => Yii::$app->formatter->asDate(time(), 'php:Y-m-d'),
        ], $params);
        return $result;
    }

    /**
     * @return string
     */
    private function getDate1Value()
    {
        if ($this->period == self::PERIOD_ALL) {
            $date1 = $this->getFirstDate();
        } elseif ($this->period == self::PERIOD_YEAR) {
            $date1 = '365daysAgo';
        } elseif ($this->period == self::PERIOD_QUARTER) {
            $date1 = '90daysAgo';
        } elseif ($this->period == self::PERIOD_MONTH) {
            $date1 = '30daysAgo';
        } else {
            $date1 = '6daysAgo';
        }
        return $date1;
    }

    /**
     * @param int $cacheDuration
     * @return mixed
     */
    private function getFirstDate($cacheDuration = 0)
    {
        $key = [
            __METHOD__,
            __CLASS__,
            self::FIRST_DATE,
            $this->api->ids,
        ];

        $data = $this->getCachedData($key, function () {
            return $this->getFirstDateValue();
        }, $cacheDuration);

        return $data;
    }

    /**
     * @return string
     * @throws Exception
     * @throws \yii\base\InvalidConfigException
     * @throws \yii\httpclient\Exception
     */
    private function getFirstDateValue()
    {
        $result = $this->api->getData('stat/v1/data', [
            'metrics' => 'ym:s:visits',
            'dimensions' => 'ym:s:date',
            'sort' => 'ym:s:date',
            'limit' => 1,
            'group' => self::PERIOD_DAY,
            'date1' => $this->minDate,
        ]);
        $date = ArrayHelper::getValue($result, 'data.0.dimensions.0.name');
        if (strtotime($date)) {
            return Yii::$app->formatter->asDate($date, 'php:Y-m-d');
        } else {
            return Yii::$app->formatter->asDate($this->minDate, 'php:Y-m-d');
        }
    }

    /**
     * @param array $metricsData
     * @return array
     * @throws \yii\base\InvalidConfigException
     */
    private function convertData(array $metricsData): array
    {
        $result = [
            'labels' => [],
            'data' => [],
        ];

        if (!empty($metricsData)) {
            $data = ArrayHelper::getValue($metricsData, 'data.0.metrics.0');
            $time_intervals = ArrayHelper::getValue($metricsData, 'time_intervals');

            $labels = [];
            foreach ($time_intervals as $interval) {
                if ($interval[0] == $interval[1]) {
                    $labels[] = Yii::$app->formatter->asDate($interval[0], 'php:d.m.Y');
                } else {
                    $labels[] = Yii::$app->formatter->asDate($interval[0], 'php:d.m.Y') . ' - ' . Yii::$app->formatter->asDate($interval[1], 'php:d.m.Y');
                }
            }
            $result = [
                'labels' => $labels,
                'data' => $data,
            ];
        }

        return $result;
    }

}
