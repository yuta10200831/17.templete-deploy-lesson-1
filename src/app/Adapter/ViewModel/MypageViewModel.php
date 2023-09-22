<?php
namespace App\Adapter\ViewModel;

use App\Domain\Entity\Blog;
use App\Usecase\FetchUserBlogs\FetchUserBlogsOutput;

final class MypageViewModel
{
    private FetchUserBlogsOutput $output;

    public function __construct(FetchUserBlogsOutput $output)
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
            'blogs' => $this->createBlogsForWebView(
                $this->output->blogs()
            ),
        ];
    }

    /**
     * view用のBlogを生成
     * @param ArrayObject<Blog>|null
     * @return array{id, int, title: string, contents: string }|null
     */
    private function createBlogsForWebView($blogs): ?array
    {
        if (is_null($blogs)) {
            return null;
        }
        $output = [];
        foreach ($blogs as $blog) {
            $output[] = [
                'id' => $blog->id()->value(),
                'title' => $blog->title()->value(),
                'contents' => $this->omitContens($blog->contents()->value()),
                'createdAt' => $blog->createdAt()->value(),
            ];
        }
        return $output;
    }

    /**
     * 記事コンテンツを省略形に変換
     * @param string
     * @return string
     */
    private function omitContens(string $contents): string
    {
        return mb_strimwidth($contents, 0, 15, '…', 'UTF-8');
    }
}
