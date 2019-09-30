<?php

namespace App\Services;

use App\Interfaces\RedisInterface;
use Predis\Client;
use Symfony\Component\Cache\Adapter\RedisAdapter;

class RedisService implements RedisInterface
{
    /**
     * @var Client|\Redis|\RedisCluster
     */
    protected $redis;

    /**
     * RedisService constructor.
     */
    public function __construct()
    {
        $this->redis = RedisAdapter::createConnection(
            $_ENV['REDIS_SERVER'],
            [
                'compression' => true,
                'lazy' => false,
                'persistent' => 0,
                'persistent_id' => null,
                'tcp_keepalive' => 0,
                'timeout' => 30,
                'read_timeout' => 0,
                'retry_interval' => 0,
            ]
        );
    }

    /**
     * @param string $key
     * @return bool|mixed|string
     */
    public function getItem(string $key)
    {
        if (!$this->redis->exists($key)) {
            return 'key not found';
        }

        return $this->redis->get($key);
    }

    /**
     * @param string $key
     * @param $value
     * @return mixed|void
     */
    public function setItem(string $key, $value)
    {
        if (!$this->redis->exists($key)) {
            $this->redis->set($key, $value);
        }
    }

    /**
     * @param $key
     * @return mixed|void
     */
    public function removeItem($key)
    {
        if ($this->redis->exists($key)) {
            $this->redis->del($key);
            $msg = 'key cache remove';
        } else {
            $msg = 'key not found';
        }

        return $msg;
    }

    /**
     * @return array|mixed
     */
    public function allItems()
    {
        $arr = [];

        foreach($this->redis->keys('*') as $item) {
            array_push($arr, ['item' => json_decode($this->getItem($item))]);
        }

        return $arr;
    }

    /**
     * @return array|string
     */
    public function getInfo()
    {
        return $this->redis->info();
    }

    /**
     * @return int
     */
    public function lastSave()
    {
        return $this->redis->lastSave();
    }
}