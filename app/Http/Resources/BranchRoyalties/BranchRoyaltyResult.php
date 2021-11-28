<?php

namespace App\Http\Resources\BranchRoyalties;

use Illuminate\Http\Resources\Json\JsonResource;

class BranchRoyaltyResult extends JsonResource
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
            'id' => $this->id,
            'branch' => $this->branch->name,
            'description' => $this->description,
            'amount' => $this->amount,
            'branchId' => $this->branch_id
        ];
    }
}
