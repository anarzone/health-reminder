<?php

namespace App\Services;

use App\Http\Resources\UserResource;
use App\Models\Reminder;
use App\Models\User;

class UserService
{
    public function __construct(private User $userModel, private Reminder $reminderModel){}

    public function getDetails(): array
    {
        return [
            'profile' => new UserResource(auth()->user()),
            'reminders_daily' => [
                'active' => $this->reminderModel->where('status',$this->reminderModel::STATUS_ACTIVE)
                    ->whereRaw('DATE(created_at) = CURDATE()')->count(),
                'done' => $this->reminderModel->where('status',$this->reminderModel::STATUS_DONE)
                    ->whereRaw('DATE(created_at) = CURDATE()')->count(),
                'missed' => $this->reminderModel->where('status',$this->reminderModel::STATUS_MISSED)
                    ->whereRaw('DATE(created_at) = CURDATE()')->count(),
            ]
        ];
    }

    public function store($data): UserResource
    {
        $user = $this->userModel->updateOrCreate(['id' => auth()->user()->id ?? null], $data);

        return new UserResource($user);
    }
}
