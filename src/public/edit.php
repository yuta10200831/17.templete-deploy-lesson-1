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
    <blog class="blog">
<?php foreach ($errors as $e): ?>
      <div class="error"><?php echo $e; ?></div>
<?php endforeach; ?>
      <form method="post" action="/edit_complete.php">
        <input type="hidden" name="id" value="<?php echo $id; ?>">
        <div class="blog__body">
          <div class="blog__field">
            <div class="blog__field__name">タイトル</div>
            <div class="blog__field__value">
              <input class="offstyle-input" name="title" maxlength="255" value="<?php echo $blog[
                  'title'
              ]; ?>">
            </div>
          </div>
          <div class="blog__field">
            <div class="blog__field__name">内容</div>
            <div class="blog__field__value">
              <textarea class="offstyle-input" name="contents" maxlength="255"><?php echo $blog[
                  'contents'
              ]; ?></textarea>
            </div>
          </div>
          <div class="blog__actions">
            <button class="button">編集</button>
          </div>
        </div>
      </form>
    </blog>
  </div>
</body>
</html>