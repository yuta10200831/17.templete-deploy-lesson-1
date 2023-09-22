<?php
namespace App\Usecase\FetchBlogComments;

use App\Adapter\QueryService\CommentQueryService;
use App\Domain\Entity\Blog;

final class FetchBlogCommentsInteractor
{
    const EMPTY_MESSAGE = '記事が一件もありませんでした。';
    const COMPLETE_MESSAGE = '記事を取得しました。';

    /** @var FetchBlogCommentsInput */
    private FetchBlogCommentsInput $input;
    /** @var CommentQueryService */
    private CommentQueryService $commentQueryService;

    /**
     * @param FetchBlogCommentsInput $input
     */
    public function __construct(FetchBlogCommentsInput $input)
    {
        $this->input = $input;
        $this->commentQueryService = new CommentQueryService();
    }

    /**
     * インタラクタ実行
     * @return FetchBlogCommentsOutput
     */
    public function handle(): FetchBlogCommentsOutput
    {
        $comments = $this->fetchComments();
        if (!$this->existsComment($comments)) {
            return new FetchBlogCommentsOutput(false, self::EMPTY_MESSAGE);
        }

        return new FetchBlogCommentsOutput(
            true,
            self::COMPLETE_MESSAGE,
            $comments
        );
    }

    /**
     * 記事一覧の取得
     * @return ArrayObject<Blog>|null
     */
    private function fetchComments()
    {
        return $this->commentQueryService->fetchCommentsByBlogId(
            $this->input->blogId()
        );
    }

    /**
     * 記事の存在チェック
     * @param ArrayObject<Blog>|null $blogs
     * @return bool
     */
    private function existsComment(?array $comments)
    {
        return !is_null($comments);
    }
}
