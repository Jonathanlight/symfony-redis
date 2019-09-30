<?php

namespace App\Interfaces;

interface RedisInterface{

    /**
     * @param string $key
     * @return mixed
     */
    public function getItem(string $key);

    /**
     * @param string $key
     * @param $value
     * @return mixed
     */
    public function setItem(string $key, $value);

    /**
     * @param string $key
     * @return mixed
     */
    public function removeItem(string $key);

    /**
     * @return mixed
     */
    public function allItems();

    /**
     * @return mixed
     */
    public function getInfo();

    /**
     * @return mixed
     */
    public function lastSave();
}