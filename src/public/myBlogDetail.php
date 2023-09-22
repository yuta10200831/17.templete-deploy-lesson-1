<?php
require_once '../vendor/autoload.php';

use App\Adapter\Presenter\MyBlogDetailPresenter;
use App\Usecase\FindBlog\FindBlogInput;
use App\Usecase\FindBlog\FindBlogInteractor;
use App\Domain\ValueObject\Blog\BlogId;
use App\Utils\Response;
use App\Utils\Session;

$session = Session::getInstance();
$messages = $session->popMessages();
$errors = $session->popErrors();
$user = $session->getUser();
if (is_null($user)) {
    Response::redirect('./user/signin.php');
}
$id = filter_input(INPUT_GET, 'id') ?? null;

try {
    $blogId = is_null($id) ? null : new BlogId(intval($id));
    $input = new FindBlogInput($blogId);

    $usecase = new FindBlogInteractor($input);
    $presenter = new MyBlogDetailPresenter($usecase->handle());
    $myBlogViewModel = $presenter->view();
    // 取得に失敗した場合は Not Found
    if (!$myBlogViewModel['isSuccess']) {
        $session->appendError($myBlogViewModel['message']);
        Response::redirect('error.php', 404);
    }
    $blog = $myBlogViewModel['blog'];
} catch (Exception $e) {
    $errors[] = $e->getMessage();
}
?><!doctype html>
<html>
<head>
<meta charset="UTF-8"> 
<meta http-equiv="content-language" content="ja"> 
<meta name="description" content="会員登録"> 
<title>記事詳細ページ : マイページ</title>
<link rel="stylesheet" href="/assets/css/style.css">
</head>
<body>
<?php require_once './includes/header.php'; ?>
  <div class="container">
    <article class="blog">
      <h1 class="blog__heading"><?php echo $blog['title']; ?></h1>
<?php foreach ($messages as $m): ?>
      <div class="success"><?php echo $m; ?></div>
<?php endforeach; ?>
      <div class="blog__body">
        <div class="blog__datetime"><?php echo $blog[
            'createdAt'
        ]; ?></div>
        <div class="blog__field">
          <div class="blog__field__value">
            <?php echo $blog['contents']; ?>
          </div>
        </div>
        <div class="blog__actions">
          <a class="button" href="/edit.php?id=<?php echo $blog[
              'id'
          ]; ?>">編集</a>
          <a class="button" href="/mypage.php">マイページへ</a>
        </div>
      </div>
    </article>
  </div>
</body>
</html>