<?php

namespace App\Helpers;

use App\Models\User;

class Utilities
{
    /**
     * Check if User is Owner of Workspace
     *
     * @param User|string|null $userId
     * @param string|null $workspaceId
     * @return bool
     */
    public static function isUserOwnerWorkspace(User|string|null $userId, string|null $workspaceId)
    {
        if (blank($userId) || blank($workspaceId))
            return false;

        $userId = self::GetUserId($userId);

        $workspace = \App\Models\Workspace::where('id', $workspaceId)->where('user_id', $userId)->exists();

        return $workspace;
    }

    /**
     * Check if User is Joined to Workspace
     *
     * @param User|string|null $userId
     * @param string|null $workspaceId
     * @return mixed
     */
    public static function isUserJoinedToWorkspace(User|string|null $userId, string|null $workspaceId)
    {
        $workspace = self::isUserOwnerWorkspace($userId, $workspaceId);

        if ($workspace) return $workspace;

        if (blank($userId) || blank($workspaceId))
            return false;

        $userId = self::GetUserId($userId);
        $workspace = \App\Models\Workspace::where('id', $workspaceId)->whereRelation('users', 'id', $userId)->exists();

        return $workspace;
    }

    /**
     * Get User Id
     *
     * @param User|string|null $userId
     * @return string|null
     */
    private static function GetUserId(User|string|null $userId)
    {
        if ($userId instanceof User)
            $userId = $userId->getAttribute('id');

        return $userId;
    }
}
