<?php
namespace App\Adapter\Presenter;

use App\Adapter\ViewModel\MyBlogDetailViewModel;
use App\Usecase\FindBlog\FindBlogOutput;

final class MyBlogDetailPresenter
{
    /** @var FindBlogOutput */
    private FindBlogOutput $output;

    /**
     * @param FetchBlogsOutput $output
     */
    public function __construct(FindBlogOutput $output)
    {
        $this->output = $output;
    }

    /**
     * ViewModelを返却
     * @return array{isSuccess: bool, message: string, blogs: array|null}
     */
    public function view(): array
    {
        $viewModel = new MyBlogDetailViewModel($this->output);
        return $viewModel->convertToWebView();
    }
}
