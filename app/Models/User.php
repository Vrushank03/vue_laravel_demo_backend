<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Laravel\Sanctum\HasApiTokens;
use Illuminate\Foundation\Auth\User as Authenticatable;


class User extends Authenticatable
{
    use HasFactory;

    use SoftDeletes;

    use HasApiTokens;

    protected $table = 'users';

    protected $primaryKey = 'user_id';

    protected $fillable = [
        'user_id', 'first_name', 'last_name', 'email', 'password', 'phone_number', 'avatar',
        'status', 'created_at', 'updated_at', 'deleted_at'
    ];


    public function blog()
    {
        return $this->hasMany(Blog::class,'user_id');
    }

}
