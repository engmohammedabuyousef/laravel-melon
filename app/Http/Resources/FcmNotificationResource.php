<?php

namespace App\Http\Resources;

use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class FcmNotificationResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'title' => __('messages.notifications.tilte' . $this->action),
            'body' => __('messages.notifications.body' . $this->action),
            'action' => $this->action,
            'action_id' => $this->action_id,
            'seen' => $this->seen,
            'created_at' => Carbon::parse($this->created_at)->diffForHumans(),
        ];
    }
}
