<?php


namespace pravda1979\metrika\abstracts;

use pravda1979\metrika\interfaces\DataInterface;
use pravda1979\metrika\interfaces\MethodInterface;
use Yii;
use yii\base\Model;

/**
 * Class AbstractData
 * @package pravda1979\metrika\abstracts
 */
abstract class AbstractData extends Model implements DataInterface, MethodInterface
{
    const PERIOD_ALL = 'all';
    const PERIOD_YEAR = 'year';
    const PERIOD_QUARTER = 'quarter';
    const PERIOD_MONTH = 'month';
    const PERIOD_WEEK = 'week';
    const PERIOD_DAY = 'day';

    /** @var string */
    public $period = self::PERIOD_WEEK;

    /** @var bool */
    public $useCache = true;

    /** @var int */
    public $cacheDuration = 600;

    /**
     * @inheritDoc
     */
    public function rules()
    {
        return [
            ['period', 'safe'],
        ];
    }

    /**
     * @return array
     */
    public function attributeLabels()
    {
        return [
            'period' => 'Период',
        ];
    }

    /**
     * @return mixed
     */
    public static function getPeriodAsDropdown()
    {
        $result = [
            self::PERIOD_ALL => 'За все время',
            self::PERIOD_YEAR => 'За год',
            self::PERIOD_QUARTER => 'За квартал',
            self::PERIOD_MONTH => 'За месяц',
            self::PERIOD_WEEK => 'За неделю',
        ];
        return $result;
    }

    /**
     * @return string
     */
    public function getGroupValue()
    {
        if ($this->period == self::PERIOD_ALL) {
            $group = self::PERIOD_YEAR;
        } elseif ($this->period == self::PERIOD_YEAR) {
            $group = self::PERIOD_MONTH;
        } elseif ($this->period == self::PERIOD_QUARTER) {
            $group = self::PERIOD_MONTH;
        } else {
            $group = self::PERIOD_DAY;
        }
        return $group;
    }


    /**
     * @param $key
     * @param $func
     * @param int $cacheDuration
     * @return mixed
     */
    public function getCachedData($key, $func, $cacheDuration = null)
    {
        $cache = Yii::$app->cache;
        if ($cacheDuration === null) {
            $cacheDuration = $this->cacheDuration;
        }
        if (!$this->useCache) {
            $cache->delete($key);
        }
        return $cache->getOrSet($key, $func, $cacheDuration);
    }
}