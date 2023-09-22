<?php
namespace App\Usecase\CreateBlog;

use App\Domain\ValueObject\Blog\BlogTitle;
use App\Domain\ValueObject\Blog\BlogContents;

final class CreateBlogInput
{
    private BlogTitle $title;
    private BlogContents $contents;

    public function __construct(BlogTitle $title, BlogContents $contents)
    {
        $this->title = $title;
        $this->contents = $contents;
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
