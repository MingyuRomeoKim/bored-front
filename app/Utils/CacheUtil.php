<?php

namespace App\Utils;

use Illuminate\Support\Facades\Redis;

class CacheUtil
{
    public static function clearCacheByPattern($prefix)
    {
        $connection = Redis::connection('cache')->client();
        $cursor = 0;
        do {
            [$cursor, $keys] = $connection->scan($cursor, ['MATCH' => '*' . $prefix . '*', 'COUNT' => 1000]);

            foreach ($keys as $key) {
                $connection->executeRaw(['DEL', $key]); // Native DEL 명령 실행
            }
        } while ($cursor > 0);
    }

    // 캐시 생성
    public static function putCache($key, $value, $ttl)
    {
        Redis::connection('cache')->set($key, $value, 'EX', $ttl);
    }
}

