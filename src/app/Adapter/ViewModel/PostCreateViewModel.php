<?php
namespace App\Adapter\ViewModel;

use App\Usecase\CreateBlog\CreateBlogOutput;

final class PostCreateViewModel
{
    private CreateBlogOutput $output;

    public function __construct(CreateBlogOutput $output)
    {
        $this->output = $output;
    }

    /**
     * Web用ViewModelを返却
     * @return array
     */
    public function convertToWebView(): array
    {
        return [
            'isSuccess' => $this->output->isSuccess(),
            'message' => $this->output->message(),
        ];
    }
}
