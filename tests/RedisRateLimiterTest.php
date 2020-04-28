<?php

declare(strict_types=1);

namespace RateLimit\Tests;

use RateLimit\RateLimiter;
use RateLimit\RedisRateLimiter;
use Redis;

class RedisRateLimiterTest extends RateLimiterTest
{
    protected function getRateLimiter(): RateLimiter
    {
        if (!\extension_loaded('redis')) {
            $this->markTestSkipped('Redis extension not loaded.');
        }

        $redis = new Redis();

        $success = @ $redis->connect('127.0.0.1');

        if (!$success) {
            $this->markTestSkipped('Cannot connect to Redis.');
        }

        $redis->flushDB();

        return new RedisRateLimiter($redis);
    }
}
