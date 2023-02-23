<?php

namespace App\Models;

use App\Enums\RetailerEnum;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use RoachPHP\Roach;
use RoachPHP\Spider\Configuration\Overrides;

class Product extends Model
{
    use HasFactory;

    protected $guarded = ['id'];

    protected $casts = [
        'in_stock' => 'boolean',
        'retailer' => RetailerEnum::class
    ];

    public function price(): Attribute
    {
        return Attribute::make(
            get: fn($value) => $value / 100,
            set: fn($value) => $value * 100
        );
    }

    public function checkAndUpdateStock(): void
    {
        $items = Roach::collectSpider(
            $this->retailer->getSpiderClass(),
            new Overrides(startUrls: [$this->url])
        );

        // dd($items);

        $this->update([
            'price' => $items[0]->get('price'),
            'in_stock' => $items[0]->get('in_stock'),
        ]);
    }
}
