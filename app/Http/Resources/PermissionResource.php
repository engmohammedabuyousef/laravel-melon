<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class PermissionResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        $children = authAdmin()->getAllPermissions()->where('parent_id', $this->id)->where('in_menu', 1);
        $childrenObject = PermissionResource::collection($children)->resolve();

        $data = [
            'id' => $this->id,
            'title' => $this->name,
            'root' => $children->first() ? true : false,
            'icon' => $this->icon, // iconSVG($this->icon)
            'page' => $this->link != '#' ? route($this->link) : '#',
            'bullet' => 'line',
            'permission' => $this->name,
            'link' => $this->link,
            'parent_id' => $this->parent_id,
        ];

        if ($children->first()) {
            $data['submenu'] = $childrenObject;
        }

        return $data;
    }
}
