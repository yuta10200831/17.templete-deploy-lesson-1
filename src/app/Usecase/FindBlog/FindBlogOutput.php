<?php
namespace App\Usecase\FindBlog;

use App\Domain\Entity\Blog;

final class FindBlogOutput
{
    /** @var bool */
    private bool $isSuccess;
    /** @var string */
    private string $message;
    /** @var Blog|null */
    private ?Blog $blog;

    /**
     * @param bool $isSuccess
     * @param string $message
     * @param Blog|null $blog
     */
    public function __construct(
        bool $isSuccess,
        string $message,
        ?Blog $blog = null
    ) {
        $this->isSuccess = $isSuccess;
        $this->message = $message;
        $this->blog = $blog;
    }

    /**
     * @return bool
     */
    public function isSuccess(): bool
    {
        return $this->isSuccess;
    }

    /**
     * @return string
     */
    public function message(): string
    {
        return $this->message;
    }

    /**
     * @return Blog|null
     */
    public function blog(): ?Blog
    {
        return $this->blog;
    }
}
