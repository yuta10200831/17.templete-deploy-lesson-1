<?php
namespace App\Usecase\FetchUserBlogs;

use App\Adapter\QueryService\BlogQueryService;
use App\Domain\Entity\Blog;

final class FetchUserBlogsInteractor
{
    const EMPTY_MESSAGE = '記事が一件もありませんでした。';
    const COMPLETE_MESSAGE = '記事を取得しました。';

    /** @var FetchUserBlogsInput */
    private FetchUserBlogsInput $input;
    /** @var BlogQueryService */
    private BlogQueryService $blogQueryService;

    /**
     * @param FetchUserBlogsInput $input
     */
    public function __construct(FetchUserBlogsInput $input)
    {
        $this->input = $input;
        $this->blogQueryService = new BlogQueryService();
    }

    /**
     * インタラクタ実行
     * @return FetchUserBlogsOutput
     */
    public function handle(): FetchUserBlogsOutput
    {
        $blogs = $this->fetchBlogs();
        if (!$this->existsBlog($blogs)) {
            return new FetchUserBlogsOutput(false, self::EMPTY_MESSAGE);
        }

        return new FetchUserBlogsOutput(
            true,
            self::COMPLETE_MESSAGE,
            $blogs
        );
    }

    /**
     * 記事一覧の取得
     * @return ArrayObject<Blog>|null
     */
    private function fetchBlogs()
    {
        return $this->blogQueryService->fetchBlogsByUserId(
            $this->input->userId()
        );
    }

    /**
     * 記事の存在チェック
     * @param ArrayObject<Blog>|null $blogs
     * @return bool
     */
    private function existsBlog(?array $blogs)
    {
        return !is_null($blogs);
    }
}
