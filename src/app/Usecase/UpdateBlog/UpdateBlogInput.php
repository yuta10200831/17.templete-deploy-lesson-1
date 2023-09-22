<?php
namespace App\Usecase\UpdateBlog;

use App\Domain\ValueObject\Blog\BlogId;
use App\Domain\ValueObject\Blog\BlogTitle;
use App\Domain\ValueObject\Blog\BlogContents;

final class UpdateBlogInput
{
    /** @var BlogId */
    private BlogId $id;
    /** @var BlogTitle */
    private BlogTitle $title;
    /** @var BlogContents */
    private BlogContents $contents;

    /**
     * @param BlogId $id
     * @param BlogTitle $title
     * @param BlogContents $contents
     */
    public function __construct(
        BlogId $id,
        BlogTitle $title,
        BlogContents $contents
    ) {
        $this->id = $id;
        $this->title = $title;
        $this->contents = $contents;
    }

    /**
     * @return BlogId
     */
    public function id(): BlogId
    {
        return $this->id;
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
