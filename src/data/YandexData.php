<?php

namespace pravda1979\metrika\data;

use pravda1979\metrika\abstracts\AbstractData;
use pravda1979\metrika\api\YandexApi;
use pravda1979\metrika\interfaces\ApiInterface;
use yii\base\Exception;

/**
 * Class YandexData
 * @package pravda1979\metrika\data
 */
class YandexData extends AbstractData
{
    /** @var ApiInterface */
    private $api;

    /**
     * YandexData constructor.
     * @param ApiInterface|null $api
     * @throws \yii\base\InvalidConfigException
     */
    public function __construct(ApiInterface $api = null)
    {
        if ($api === null) {
            $api = \Yii::createObject(YandexApi::class);
        }
        $this->api = $api;
    }

    /**
     * @return array
     * @throws Exception
     * @throws \yii\base\InvalidConfigException
     * @throws \yii\httpclient\Exception
     */
    public function getDataPageviews(): array
    {
        $api = $this->api;

        $result = $api->getData('stat/v1/data/bytime', [
            'group' => 'year',
            'date1' => '2015-01-01',
            'date2' => '2020-01-01',
            'metrics' => 'ym:s:pageviews',
        ]);

        return $result;
    }
}
