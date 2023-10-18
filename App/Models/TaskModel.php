<?php

namespace App\Models;

class TaskModel extends Model
{
    protected int $id;
    protected string $name;
    // TODO: refactor done behaviour with the DB (set it to a boolean)
    protected int $done;
    protected int $userId;

    public function __construct()
    {
        $this->table = "tasks";
    }

    public function getId()
    {
        return $this->id;
    }

    public function setId(int $id)
    {
        $this->id = $id;
    }

    public function getName()
    {
        return $this->name;
    }

    public function setName(string $name)
    {
        $this->name = $name;
    }

    public function getDone(): bool
    {
        return $this->done;
    }

    public function setDone(int $done)
    {
        $this->done = $done;
    }

    public function getUserId(): int
    {
        return $this->userId;
    }

    public function setUserId(int $userId)
    {
        $this->userId = $userId;
    }
}
