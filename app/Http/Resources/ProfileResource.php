<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class ProfileResource extends JsonResource
{
    public function toArray($request)
    {
        return [
            'name' => $this->name[app()->getLocale()],
            'phone' => $this->phone,
            'email' => $this->email,
            'created_at' => $this->created_at,
            'articles' => ArticlesResource::collection($this->articles)
        ];
    }

}
