<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class HomePageControllerResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        // return parent::toArray($request);
        return [
            'id'=>$this->id,
            'user_id'=>$this->user_id ,
            'user_name'=>$this->user_name,
            'titleImageurl'=>$this->titleImageurl,
            'user_image'=>$this->user_image,
        'price_range'=>$this->price_range,
            'description'=>$this->description,
            'whatapp'=>$this->whatapp,
            'productName'=>$this->productName,
            'user_phone'=>$this->user_phone,
            'categories'=>$this->categories
            // 'titlevideourl'=>$this->titlevideourl
        ];
    }
}
