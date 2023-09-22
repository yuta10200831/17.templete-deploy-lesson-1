<?php
namespace App\Domain\Entity;

use App\Domain\ValueObject\User\UserId;
use App\Domain\ValueObject\Blog\BlogId;
use App\Domain\ValueObject\Comment\CommentId;
use App\Domain\ValueObject\Comment\CommenterName;
use App\Domain\ValueObject\Comment\CommentContents;
use App\Domain\ValueObject\JaDateTime;

final class Comment
{
    /** @var CommentId */
    private CommentId $id;
    /** @var UserId */
    private UserId $userId;
    /** @var BlogId */
    private BlogId $blogId;
    /** @var CommenterName */
    private CommenterName $commenterName;
    /** @var CommentContents */
    private CommentContents $contents;
    /** @var JaDateTime */
    private JaDateTime $createdAt;

    /**
     * @param CommentId $id
     * @param UserId $userId
     * @param BlogId $blogId
     * @param CommenterName $commenterName
     * @param CommentContents $contents
     * @param JaDateTime $createdAt
     */
    public function __construct(
        CommentId $id,
        UserId $userId,
        BlogId $blogId,
        CommenterName $commenterName,
        CommentContents $contents,
        JaDateTime $createdAt
    ) {
        $this->id = $id;
        $this->userId = $userId;
        $this->blogId = $blogId;
        $this->commenterName = $commenterName;
        $this->contents = $contents;
        $this->createdAt = $createdAt;
    }

    /**
     * @return CommentId
     */
    public function id(): CommentId
    {
        return $this->id;
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

    /**
     * @return JaDateTime
     */
    public function createdAt(): JaDateTime
    {
        return $this->createdAt;
    }
}
