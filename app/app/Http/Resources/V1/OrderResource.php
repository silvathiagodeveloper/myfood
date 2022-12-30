<?php

namespace App\Http\Resources\V1;

use Carbon\Carbon;
use Illuminate\Http\Resources\Json\JsonResource;

class OrderResource extends JsonResource
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
            'total' => number_format($this->total,2,'.'),
            'status' => $this->status,
            'description' => $this->description,
            'date_created' => Carbon::parse($this->created_at)->format('Y-m-d'),
            'company' => new TenantResource($this->tenant),
            'table' => $this->table_id ? new TableResource($this->table) : '',
            'client' => $this->client_id ? new ClientResource($this->client) : '',
            'products' => new ProductResourceCollection($this->products),
        ];
    }
}
