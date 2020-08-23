<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class ProductResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'user_id' => $this->user_id,
            'user_name' => $this->user_name,
            'name' => $this->name,
            'description' => $this->description,
            'image' => $this->image,
            'price' => $this->price,
            'can_edit' => $this->can_edit,
        ];
    }
}
