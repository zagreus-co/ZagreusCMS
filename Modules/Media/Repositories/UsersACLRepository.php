<?php

namespace Modules\Media\Repositories;

use Alexusmai\LaravelFileManager\Services\ACLService\ACLRepository;

class UsersACLRepository implements ACLRepository
{
    /**
     * Get user ID
     *
     * @return mixed
     */
    public function getUserID()
    {
        return \Auth::id();
    }

    /**
     * Get ACL rules list for user
     *
     * @return array
     */
    public function getRules(): array
    {
        if (checkGate(['manage_media'])) {
            return [
                ['disk' => 'public_uploads', 'path' => '*', 'access' => 2],
                ['disk' => 'media', 'path' => '*', 'access' => 2],
            ];
        }

        return [
            ['disk' => 'media', 'path' => '*', 'access' => 0],
        ];
    }
}