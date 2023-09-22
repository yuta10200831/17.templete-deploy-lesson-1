<?php
require_once '../vendor/autoload.php';

use App\Adapter\Presenter\MypagePresenter;
use App\Usecase\FetchUserBlogs\FetchUserBlogsInput;
use App\Usecase\FetchUserBlogs\FetchUserBlogsInteractor;
use App\Domain\ValueObject\User\UserId;
use App\Utils\Response;
use App\Utils\Session;

$session = Session::getInstance();
$messages = $session->popMessages();
$errors = $session->popErrors();
$user = $session->getUser();
if (is_null($user)) {
    Response::redirect('./user/signin.php');
}

try {
    $userId = new UserId($user['id']);
    $input = new FetchUserBlogsInput($userId);

    $usecase = new FetchUserBlogsInteractor($input);
    $presenter = new MypagePresenter($usecase->handle());
    $mypageViewModel = $presenter->view();
} catch (Exception $e) {
    $errors[] = $e->getMessage();
}
?><!doctype html>
<html>
<head>
<meta charset="UTF-8"> 
<meta http-equiv="content-language" content="ja"> 
<meta name="description" content="会員登録"> 
<title>マイページ</title>
<link rel="stylesheet" href="/assets/css/style.css">
</head>
<body>
<?php require_once './includes/header.php'; ?>
  <div class="container container--left">
    <h1>マイページ</h1>
<?php foreach ($errors as $e): ?>
    <div class="error"><?php echo $e; ?></div>
<?php endforeach; ?>
    <div class="entries">
<?php if (
    $mypageViewModel['isSuccess'] &&
    !empty($mypageViewModel['blogs'])
): ?>
      <ul class="entry-list">
  <?php foreach ($mypageViewModel['blogs'] as $blog): ?>
        <li class="entry">
          <div class="entry__header">
            <h2 class="entry__title"><?php echo $blog['title']; ?></h2>
            <div class="entry__datetime">
              <?php echo $blog['createdAt']; ?>
            </div>
          </div>
          <div class="entry__body">
            <?php echo $blog['contents']; ?>
          </div>
          <div class="entry__footer">
            <a class="entry__button" href="/myBlogDetail.php?id=<?php echo $blog[
                'id'
            ]; ?>">記事詳細へ</a>
          </div>
        </li>
  <?php endforeach; ?>
      </ul>
<?php else: ?>
      <p><?php echo $mypageViewModel['message']; ?></p>
<?php endif; ?>
    </div>
  </div>
</body>
</html>