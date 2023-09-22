<?php
namespace App\Adapter\QueryService;

use App\Infrastructure\Dao\BlogSqlDao;
use App\Domain\Entity\Blog;
use App\Domain\ValueObject\Blog\BlogId;
use App\Domain\ValueObject\Blog\BlogTitle;
use App\Domain\ValueObject\Blog\BlogContents;
use App\Domain\ValueObject\Blog\BlogKeyword;
use App\Domain\ValueObject\User\UserId;
use App\Domain\ValueObject\JaDateTime;
use App\Domain\ValueObject\Order;

final class BlogQueryService
{
    /** @var BlogSqlDao */
    private BlogSqlDao $blogDao;

    public function __construct()
    {
        $this->blogDao = new BlogSqlDao();
    }

    /**
     * 記事の一覧を取得する
     * @param Order $order
     * @return ArrayObject<Blog>|null
     */
    public function fetchAllBlogs(Order $order): ?array
    {
        $blogsMapper = $this->blogDao->fetchAllBlogs($order);
        return $this->existsPost($blogsMapper)
            ? $this->getBlogEntities($blogsMapper)
            : null;
    }

    /**
     * ユーザーID別に記事一覧を取得する
     * @param UserId $userId
     * @return ArrayObject<Blog>|null
     */
    public function fetchBlogsByUserId(UserId $userId): ?array
    {
        $blogsMapper = $this->blogDao->fetchBlogsByUserId($userId);
        return $this->existsPost($blogsMapper)
            ? $this->getBlogEntities($blogsMapper)
            : null;
    }

    /**
     * 記事検索
     * @param Order $order
     * @param BlogKeyword $keyword
     * @return ArrayObject<Blog>|null
     */
    public function searchBlogsByKeyword(
        Order $order,
        BlogKeyword $keyword
    ): ?array {
        $blogsMapper = $this->blogDao->searchBlogsByKeyword(
            $order,
            $keyword
        );
        return $this->existsPost($blogsMapper)
            ? $this->getBlogEntities($blogsMapper)
            : null;
    }

    /**
     * 記事検索
     * @param BlogId $id
     * @return Blog|null
     */
    public function findById(BlogId $id): ?Blog
    {
        $blogMapper = $this->blogDao->findById($id);
        return $this->existsPost($blogMapper)
            ? new Blog(
                new BlogId($blogMapper['id']),
                new UserId($blogMapper['user_id']),
                new BlogTitle($blogMapper['title']),
                new BlogContents($blogMapper['contents']),
                new JaDateTime($blogMapper['created_at'])
            )
            : null;
    }

    /**
     * BlogEntityの配列を生成
     * @param array
     * @return ArrayObject<Blog>
     */
    private function getBlogEntities(array $blogsMapper): array
    {
        $output = [];
        foreach ($blogsMapper as $blog) {
            $output[] = new Blog(
                new BlogId($blog['id']),
                new UserId($blog['user_id']),
                new BlogTitle($blog['title']),
                new BlogContents($blog['contents']),
                new JaDateTime($blog['created_at'])
            );
        }
        return $output;
    }

    /**
     * 記事の存在チェック
     * @param array|null $mapper
     * @return bool
     */
    private function existsPost(?array $mapper): bool
    {
        return !is_null($mapper);
    }
}
