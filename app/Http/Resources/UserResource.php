<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class UserResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        $data = parent::toArray($request);
        $data['image'] =  $this->image ? url('storage/profile_images/' . $this->image) : null;
        $data['default_image_path'] = url('images/default_profile.png');
        return $data;
    }
}
