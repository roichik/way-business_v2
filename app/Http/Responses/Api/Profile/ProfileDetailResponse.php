<?php

namespace App\Http\Responses\Api\Profile;

use App\Models\User\User;
use Illuminate\Http\Resources\Json\JsonResource;

/**
 * Class ProfileDetailResponse
 */
class ProfileDetailResponse extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param Request $request
     * @return array
     */
    public function toArray($request)
    {
        /** @var User $this */
        return [
            'nickname'          => $this->id,
            'email'             => $this->email,
            'email_verified_at' => $this->email_verified_at,
            'phone'             => $this->phone,
            'phone_verified_at' => $this->phone_verified_at,
            'created_at'        => $this->created_at->toDateTimeString(),
            'updated_at'        => $this->updated_at->toDateTimeString(),
            'detail'            => [
                'first_name'  => $this->detail->first_name,
                'last_name'   => $this->detail->last_name,
                'father_name' => $this->detail->father_name,
                'gender'      => $this->detail->gender,
                'birthday_at' => $this->detail->birthday_at->toDateString(),
                'created_at'  => $this->detail->created_at->toDateTimeString(),
                'updated_at'  => $this->detail->updated_at->toDateTimeString(),
            ],
        ];
    }
}
