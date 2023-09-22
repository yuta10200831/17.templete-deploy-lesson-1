<?php
require_once '../vendor/autoload.php';

use App\Adapter\Presenter\EditPresenter;
use App\Usecase\UpdateBlog\UpdateBlogInput;
use App\Usecase\UpdateBlog\UpdateBlogInteractor;
use App\Domain\ValueObject\Blog\BlogId;
use App\Domain\ValueObject\Blog\BlogTitle;
use App\Domain\ValueObject\Blog\BlogContents;
use App\Utils\Session;
use App\Utils\Response;
use App\Utils\Validator;

// GETでのアクセス防止
if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    Response::redirect('./edit.php');
}

$id = Validator::sanitize(filter_input(INPUT_POST, 'id') ?? null);
$title = Validator::sanitize(filter_input(INPUT_POST, 'title') ?? '');
$contents = Validator::sanitize(filter_input(INPUT_POST, 'contents') ?? '');

try {
    $session = Session::getInstance();
    $user = $session->getUser();

    if (empty($title)) {
        throw new Exception('タイトルを入力してください。');
    }
    if ($id === '' || is_null($id)) {
        throw new Exception('テスト：不正な値が送信されました。');
    }

    $blogId = new BlogId($id);
    $blogTitle = new BlogTitle($title);
    $blogContents = new BlogContents($contents);
    $input = new UpdateBlogInput(
        $blogId,
        $blogTitle,
        $blogContents
    );

    $usecase = new UpdateBlogInteractor($input);
    $presenter = new EditPresenter($usecase->handle());
    $result = $presenter->view();

    if (!$result['isSuccess']) {
        throw new Exception($result['message']);
    }

    $session->appendMessage($result['message']);
    Response::redirect('./myBlogDetail.php?id=' . $blogId->value());
} catch (Exception $e) {
    $formData = compact('title', 'contents');
    $session->setFormInputs($formData);
    $session->appendError($e->getMessage());

    Response::redirect('./edit.php?id=' . $id);
}
