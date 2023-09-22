<?php
namespace App\Usecase\UpdateBlog;

final class UpdateBlogOutput
{
    /** @var bool */
    private bool $isSuccess;
    /** @var string */
    private string $message;

    /**
     * @param bool $isSuccess
     * @param string $message
     */
    public function __construct(bool $isSuccess, string $message)
    {
        $this->isSuccess = $isSuccess;
        $this->message = $message;
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
}
