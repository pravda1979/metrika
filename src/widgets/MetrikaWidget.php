<?php


namespace pravda1979\metrika\widgets;

use pravda1979\metrika\abstracts\AbstractData;
use pravda1979\metrika\forms\FilterForm;
use pravda1979\metrika\interfaces\MethodInterface;
use yii\base\Exception;
use yii\base\Widget;

/**
 * Class MetrikaWidget
 * @package pravda1979\metrika\widgets
 */
class MetrikaWidget extends Widget implements MethodInterface
{
    /** @var AbstractData */
    private $_dataLoader;

    /** @var string */
    public $method;

    /** @var string */
    public $viewFile = 'index';

    /** @var string */
    public $filterViewFile = 'filter';

    /** @var string */
    public $label = '';

    /** @var string */
    public $url;

    /** @var string */
    public $showFilter = true;

    /**
     * @throws Exception
     * @throws \yii\base\InvalidConfigException
     */
    public function init()
    {
        parent::init();
        if ($this->method === null) {
            throw new Exception('You must set "method" property');
        }
        if ($this->url === null) {
            throw new Exception('You must set "url" property');
        }
        if ($this->getDataLoader() === null) {
            $this->setDataLoader(\Yii::createObject(AbstractData::class));
        }
    }

    /**
     * @return AbstractData|null
     */
    public function getDataLoader(): ?AbstractData
    {
        return $this->_dataLoader;
    }

    /**
     * @param AbstractData $dataLoader
     */
    public function setDataLoader(AbstractData $dataLoader)
    {
        $this->_dataLoader = $dataLoader;
    }

    /**
     * @return string|void
     * @throws Exception
     */
    public function run()
    {
        return $this->render($this->viewFile, [
            'label' => $this->label,
            'filterViewFile' => $this->filterViewFile,
            'dataLoader' => $this->getDataLoader(),
            'method' => $this->method,
            'url' => $this->url,
            'chartId' => uniqid($this->method),
            'showFilter' => $this->showFilter,
        ]);
    }

    /**
     * @param $method
     * @return array
     * @throws Exception
     */
    public function getData()
    {
        switch ($this->method) {
            case self::METHOD_PAGEVIEWS:
                return $this->getDataLoader()->getDataPageviews();
            case self::METHOD_SESSIONS:
                return $this->getDataLoader()->getDataVisits();
            default:
                throw new Exception('Wrong "method" property');
        }

    }
}