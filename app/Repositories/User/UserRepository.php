<?php

namespace App\Repositories\User;
use App\Models\UserModel as User;
use App\Repositories\BaseRepository;

class UserRepository extends BaseRepository implements UserRepositoryInterface
{
    public function __construct(User $user) {
        parent::__construct($user);
    }
}