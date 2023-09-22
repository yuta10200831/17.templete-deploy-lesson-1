<?php
namespace App\Adapter\Presenter;

use App\Adapter\ViewModel\PostCreateViewModel;
use App\Usecase\CreateBlog\CreateBlogOutput;

final class PostCreatePresenter
{
    private CreateBlogOutput $output;

    public function __construct(CreateBlogOutput $output)
    {
        $this->output = $output;
    }

    /**
     * ViewModelを返却
     * @return array
     */
    public function view(): array
    {
        $viewModel = new PostCreateViewModel($this->output);
        return $viewModel->convertToWebView();
    }
}
