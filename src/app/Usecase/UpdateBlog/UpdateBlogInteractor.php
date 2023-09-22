<?php
namespace App\Usecase\UpdateBlog;

use App\Adapter\Repository\BlogRepository;
use App\Adapter\QueryService\BlogQueryService;
use App\Domain\ValueObject\User\UserId;
use App\Domain\Entity\Blog;
use App\Utils\Session;

final class UpdateBlogInteractor
{
    const BAD_REQUEST_MESSAGE = '不正な値が送信されました。';
    const COMPLETE_MESSAGE = '修正が完了しました。';

    /** @var UpdateBlogInput */
    private UpdateBlogInput $input;
    /** @var BlogQueryService */
    private BlogQueryService $blogQueryService;
    /** @var BlogRepository */
    private BlogRepository $blogRepository;

    /**
     * @param UpdateBlogInput $input
     */
    public function __construct(UpdateBlogInput $input)
    {
        $this->input = $input;
        $this->blogQueryService = new BlogQueryService();
        $this->blogRepository = new BlogRepository();
    }

    /**
     * インタラクタ実行
     * @return UpdateBlogOutput
     */
    public function handle(): UpdateBlogOutput
    {
        $session = Session::getInstance();
        $user = $session->getUser();
        $userId = new UserId($user['id']);
        $blog = $this->findBlog();
        // ユーザーIDと一致しない記事情報を修正リクエストが飛んできた場合は不正とする
        if (
            is_null($blog) ||
            $blog->userId()->value() !== $userId->value()
        ) {
            return new UpdateBlogOutput(false, self::BAD_REQUEST_MESSAGE);
        }

        // エンティティの内容を修正してUpdate
        $updatedBlog = $blog->update(
            $this->input->title(),
            $this->input->contents()
        );
        $this->update($updatedBlog);
        return new UpdateBlogOutput(true, self::COMPLETE_MESSAGE);
    }

    /**
     * 記事修正
     * @param Blog $blog
     */
    private function update(Blog $blog): void
    {
        $this->blogRepository->update($blog);
    }

    /**
     * 記事の取得
     * @return Blog|null
     */
    private function findBlog(): ?Blog
    {
        return $this->blogQueryService->findById($this->input->id());
    }
}
