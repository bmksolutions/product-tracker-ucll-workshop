<?php

namespace App\Spiders;

use Generator;
use RoachPHP\Downloader\Middleware\RequestDeduplicationMiddleware;
use RoachPHP\Downloader\Middleware\UserAgentMiddleware;
use RoachPHP\Extensions\LoggerExtension;
use RoachPHP\Extensions\StatsCollectorExtension;
use RoachPHP\Http\Response;
use RoachPHP\Spider\BasicSpider;

class CoolblueSpider extends BasicSpider
{
    public array $startUrls = [
        //
    ];

    public array $downloaderMiddleware = [
        RequestDeduplicationMiddleware::class,
        [
            UserAgentMiddleware::class,
            ['userAgent' => 'Mozilla/5.0 (compatible; RoachPHP/0.1.0)'],
        ]
    ];

    public array $spiderMiddleware = [
        //
    ];

    public array $itemProcessors = [
        //
    ];

    public array $extensions = [
        LoggerExtension::class,
        StatsCollectorExtension::class,
    ];

    public int $concurrency = 2;

    public int $requestDelay = 1;

    public function parse(Response $response): Generator
    {
        $price = $response
            ->filter('.sales-price__current.js-sales-price-current')
            ->text();

        $inStock = (bool) $response
            ->filter('.product-order .js-add-to-cart-button')
            ->html('');

        yield $this->item([
            'price' => (float) str_replace(',', '.', $price),
            'in_stock' => $inStock,
        ]);
    }
}
