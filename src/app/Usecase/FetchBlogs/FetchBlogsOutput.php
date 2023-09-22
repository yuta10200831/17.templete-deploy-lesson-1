<?php
namespace App\Usecase\FetchBlogs;

use App\Domain\Entity\Blog;

final class FetchBlogsOutput
{
    /** @var bool */
    private bool $isSuccess;
    /** @var string */
    private string $message;
    /** @var ArrayObject<Blog>|null */
    private ?array $blogs;

    /**
     * @param bool $isSuccess
     * @param string $message
     * @param ArrayObject<Blog>|null $blogs
     */
    public function __construct(
        bool $isSuccess,
        string $message,
        ?array $blogs = null
    ) {
        $this->isSuccess = $isSuccess;
        $this->message = $message;
        $this->blogs = $blogs;
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
     * @return ArrayObject<Blog>|null
     */
    public function blogs(): ?array
    {
        return $this->blogs;
    }
}
