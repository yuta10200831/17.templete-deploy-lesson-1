<?php
namespace App\Adapter\Presenter;

use App\Adapter\ViewModel\DetailViewModel;
use App\Usecase\FindBlog\FindBlogOutput;
use App\Usecase\FetchBlogComments\FetchBlogCommentsOutput;

final class DetailPresenter
{
    /** @var FindBlogOutput */
    private FindBlogOutput $blogOutput;
    /** @var FetchBlogCommentsOutput */
    private FetchBlogCommentsOutput $commentOutput;

    /**
     * @param FindBlogOutput $blogOutput
     * @param FetchBlogCommentsOutput $commentOutput
     */
    public function __construct(
        FindBlogOutput $blogOutput,
        FetchBlogCommentsOutput $commentOutput
    ) {
        $this->blogOutput = $blogOutput;
        $this->commentOutput = $commentOutput;
    }

    /**
     * ViewModelを返却
     * @return array{isSuccess: bool, message: string, blogs: array|null}
     */
    public function view(): array
    {
        $viewModel = new DetailViewModel(
            $this->blogOutput,
            $this->commentOutput
        );
        return $viewModel->convertToWebView();
    }
}
