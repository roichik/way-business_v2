<?php

namespace App\Http\Responses\Api\User\Profile;

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
            'nickname'        => $this->id,
            'email'           => $this->email,
            'emailVerifiedAt' => $this->email_verified_at,
            'phone'           => $this->phone,
            'phoneVerifiedAt' => $this->phone_verified_at,
            'isEnabled'       => $this->is_enabled,
            'flags'           => $this->flags,
            'createdAt'       => $this->created_at->toDateTimeString(),
            'updatedAt'       => $this->updated_at->toDateTimeString(),
            'detail'          => [
                'firstName'  => $this->detail->first_name,
                'lastName'   => $this->detail->last_name,
                'fatherName' => $this->detail->father_name,
                'gender'     => $this->detail->gender,
                'birthdayAt' => $this->detail->birthday_at->toDateString(),
                'type'       => [
                    'id'    => $this->detail->type->id,
                    'title' => $this->detail->type->title,
                ],
                'companyId'  => $this->detail->company ? [
                    'id'    => $this->detail->company->id,
                    'title' => $this->detail->company->title,
                ] : null,
                'divisionId' => $this->detail->division ? [
                    'id'    => $this->detail->division->id,
                    'title' => $this->detail->division->title,
                ] : null,
                'positionId' => $this->detail->position ? [
                    'id'    => $this->detail->position->id,
                    'title' => $this->detail->position->title,
                ] : null,
            ],
        ];
    }
}
