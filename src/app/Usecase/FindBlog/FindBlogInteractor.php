<?php
namespace App\Usecase\FindBlog;

use App\Adapter\QueryService\BlogQueryService;
use App\Domain\Entity\Blog;

final class FindBlogInteractor
{
    const NOT_FOUND_MESSAGE = '対象の記事は見つかりませんでした。';
    const COMPLETE_MESSAGE = '記事を取得しました。';

    /** @var FindBlogInput */
    private FindBlogInput $input;
    /** @var BlogQueryService */
    private BlogQueryService $blogQueryService;

    /**
     * @param FindBlogInput $input
     */
    public function __construct(FindBlogInput $input)
    {
        $this->input = $input;
        $this->blogQueryService = new BlogQueryService();
    }

    /**
     * インタラクタ実行
     * @return FindBlogOutput
     */
    public function handle(): FindBlogOutput
    {
        // idに指定がない場合はfalse判定
        if (is_null($this->input->id())) {
            return new FindBlogOutput(false, self::NOT_FOUND_MESSAGE);
        }
        $blog = $this->findBlog();
        if (!$this->existsBlog($blog)) {
            return new FindBlogOutput(false, self::NOT_FOUND_MESSAGE);
        }

        return new FindBlogOutput(true, self::COMPLETE_MESSAGE, $blog);
    }

    /**
     * 記事の取得
     * @return Blog|null
     */
    private function findBlog(): ?Blog
    {
        return $this->blogQueryService->findById($this->input->id());
    }

    /**
     * 記事の存在チェック
     * @param Blog|null $blogs
     * @return bool
     */
    private function existsBlog(?Blog $blogs)
    {
        return !is_null($blogs);
    }
}
