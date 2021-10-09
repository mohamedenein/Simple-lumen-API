<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class ArticlesResource extends JsonResource
{
    public function toArray($request)
    {
        return [
            'title' => $this->title[app()->getLocale()],
            'content' => $this->content[app()->getLocale()],
            'created_at' => $this->created_at
        ];
    }

}
