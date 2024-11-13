<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
class Theme extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = ['name', 'region_id'];

    // 지역과의 관계 설정
    public function region()
    {
        return $this->belongsTo(Region::class);
    }

    // 포스팅들과의 관계 설정
    public function posts()
    {
        return $this->hasMany(Post::class);
    }
}
