<?php


namespace pravda1979\metrika\interfaces;

/**
 * Interface ApiInterface
 * @package pravda1979\metrika\interfaces
 */
interface ApiInterface
{
    /**
     * @param string $method
     * @param array $options
     * @return array
     */
    public function getData(string $method, array $options = []): array;
}