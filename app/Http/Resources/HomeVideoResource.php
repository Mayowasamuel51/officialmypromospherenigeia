<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class HomeVideoResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id'=>$this->id,
            'thumbnails'=>$this->thumbnails,
            'user_id'=>$this->user_id ,
            'titlevideourl'=>$this->titlevideourl,
        'user_image'=>$this->user_image,
        'productName'=>$this->productName,
        'user_name'=>$this->user_name,
            'categories'=>$this->categories,
            'user_phone'=>$this->user_phone,
            'user_website'=>$this->user_website,
            'price_range'=>$this->price_range,
            'description'=>$this->description,
            'whatapp'=>$this->whatapp,
            
            // 'titlevideourl'=>$this->titlevideourl
        ];
    }
}
