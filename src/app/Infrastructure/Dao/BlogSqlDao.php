<?php
namespace App\Infrastructure\Dao;

use PDO;
use App\Domain\ValueObject\Blog\NewBlog;
use App\Domain\ValueObject\Blog\BlogId;
use App\Domain\ValueObject\Blog\BlogKeyword;
use App\Domain\Entity\Blog;
use App\Domain\ValueObject\Order;
use App\Domain\ValueObject\User\UserId;

final class BlogSqlDao extends SqlDao
{
    const TABLE_NAME = 'blogs';

    /**
     * 新規記事作成
     * @param NewBlog $blog
     */
    public function create(NewBlog $blog): void
    {
        $sql = sprintf(
            'INSERT INTO %s (user_id, title, contents) VALUES (:userId, :title, :contents)',
            self::TABLE_NAME
        );
        $userId = $blog->userId();
        $title = $blog->title();
        $contents = $blog->contents();

        $statement = $this->pdo->prepare($sql);
        $statement->bindParam(':userId', $userId->value(), PDO::PARAM_STR);
        $statement->bindParam(':title', $title->value(), PDO::PARAM_STR);
        $statement->bindParam(':contents', $contents->value(), PDO::PARAM_STR);
        $statement->execute();
    }

    /**
     * 記事修正
     * @param Blog $blog
     */
    public function update(Blog $blog): void
    {
        $sql = sprintf(
            'UPDATE %s SET title=:title, contents=:contents WHERE id=:id;',
            self::TABLE_NAME
        );
        $id = $blog->id();
        $title = $blog->title();
        $contents = $blog->contents();

        $statement = $this->pdo->prepare($sql);
        $statement->bindParam(':id', $id->value(), PDO::PARAM_STR);
        $statement->bindParam(':title', $title->value(), PDO::PARAM_STR);
        $statement->bindParam(':contents', $contents->value(), PDO::PARAM_STR);
        $statement->execute();
    }

    /**
     * 記事の一覧取得
     * @param Order $order
     * @return array|null
     */
    public function fetchAllBlogs(Order $order): ?array
    {
        $sql = sprintf(
            'SELECT * FROM %s ORDER BY created_at %s;',
            self::TABLE_NAME,
            $order->value()
        );
        $statement = $this->pdo->prepare($sql);
        $statement->execute();
        $blogs = $statement->fetchAll();
        return $blogs ? $blogs : null;
    }

    /**
     * 記事の一覧取得
     * @param UserId $userId
     * @return array|null
     */
    public function fetchBlogsByUserId(UserId $userId): ?array
    {
        $sql = sprintf(
            'SELECT * FROM %s WHERE user_id=:userId ORDER BY created_at desc;',
            self::TABLE_NAME
        );
        $statement = $this->pdo->prepare($sql);
        $statement->bindParam(':userId', $userId->value(), PDO::PARAM_STR);
        $statement->execute();
        $blogs = $statement->fetchAll();
        return $blogs ? $blogs : null;
    }

    /**
     * 記事検索
     * @param Order $order
     * @param BlogKeyword $keyword
     * @return array|null
     */
    public function searchBlogsByKeyword(
        Order $order,
        BlogKeyword $keyword
    ): ?array {
        $sql = sprintf(
            'SELECT * FROM %s WHERE (title LIKE :keyword OR contents LIKE :keyword) ORDER BY created_at %s;',
            self::TABLE_NAME,
            $order->value()
        );
        $statement = $this->pdo->prepare($sql);
        $statement->bindValue(
            ':keyword',
            '%' . $keyword->value() . '%',
            PDO::PARAM_STR
        );
        $statement->execute();
        $blogs = $statement->fetchAll();
        return $blogs ? $blogs : null;
    }

    /**
     * 記事取得 (ID)
     * @param BlogId $id
     * @return array|null
     */
    public function findById(BlogId $id)
    {
        $sql = sprintf('SELECT * FROM %s WHERE id=:id', self::TABLE_NAME);
        $statement = $this->pdo->prepare($sql);
        $statement->bindParam(':id', $id->value(), PDO::PARAM_STR);
        $statement->execute();
        $blog = $statement->fetch();
        return $blog ? $blog : null;
    }
}
