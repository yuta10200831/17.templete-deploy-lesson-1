<?php
namespace App\Adapter\Presenter;

use App\Adapter\ViewModel\EditViewModel;
use App\Usecase\UpdateBlog\UpdateBlogOutput;

final class EditPresenter
{
    private UpdateBlogOutput $output;

    public function __construct(UpdateBlogOutput $output)
    {
        $this->output = $output;
    }

    /**
     * ViewModelを返却
     * @return array
     */
    public function view(): array
    {
        $viewModel = new EditViewModel($this->output);
        return $viewModel->convertToWebView();
    }
}
