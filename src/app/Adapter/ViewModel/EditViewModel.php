<?php
namespace App\Adapter\ViewModel;

use App\Usecase\UpdateBlog\UpdateBlogOutput;

final class EditViewModel
{
    private UpdateBlogOutput $output;

    public function __construct(UpdateBlogOutput $output)
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
