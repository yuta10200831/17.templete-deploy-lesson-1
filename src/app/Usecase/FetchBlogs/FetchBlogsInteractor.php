<?php
namespace App\Usecase\FetchBlogs;

use App\Adapter\QueryService\BlogQueryService;
use App\Domain\Entity\Blog;
use App\Domain\ValueObject\Order;

final class FetchBlogsInteractor
{
    const EMPTY_MESSAGE = '記事が一件もありませんでした。';
    const COMPLETE_MESSAGE = '記事を取得しました。';

    /** @var FetchBlogsInput */
    private FetchBlogsInput $input;
    /** @var BlogQueryService */
    private BlogQueryService $blogQueryService;

    /**
     * @param FetchBlogsInput $input
     */
    public function __construct(FetchBlogsInput $input)
    {
        $this->input = $input;
        $this->blogQueryService = new BlogQueryService();
    }

    /**
     * インタラクタ実行
     * @return FetchBlogsOutput
     */
    public function handle(): FetchBlogsOutput
    {
        $blogs = $this->fetchBlogs();
        if (!$this->existsBlog($blogs)) {
            return new FetchBlogsOutput(false, self::EMPTY_MESSAGE);
        }

        return new FetchBlogsOutput(true, self::COMPLETE_MESSAGE, $blogs);
    }

    /**
     * 記事一覧の取得
     * @return ArrayObject<Blog>|null
     */
    private function fetchBlogs()
    {
        // 並び順に指定がない場合は降順を設定して取得を行う
        if ($this->input->keyword()->value() === '') {
            return $this->blogQueryService->fetchAllBlogs(
                $this->input->order() ?? new Order('desc')
            );
        }
        return $this->blogQueryService->searchBlogsByKeyword(
            $this->input->order() ?? new Order('desc'),
            $this->input->keyword()
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
