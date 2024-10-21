<?php
namespace App\Repositories\v1\Users;

interface UserRepositoryInterface
{
    public function createUser(array $data);
}
