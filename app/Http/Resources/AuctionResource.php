<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class AuctionResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        return [
            'id'  => $this->id,
            'car'  => $this->car,
            'images' => $this->car->images,
            'starting_price'  => $this->starting_price,
            'life_cycle'  => $this->life_cycle,
            'start'  => $this->start,
            'finish'  => $this->finish,
            'join_btn_message_id'  => $this->join_btn_message_id,
        ];
    }
}
