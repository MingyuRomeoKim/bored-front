<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Comment extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = ['post_id', 'parent_id', 'user_id', 'content', 'ip'];

    // 포스팅과의 관계 설정
    public function post()
    {
        return $this->belongsTo(Post::class);
    }

    // 작성자와의 관계 설정
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    // 부모 댓글과의 관계 설정
    public function parent()
    {
        return $this->belongsTo(Comment::class, 'parent_id');
    }

    // 자식 댓글들과의 관계 설정 (대댓글, 대대댓글)
    public function children()
    {
        return $this->hasMany(Comment::class, 'parent_id');
    }
}
