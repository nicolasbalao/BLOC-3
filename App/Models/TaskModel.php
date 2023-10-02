<?php

namespace App\Models;

class TaskModel extends Model
{
    protected int $id;
    protected string $name;
    protected bool $done;

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

    public function getDone()
    {
        return $this->done;
    }

    public function setDone(string $done)
    {
        $this->done = $done;
    }
}
