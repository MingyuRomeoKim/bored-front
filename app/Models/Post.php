<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
class Post extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = ['theme_id', 'user_id', 'title', 'content', 'ip'];

    // 테마와의 관계 설정
    public function theme()
    {
        return $this->belongsTo(Theme::class);
    }

    // 작성자와의 관계 설정
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    // 댓글들과의 관계 설정
    public function comments()
    {
        return $this->hasMany(Comment::class);
    }
}
