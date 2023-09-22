<?php
namespace App\Adapter\Presenter;

use App\Adapter\ViewModel\MypageViewModel;
use App\Usecase\FetchUserBlogs\FetchUserBlogsOutput;

final class MypagePresenter
{
    /** @var FetchUserBlogsOutput */
    private FetchUserBlogsOutput $output;

    /**
     * @param FetchUserBlogsOutput $output
     */
    public function __construct(FetchUserBlogsOutput $output)
    {
        $this->output = $output;
    }

    /**
     * ViewModelを返却
     * @return array{isSuccess: bool, message: string, blogs: array|null}
     */
    public function view(): array
    {
        $viewModel = new MypageViewModel($this->output);
        return $viewModel->convertToWebView();
    }
}
