<?php
namespace App\Adapter\ViewModel;

use App\Domain\Entity\Blog;
use App\Domain\Entity\Comment;
use App\Usecase\FindBlog\FindBlogOutput;
use App\Usecase\FetchBlogComments\FetchBlogCommentsOutput;

final class DetailViewModel
{
    /** @var FindBlogOutput */
    private FindBlogOutput $blogOutput;
    /** @var FetchBlogCommentsOutput */
    private FetchBlogCommentsOutput $commentOutput;

    /**
     * @param FindBlogOutput $output
     */
    public function __construct(
        FindBlogOutput $blogOutput,
        FetchBlogCommentsOutput $commentOutput
    ) {
        $this->blogOutput = $blogOutput;
        $this->commentOutput = $commentOutput;
    }

    /**
     * Web用ViewModelを返却
     * @return array{isSuccess: bool, message: string, blogs: array|null}
     */
    public function convertToWebView(): array
    {
        return [
            'isSuccess' => $this->blogOutput->isSuccess(),
            'message' => $this->blogOutput->message(),
            'blog' => $this->createBlogForWebView(
                $this->blogOutput->blog()
            ),
            'comments' => $this->createCommentsForWebView(
                $this->commentOutput->comments()
            ),
        ];
    }

    /**
     * view用のBlogを生成
     * @param Blog|null
     * @return {id, int, title: string, contents: string }|null
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

    /**
     * view用のCommentリストを生成
     * @param ArrayObject<Comment>|null $comments
     * @return ArrayObject<{id: int, commenterName: string, contents: string, createdAt: createdAt }>|null
     */
    private function createCommentsForWebView($comments): ?array
    {
        if (is_null($comments)) {
            return null;
        }
        $output = [];
        foreach ($comments as $comment) {
            $output[] = [
                'id' => $comment->id()->value(),
                'commenterName' => $comment->commenterName()->value(),
                'contents' => $comment->contents()->value(),
                'createdAt' => $comment->createdAt()->value(),
            ];
        }
        return $output;
    }
}
