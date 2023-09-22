<?php
namespace App\Adapter\ViewModel;

use App\Domain\Entity\Blog;
use App\Usecase\FindBlog\FindBlogOutput;

final class MyBlogDetailViewModel
{
    /** @var FindBlogOutput */
    private FindBlogOutput $output;

    /**
     * @param FindBlogOutput $output
     */
    public function __construct(FindBlogOutput $output)
    {
        $this->output = $output;
    }

    /**
     * Web用ViewModelを返却
     * @return array{isSuccess: bool, message: string, blogs: array|null}
     */
    public function convertToWebView(): array
    {
        return [
            'isSuccess' => $this->output->isSuccess(),
            'message' => $this->output->message(),
            'blog' => $this->createBlogForWebView(
                $this->output->blog()
            ),
        ];
    }

    /**
     * view用のBlogを生成
     * @param Blog|null
     * @return {id: int, title: string, contents: string, createdAt: string }|null
     */
    private function createBlogForWebView($blog): ?array
    {
        if (is_null($blog)) {
            return null;
        }
        return [
            'id' => $blog->id()->value(),
            'title' => $blog->title()->value(),
            'contents' => $blog->contents()->value(),
            'createdAt' => $blog->createdAt()->value(),
        ];
    }
}
