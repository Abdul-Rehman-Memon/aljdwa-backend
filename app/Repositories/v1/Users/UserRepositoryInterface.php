<?php
namespace App\Repositories\v1\Users;

interface UserRepositoryInterface
{
    public function createUser(array $data);
    public function forgetPassword(array $data);
    public function applicationStatus(array $data);
    public function getUser(string $userId);
    public function updateUser(array $data,string $userId);
    public function getMentorApplications(object $data);
    public function reviewMentorApplication(string $applicationId);
}
