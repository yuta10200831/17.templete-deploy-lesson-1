<?php
namespace App\Infrastructure\Dao;

use PDO;
use App\Domain\ValueObject\Comment\NewComment;
use App\Domain\ValueObject\Blog\BlogId;

final class CommentSqlDao extends SqlDao
{
    const TABLE_NAME = 'comments';

    /**
     * 新規コメント作成
     * @param NewComment $comment
     */
    public function create(NewComment $comment): void
    {
        $sql = sprintf(
            'INSERT INTO %s (user_id, blog_id, commenter_name, comments) VALUES (:userId, :blogId, :commenterName, :comments)',
            self::TABLE_NAME
        );
        $userId = $comment->userId();
        $blogId = $comment->blogId();
        $commenterName = $comment->commenterName();
        $comments = $comment->contents();

        $statement = $this->pdo->prepare($sql);
        $statement->bindParam(':userId', $userId->value(), PDO::PARAM_STR);
        $statement->bindParam(
            ':blogId',
            $blogId->value(),
            PDO::PARAM_STR
        );
        $statement->bindParam(
            ':commenterName',
            $commenterName->value(),
            PDO::PARAM_STR
        );
        $statement->bindParam(':comments', $comments->value(), PDO::PARAM_STR);
        $statement->execute();
    }

    /**
     * 記事の一覧取得
     * @param BlogId $blogId
     * @return array|null
     */
    public function fetchCommentsByBlogId(BlogId $blogId): ?array
    {
        $sql = sprintf(
            'SELECT * FROM %s WHERE blog_id=:blogId ORDER BY created_at desc;',
            self::TABLE_NAME
        );
        $statement = $this->pdo->prepare($sql);
        $statement->bindParam(
            ':blogId',
            $blogId->value(),
            PDO::PARAM_STR
        );
        $statement->execute();
        $Comments = $statement->fetchAll();
        return $Comments ? $Comments : null;
    }
}
