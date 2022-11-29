<?php

namespace App\Observers;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class UrlObserver
{
    /**
     * Handle the Model "created" event.
     *
     * @param  \Illuminate\Database\Eloquent\Model  $model
     * @return void
     */
    public function creating(Model $model)
    {
        $model->url = $this->createUrl($model->name);
    }

    /**
     * Handle the Model "updated" event.
     *
     * @param  \Illuminate\Database\Eloquent\Model  $model
     * @return void
     */
    public function updating(Model $model)
    {
        $model->url = $this->createUrl($model->name);
    }

    private function createUrl(string $name) : string
    {
        return Str::kebab($name);
    }
}
