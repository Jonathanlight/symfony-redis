<?php

namespace App\Manager;

use App\Services\MessageService;
use App\Services\RedisService;

class UserManager
{
    /**
     * @var RedisService
     */
    protected $redisService;

    /**
     * @var MessageService
     */
    protected $messageService;

    /**
     * UserManager constructor.
     * @param RedisService $redisService
     * @param MessageService $messageService
     */
    public function __construct(
        RedisService $redisService,
        MessageService $messageService
    ) {
        $this->redisService = $redisService;
        $this->messageService = $messageService;
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
        $this->messageService->addSuccess('Data save.');

        return $this->redisService->setItem($key, $data);
    }

    /**
     * @param $data
     * @return mixed|void
     */
    public function redis_remove($data)
    {
        $this->messageService->addSuccess('Data remove.');

        return $this->redisService->removeItem($data['id']);
    }
}