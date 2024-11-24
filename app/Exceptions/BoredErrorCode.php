<?php

namespace App\Exceptions;

class BoredErrorCode
{
    public static array $COMMON_FAIL = [
        'code' => 100,
        'message' => '일반적인 실패',
    ];

    public static array $COMMON_UNAUTHORIZED = [
        'code' => 101,
        'message' => '인증되지 않은 사용자',
    ];

    public static array $COMMON_FORBIDDEN = [
        'code' => 102,
        'message' => '권한이 없는 사용자',
    ];

    public static array $COMMON_NOT_LOGIN = [
        'code' => 103,
        'message' => '로그인 후 사용 가능합니다.',
    ];

    public static array $COMMON_NOT_FOUND = [
        'code' => 104,
        'message' => '찾을 수 없는 자원',
    ];

    public static array $JWT_INVALID = [
        'code' => 1001,
        'message' => 'JWT 토큰이 유효하지 않음',
    ];
}
