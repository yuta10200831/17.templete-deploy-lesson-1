<?php
namespace App\Adapter\Presenter;

use App\Adapter\ViewModel\HomeViewModel;
use App\Usecase\FetchBlogs\FetchBlogsOutput;

final class HomePresenter
{
    /** @var FetchBlogsOutput */
    private FetchBlogsOutput $output;

    /**
     * @param FetchBlogsOutput $output
     */
    public function __construct(FetchBlogsOutput $output)
    {
        $this->output = $output;
    }

    /**
     * ViewModelを返却
     * @return array{isSuccess: bool, message: string, blogs: array|null}
     */
    public function view(): array
    {
        $viewModel = new HomeViewModel($this->output);
        return $viewModel->convertToWebView();
    }
}
