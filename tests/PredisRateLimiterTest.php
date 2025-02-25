<?php

declare(strict_types=1);

namespace RateLimit\Tests;

use Predis\Client;
use RateLimit\PredisRateLimiter;
use RateLimit\RateLimiter;

class PredisRateLimiterTest extends RateLimiterTest
{
    protected function getRateLimiter(): RateLimiter
    {
        if (!class_exists('Predis\Client')) {
            $this->markTestSkipped('Predis library is not available');
        }

        $predis = new Client('tcp://127.0.0.1:6379');

        $predis->connect();
        if (!$predis->isConnected()) {
            $this->markTestSkipped('Cannot connect with Predis.');
        }

        $predis->flushdb();

        return new PredisRateLimiter($predis);
    }
}
