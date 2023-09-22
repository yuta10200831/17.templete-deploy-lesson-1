<?php
namespace App\Adapter\Repository;

use App\Infrastructure\Dao\BlogSqlDao;
use App\Domain\ValueObject\Blog\NewBlog;
use App\Domain\Entity\Blog;

final class BlogRepository
{
    private BlogSqlDao $blogDao;

    public function __construct()
    {
        $this->blogDao = new BlogSqlDao();
    }

    /**
     * 新規記事の作成
     * @param NewBlog $blog
     */
    public function create(NewBlog $blog): void
    {
        $this->blogDao->create($blog);
    }

    /**
     * 記事の修正
     * @param Blog $blog
     */
    public function update(Blog $blog): void
    {
        $this->blogDao->update($blog);
    }
}
