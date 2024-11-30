<?php

namespace App\Utils;

use Illuminate\Support\Facades\Redis;

class CacheUtil
{
    public static function clearCacheByPattern($prefix)
    {
        // 패턴에 해당하는 Redis 키 검색
        $connection = Redis::connection('cache');
        $keys = $connection->keys('*'.$prefix . '*');

        // 각 키에 대해 캐시 삭제
        foreach ($keys as $key) {
            $connection->del($key);
        }
    }
}

