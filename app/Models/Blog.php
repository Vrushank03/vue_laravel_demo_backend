<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Laravel\Sanctum\HasApiTokens;



class Blog extends Model
{
    use HasFactory,SoftDeletes;

    protected $table = 'blogs';

    protected $primaryKey = 'blog_id';

    protected $fillable = ['blog_id','user_id','category_id','title', 'description','category','image','status',
                           'created_at','updated_at','deleted_at'];


    public function user()
    {
        return $this->belongsTo(User::class,'user_id');
    }

    public function category()
    {
        return $this->belongsTo(category::class,'category_id','category_id');
    }

}
