<?php
namespace App\Domain\ValueObject\Blog;

use App\Domain\ValueObject\User\UserId;

final class NewBlog
{
    private UserId $userId;
    private BlogTitle $title;
    private BlogContents $contents;

    public function __construct(
        UserId $userId,
        BlogTitle $title,
        BlogContents $contents
    ) {
        $this->userId = $userId;
        $this->title = $title;
        $this->contents = $contents;
    }

    /**
     * @return UserId
     */
    public function userId(): UserId
    {
        return $this->userId;
    }

    /**
     * @return BlogTitle
     */
    public function title(): BlogTitle
    {
        return $this->title;
    }

    /**
     * @return BlogContents
     */
    public function contents(): BlogContents
    {
        return $this->contents;
    }
}
