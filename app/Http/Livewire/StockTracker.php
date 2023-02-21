<?php

namespace App\Http\Livewire;

use App\Enums\RetailerEnum;
use App\Models\Product;
use Illuminate\Contracts\View\View;
use Illuminate\Validation\Rule;
use Livewire\Component;

class StockTracker extends Component
{
    public array $retailers = [];

    public string $retailer = '';

    public string $name = '';

    public string $url = '';

    public function mount()
    {
        $retailers = array_map(
            fn(RetailerEnum $retailer) => $retailer->value,
            RetailerEnum::cases()
        );

        $this->retailers = array_combine($retailers, $retailers);
    }

    public function add()
    {
        $this->validate([
            'retailer' => ['required', 'string', Rule::in($this->retailers)],
            'name' => ['required', 'string', 'max:255'],
            'url' => ['required', 'url', 'max:255'],
        ]);

        $product = Product::create([
            'name' => $this->name,
            'retailer' => RetailerEnum::tryFrom($this->retailer),
            'url' => $this->url,
        ]);

        $product->checkAndUpdateStock();

        $this->resetExcept('retailers');
    }

    public function remove(Product $product)
    {
        $product->delete();
    }

    public function refreshStock()
    {
        /** @var Product $product */
        foreach ($this->products as $product) {
            $product->checkAndUpdateStock();
        }
    }

    public function getProductsProperty()
    {
        return Product::all();
    }

    public function render(): View
    {
        return view('livewire.stock-tracker');
    }
}
