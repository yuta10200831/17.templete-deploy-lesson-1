<?php
namespace App\Usecase\CreateBlog;

use App\Adapter\Repository\BlogRepository;
use App\Domain\ValueObject\Blog\NewBlog;
use App\Domain\ValueObject\User\UserId;
use App\Utils\Session;

final class CreateBlogInteractor
{
    const COMPLETE_MESSAGE = '登録が完了しました。';

    private CreateBlogInput $input;
    private BlogRepository $blogRepository;

    public function __construct(CreateBlogInput $input)
    {
        $this->input = $input;
        $this->blogRepository = new BlogRepository();
    }

    /**
     * インタラクタ実行
     * @return CreateBlogOutput
     */
    public function handle(): CreateBlogOutput
    {
        $session = Session::getInstance();
        $user = $session->getUser();
        $userId = new UserId($user['id']);
        $this->create($userId);
        return new CreateBlogOutput(true, self::COMPLETE_MESSAGE);
    }

    /**
     * 新規記事作成
     * @param UserId $userId
     */
    private function create(UserId $userId): void
    {
        $this->blogRepository->create(
            new NewBlog(
                $userId,
                $this->input->title(),
                $this->input->contents()
            )
        );
    }
}
