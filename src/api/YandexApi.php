<?php

namespace pravda1979\metrika\api;

use pravda1979\metrika\abstracts\AbstractApi;
use yii\base\Exception;
use yii\helpers\ArrayHelper;
use yii\helpers\Json;

/**
 * Class Api
 *
 * @package Yandex\Metrika
 */
class YandexApi extends AbstractApi
{
    /**
     * @var string
     */
    public $apiUrl = 'https://api-metrika.yandex.net';

    /**
     * @var string
     */
    public $lang = 'ru';

    /**
     * @var string
     */
    public $token;

    /**
     * @var string
     */
    public $ids;

    /**
     * @param string $method
     * @param array $options
     * @return array
     * @throws Exception
     * @throws \yii\base\InvalidConfigException
     * @throws \yii\httpclient\Exception
     */
    public function getData(string $method = '', array $options = []): array
    {
        $client = new \yii\httpclient\Client();
        $response = $client->createRequest()
            ->setFormat($client::FORMAT_JSON)
            ->setMethod('get')
            ->setUrl($this->createUrl($method, $options))
            ->setHeaders([
                'Authorization' => 'OAuth ' . $this->token,
                'Content-Type' => 'application/x-yametrika+json'
            ])->send();

        $content = Json::decode($response->content);
        if ($response->headers['http-code'] == 200) {
            return $content;
        } else {
            throw new Exception(ArrayHelper::getValue($content, 'message'), ArrayHelper::getValue($content, 'code'));
        }
    }

    /**
     * @param array $options
     *
     * @return array
     */
    protected function normalizeOptions(array $options): array
    {
        return array_map(function ($key, $value) {
            return $key . '=' . $value;
        }, array_keys($options), array_values($options));

    }

    /**
     * @param string $method
     * @param array $options
     * @return string
     */
    protected function createUrl(string $method, array $options): string
    {
        $options['ids'] = $this->ids;
        $options['lang'] = $this->lang;
        $line = implode('&', $this->normalizeOptions($options));
        $url = $this->apiUrl . '/' . $method . '?' . $line;
        return $url;
    }

}
