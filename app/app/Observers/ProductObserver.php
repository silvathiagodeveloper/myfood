<?php

namespace App\Observers;

use App\Models\Admin\Product;
use Illuminate\Support\Str;

class ProductObserver
{
    /**
     * Handle the Product "created" event.
     *
     * @param  \App\Models\Admin\Product  $product
     * @return void
     */
    public function creating(Product $product)
    {
        $product->url = $this->createUrl($product->name);
    }

    /**
     * Handle the Product "updated" event.
     *
     * @param  \App\Models\Admin\Product  $product
     * @return void
     */
    public function updating(Product $product)
    {
        $product->url = $this->createUrl($product->name);
    }

    private function createUrl(string $name) : string
    {
        return Str::kebab($name);
    }
}
