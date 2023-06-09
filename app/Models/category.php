<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class category extends Model
{
    use HasFactory , SoftDeletes;

    protected $table = 'categories';

    protected $primaryKey = 'category_id';

    protected $fillable = ['category_id','category_name ','created_at','updated_at','deleted_at'];

}
