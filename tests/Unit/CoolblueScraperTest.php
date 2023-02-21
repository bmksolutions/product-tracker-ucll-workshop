<?php

namespace Tests\Unit;

use App\Models\Product;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class CoolblueScraperTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function it_scrapes_product_stock(): void
    {
        $product = Product::factory()->create([
            'price' => null,
            'in_stock' => false,
            'url' => 'https://www.coolblue.be/en/product/885149/elden-ring-ps5.html'
        ]);

        $this->assertFalse($product->in_stock);

        $product->checkAndUpdateStock();

        $this->assertTrue($product->fresh()->in_stock);

        $this->assertNotNull($product->fresh()->price);
    }
}
