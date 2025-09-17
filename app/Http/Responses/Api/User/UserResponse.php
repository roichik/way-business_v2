<?php

namespace App\Http\Responses\Api\User;

use App\Models\User\User;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

/**
 * Class UserResponse
 */
class UserResponse extends JsonResource
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
            'id'                => $this->id,
            'nickname'          => $this->nickname,
            'email'             => $this->email,
            'email_verified_at' => $this->email_verified_at,
            'phone'             => $this->phone,
            'phone_verified_at' => $this->phone_verified_at,
            'is_enabled'        => $this->is_enabled,
            'flags'             => $this->flags,
            'created_at'        => $this->created_at->toDateTimeString(),
            'updated_at'        => $this->updated_at->toDateTimeString(),
            'detail'            => [
                'first_name'  => $this->detail->first_name,
                'last_name'   => $this->detail->last_name,
                'father_name' => $this->detail->father_name,
                'gender'      => $this->detail->gender,
                'birthday_at' => $this->detail->birthday_at->toDateString(),
                'type'        => [
                    'id'    => $this->detail->type->id,
                    'title' => $this->detail->type->title,
                ],
                'company'     => $this->detail->company ? [
                    'id'    => $this->detail->company->id,
                    'title' => $this->detail->company->title,
                ] : null,
                'division'    => $this->detail->division ? [
                    'id'    => $this->detail->division->id,
                    'title' => $this->detail->division->title,
                ] : null,
                'position'    => $this->detail->position ? [
                    'id'    => $this->detail->position->id,
                    'title' => $this->detail->position->title,
                ] : null,
            ],
        ];
    }
}
