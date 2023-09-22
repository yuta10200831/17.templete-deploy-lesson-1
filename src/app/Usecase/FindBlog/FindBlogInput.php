<?php
namespace App\Usecase\FindBlog;

use App\Domain\ValueObject\Blog\BlogId;

final class FindBlogInput
{
    /** @var BlogId|null */
    private ?BlogId $id;

    /**
     * @param BlogId|null $id
     */
    public function __construct(?BlogId $id)
    {
        $this->id = $id;
    }

    /**
     * @return BlogId|null
     */
    public function id(): ?BlogId
    {
        return $this->id;
    }
}
