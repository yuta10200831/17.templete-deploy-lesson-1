<?php
namespace App\Domain\Entity;

use App\Domain\ValueObject\Blog\BlogId;
use App\Domain\ValueObject\Blog\BlogTitle;
use App\Domain\ValueObject\Blog\BlogContents;
use App\Domain\ValueObject\User\UserId;
use App\Domain\ValueObject\JaDateTime;

final class Blog
{
    private BlogId $id;
    private UserId $userId;
    private BlogTitle $title;
    private BlogContents $contents;
    private JaDateTime $createdAt;

    /**
     * @param BlogId $id
     * @param UserId $userId
     * @param BlogTitle $title
     * @param BlogContents $contents
     * @param JaDateTime $createdAt
     */
    public function __construct(
        BlogId $id,
        UserId $userId,
        BlogTitle $title,
        BlogContents $contents,
        JaDateTime $createdAt
    ) {
        $this->id = $id;
        $this->userId = $userId;
        $this->title = $title;
        $this->contents = $contents;
        $this->createdAt = $createdAt;
    }

    /**
     * @return BlogId
     */
    public function id(): BlogId
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

    /**
     * @return JaDateTime
     */
    public function createdAt(): JaDateTime
    {
        return $this->createdAt;
    }

    /**
     * 記事の内容を更新する
     * @param BlogTitle
     * @param BlogContents
     * @return Blog
     */
    public function update(
        BlogTitle $title,
        BlogContents $contents
    ): Blog {
        return new self(
            $this->id,
            $this->userId,
            $title,
            $contents,
            $this->createdAt
        );
    }
}
