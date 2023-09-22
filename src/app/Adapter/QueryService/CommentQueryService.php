<?php
namespace App\Adapter\QueryService;

use App\Infrastructure\Dao\CommentSqlDao;
use App\Domain\Entity\Blog;
use App\Domain\Entity\Comment;
use App\Domain\ValueObject\Comment\CommentId;
use App\Domain\ValueObject\Comment\CommenterName;
use App\Domain\ValueObject\Comment\CommentContents;
use App\Domain\ValueObject\Blog\BlogId;
use App\Domain\ValueObject\User\UserId;
use App\Domain\ValueObject\JaDateTime;

final class CommentQueryService
{
    /** @var CommentSqlDao */
    private CommentSqlDao $commentDao;

    public function __construct()
    {
        $this->commentDao = new CommentSqlDao();
    }

    /**
     * ユーザーID別に記事一覧を取得する
     * @param BlogId $blogId
     * @return ArrayObject<Blog>|null
     */
    public function fetchCommentsByBlogId(BlogId $blogId): ?array
    {
        $commentsMapper = $this->commentDao->fetchCommentsByBlogId(
            $blogId
        );
        return $this->existsComment($commentsMapper)
            ? $this->getCommentEntities($commentsMapper)
            : null;
    }

    /**
     * BlogEntityの配列を生成
     * @param array
     * @return ArrayObject<Blog>
     */
    private function getCommentEntities(array $commentsMapper): array
    {
        $output = [];
        foreach ($commentsMapper as $comment) {
            $output[] = new Comment(
                new CommentId($comment['id']),
                new UserId($comment['user_id']),
                new BlogId($comment['blog_id']),
                new CommenterName($comment['commenter_name']),
                new CommentContents($comment['comments']),
                new JaDateTime($comment['created_at'])
            );
        }
        return $output;
    }

    /**
     * 記事の存在チェック
     * @param array|null $mapper
     * @return bool
     */
    private function existsComment(?array $mapper): bool
    {
        return !is_null($mapper);
    }
}
