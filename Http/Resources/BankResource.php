<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class BankResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
          return [
            'id'                => (int)       $this->id,
            'name'              => (string)    $this->name,
            'account_name'      => (string)    $this->account_name,
            'account_number'    => (string)    $this->account_number,
            'iban'              => (string)    $this->iban,
            'icon'              => (string)    $this->icon,
        ];
    }
}
