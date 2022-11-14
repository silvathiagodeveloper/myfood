<?php

namespace App\Observers;

use App\Models\Admin\Category;
use Illuminate\Support\Str;

class CategoryObserver
{
    /**
     * Handle the Category "created" event.
     *
     * @param  \App\Models\Admin\Category  $category
     * @return void
     */
    public function creating(Category $category)
    {
        $category->url = $this->createUrl($category->name);
    }

    /**
     * Handle the Category "updated" event.
     *
     * @param  \App\Models\Admin\Category  $category
     * @return void
     */
    public function updating(Category $category)
    {
        $category->url = $this->createUrl($category->name);
    }

    private function createUrl(string $name) : string
    {
        return Str::kebab($name);
    }
}
