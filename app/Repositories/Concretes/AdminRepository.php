<?php

namespace App\Repositories\Concretes;

use App\Models\Admin;
use App\Repositories\IAdminRepository;

class AdminRepository implements IAdminRepository
{
    public function create(array $attributes)
    {
        return Admin::create($attributes);
    }
}
