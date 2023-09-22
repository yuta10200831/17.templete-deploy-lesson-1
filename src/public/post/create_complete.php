<?php
require_once '../../vendor/autoload.php';

use App\Adapter\Presenter\PostCreatePresenter;
use App\Usecase\CreateBlog\CreateBlogInput;
use App\Usecase\CreateBlog\CreateBlogInteractor;
use App\Domain\ValueObject\Blog\BlogTitle;
use App\Domain\ValueObject\Blog\BlogContents;
use App\Utils\Session;
use App\Utils\Response;
use App\Utils\Validator;

// GETでのアクセス防止
if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    Response::redirect('./create.php');
}

$title = Validator::sanitize(filter_input(INPUT_POST, 'title') ?? '');
$contents = Validator::sanitize(filter_input(INPUT_POST, 'contents') ?? '');

try {
    $session = Session::getInstance();
    $user = $session->getUser();

    if (empty($title)) {
        throw new Exception('タイトルを入力してください。');
    }

    $blogTitle = new BlogTitle($title);
    $blogContents = new BlogContents($contents);
    $input = new CreateBlogInput($blogTitle, $blogContents);

    $usecase = new CreateBlogInteractor($input);
    $presenter = new PostCreatePresenter($usecase->handle());
    $result = $presenter->view();

    if (!$result['isSuccess']) {
        throw new Exception($result['message']);
    }

    $session->appendMessage($result['message']);
    Response::redirect('../mypage.php');
} catch (Exception $e) {
    $formData = compact('title', 'contents');
    $session->setFormInputs($formData);
    $session->appendError($e->getMessage());

    Response::redirect('./create.php');
}
