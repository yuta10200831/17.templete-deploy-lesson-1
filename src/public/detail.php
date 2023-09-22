<?php
require_once '../vendor/autoload.php';

use App\Adapter\Presenter\DetailPresenter;
use App\Usecase\FindBlog\FindBlogInput;
use App\Usecase\FindBlog\FindBlogInteractor;
use App\Usecase\FetchBlogComments\FetchBlogCommentsInput;
use App\Usecase\FetchBlogComments\FetchBlogCommentsInteractor;
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
    $blogInput = new FindBlogInput($blogId);
    $commentInput = new FetchBlogCommentsInput($blogId);

    $blogUsecase = new FindBlogInteractor($blogInput);
    $commentUsecase = new FetchBlogCommentsInteractor($commentInput);

    $presenter = new DetailPresenter(
        $blogUsecase->handle(),
        $commentUsecase->handle()
    );
    $detailViewModel = $presenter->view();
    // 取得に失敗した場合は Not Found
    if (!$detailViewModel['isSuccess']) {
        $session->appendError($detailViewModel['message']);
        Response::redirect('error.php', 404);
    }
    $blog = $detailViewModel['blog'];
    $comments = $detailViewModel['comments'];
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
        <div class="blog__datetime"><?php echo $blog['createdAt']; ?></div>
        <div class="blog__field">
          <div class="blog__field__value">
            <?php echo $blog['contents']; ?>
          </div>
        </div>
        <div class="blog__actions">
          <a class="button" href="/">一覧ページへ</a>
        </div>
      </div>
    </article>
<?php if (!empty($comments)): ?>
    <aside class="comments">
      <h1 class="comments__heading">コメント一覧</h1>
      <ul class="comment-list">
  <?php foreach ($comments as $comment): ?>
        <li class="comment">
          <h2 class="comment__name">
            <?php echo $comment['commenterName']; ?>
          </h2>
          <div class="comment__datetime">
            <?php echo $comment['createdAt']; ?>
          </div>
          <div class="comment__body">
            <?php echo $comment['contents']; ?>
          </div>
        </li>
  <?php endforeach; ?>
      </ul>
    </aside>
<?php endif; ?>
  </div>
</body>
</html>