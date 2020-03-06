<?php


namespace pravda1979\metrika\data;

use pravda1979\metrika\abstracts\AbstractData;

/**
 * Class DummyData
 * @package pravda1979\metrika\data
 */
class DummyData extends AbstractData
{
    /**
     * @return array
     */
    public function getDataPageviews(): array
    {
        return [
            'Item 1' => 100,
            'Item 2' => 200,
            'Item 3' => 300,
        ];
    }
}