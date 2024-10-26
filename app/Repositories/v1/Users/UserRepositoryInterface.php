<?php
namespace App\Repositories\v1\Users;

interface UserRepositoryInterface
{
    public function createUser(array $data);
    public function applicationStatus(array $data);
}
