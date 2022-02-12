<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class TodayTaskResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        // return parent::toArray($request);
        return array(
            'id'        => $this->id,
            'taskId'    => $this->taskId,
            'title'     => $this->title,
            'completed' => $this->completed,
            'approved'  => $this->approved,
            'waiting'   => $this->waiting,            
        );

    }
}
