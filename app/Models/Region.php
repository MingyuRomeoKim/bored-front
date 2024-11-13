<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
class Region extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = ['name'];

    // 테마들과의 관계 설정
    public function themes()
    {
        return $this->hasMany(Theme::class);
    }
}
