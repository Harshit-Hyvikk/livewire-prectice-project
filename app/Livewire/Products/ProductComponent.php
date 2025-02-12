<?php

namespace App\Livewire\Products;

use App\Models\Product;
use Livewire\Component;

class ProductComponent extends Component
{
    public Product $product;
    public function mount(Product $product)
    {
        $this->product = $product;
        dd($product);
    }

    // public function getProductName()
    // {
    //     return $this->product->name;
    // }
    public function render()
    {
        return view('livewire.products.product-component');
    }
}
