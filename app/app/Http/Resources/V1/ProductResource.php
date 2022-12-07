<?php

namespace App\Http\Resources\V1;

use Carbon\Carbon;
use Illuminate\Http\Resources\Json\JsonResource;

class ProductResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        return [
            'id' => $this->uuid,
            'name' => $this->name,
            'url' => $this->url,
            'description' => $this->description,
            'price' => $this->price,
            'image' => $this->image ? url("storage/{$this->image}") : '',
            'date_created' => Carbon::parse($this->created_at)->format('d-m-Y'),
        ];
    }
}
