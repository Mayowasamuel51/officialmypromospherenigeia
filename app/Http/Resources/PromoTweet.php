<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class PromoTweet extends JsonResource
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
            'description'=>$this->description,
            'titleImageurl'=>$this->titleImageurl,
            'title'=>$this->title,
            'created_at'=>$this->created_at
        ];
    }
}
