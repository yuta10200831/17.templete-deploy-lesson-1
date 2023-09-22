<?php
namespace App\Usecase\FetchUserBlogs;

use App\Domain\ValueObject\User\UserId;

final class FetchUserBlogsInput
{
    /** @var UserId */
    private UserId $userId;

    /**
     * @param UserId
     */
    public function __construct(UserId $userId)
    {
        $this->userId = $userId;
    }

    /**
     * @return UserId
     */
    public function userId(): UserId
    {
        return $this->userId;
    }
}
