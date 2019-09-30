<?php

namespace App\Manager;

use App\Services\RedisService;

class UserManager
{
    /**
     * @var RedisService
     */
    protected $redisService;

    /**
     * UserManager constructor.
     * @param RedisService $redisService
     */
    public function __construct(RedisService $redisService)
    {
        $this->redisService = $redisService;
    }

    /**
     * @param $data
     * @return false|string
     */
    public function create($data)
    {
        $user = [
            'id' => uniqid(),
            'name' => $data['name']??'',
            'year' => $data['year']??'',
            'city' => $data['city']??''
        ];

        return $this->redis_save($user['id'], json_encode($user));
    }

    /**
     * @param $key
     * @param $data
     * @return mixed|void
     */
    public function redis_save($key, $data)
    {
        return $this->redisService->setItem($key, $data);
    }

    /**
     * @param $data
     * @return mixed|void
     */
    public function redis_remove($data)
    {
        return $this->redisService->removeItem($data['id']);
    }
}