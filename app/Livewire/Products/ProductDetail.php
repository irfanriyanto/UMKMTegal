<?php

namespace App\Livewire\Products;

use App\Models\Product;
use App\Models\ProductView;
use Livewire\Component;

class ProductDetail extends Component
{
    public string $slug;
    public ?Product $product = null;

    public function mount(string $slug)
    {
        $this->slug = $slug;
        $this->product = Product::with(['umkmProfile', 'category', 'images'])
            ->where('slug', $slug)
            ->first();

        if ($this->product) {
            ProductView::recordView($this->product->id, request()->ip());
        }
    }

    public function render()
    {
        return view('livewire.products.product-detail');
    }
}
