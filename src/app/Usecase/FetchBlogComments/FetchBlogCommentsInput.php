<?php
namespace App\Usecase\FetchBlogComments;

use App\Domain\ValueObject\Blog\BlogId;

final class FetchBlogCommentsInput
{
    /** @var BlogId */
    private BlogId $blogId;

    /**
     * @param BlogId
     */
    public function __construct(BlogId $blogId)
    {
        $this->blogId = $blogId;
    }

    /**
     * @return BlogId
     */
    public function blogId(): BlogId
    {
        return $this->blogId;
    }
}
