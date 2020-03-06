<?php


namespace pravda1979\metrika\widgets;

use pravda1979\metrika\interfaces\DataInterface;
use pravda1979\metrika\interfaces\MethodInterface;
use yii\base\Exception;
use yii\base\Widget;

/**
 * Class MetrikaWidget
 * @package pravda1979\metrika\widgets
 */
class MetrikaWidget extends Widget implements MethodInterface
{
    /** @var DataInterface */
    private $_dataLoader;

    /** @var string */
    public $method;

    /**
     * @throws Exception
     * @throws \yii\base\InvalidConfigException
     */
    public function init()
    {
        parent::init();
        if ($this->getDataLoader() === null) {
            $this->_dataLoader = \Yii::createObject(DataInterface::class);
        }
        if ($this->method === null) {
            throw new Exception('Wrong "method" property');
        }

    }

    /**
     * @return DataInterface|null
     */
    public function getDataLoader(): ?DataInterface
    {
        return $this->_dataLoader;
    }

    /**
     * @param DataInterface $dataLoader
     */
    public function setDataLoader(DataInterface $dataLoader)
    {
        $this->_dataLoader = $dataLoader;
    }

    /**
     * @return string|void
     * @throws Exception
     */
    public function run()
    {
        $data = $this->getData($this->method);
        \yii\helpers\VarDumper::dump($data, 10, 1);
    }

    /**
     * @param $method
     * @return array
     * @throws Exception
     */
    private function getData($method)
    {
        switch ($method) {
            case self::METHOD_PAGEVIEWS:
                return $this->_dataLoader->getDataPageviews();
            default:
                throw new Exception('Wrong "method" property');
        }

    }

}