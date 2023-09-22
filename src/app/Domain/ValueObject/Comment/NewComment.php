<?php
namespace App\Domain\ValueObject\Comment;

use App\Domain\ValueObject\User\UserId;
use App\Domain\ValueObject\Blog\BlogId;

final class NewComment
{
    /** @var UserId */
    private UserId $userId;
    /** @var BlogId */
    private BlogId $blogId;
    /** @var CommenterName */
    private CommenterName $commenterName;
    /** @var CommentContents */
    private CommentContents $contents;

    /**
     * @param UserId $userId
     * @param BlogId $blogId
     * @param CommenterName $commenterName
     * @param CommentContents $contents
     */
    public function __construct(
        UserId $userId,
        BlogId $blogId,
        CommenterName $commenterName,
        CommentContents $contents
    ) {
        $this->userId = $userId;
        $this->blogId = $blogId;
        $this->commenterName = $commenterName;
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
     * @return BlogId
     */
    public function blogId(): BlogId
    {
        return $this->blogId;
    }

    /**
     * @return CommenterName
     */
    public function commenterName(): CommenterName
    {
        return $this->commenterName;
    }

    /**
     * @return CommentContents
     */
    public function contents(): CommentContents
    {
        return $this->contents;
    }
}
