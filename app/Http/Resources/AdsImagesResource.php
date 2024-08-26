<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class AdsImagesResource extends JsonResource
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
            'itemfree_ads_id'=>$this->	itemfree_ads_id ,
            'itemadsimagesurls'=>$this->itemadsimagesurls,
            // 'user_image'=>$this->user_image,
            // 'categories'=>$this->categories
            // 'titlevideourl'=>$this->titlevideourl
        ];
    }
}
