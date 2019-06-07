<?php

use Framework\Registry;

/* @var $content string */

$homePath = Registry::getRoute('index');
$loginPath = Registry::getRoute('login');
$logoutPath = Registry::getRoute('logout');
$security = Registry::getService('user.security');

?>
<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css"
          integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
    <title>Tasks</title>
</head>
<body>
<div class="container">
    <div class="row">
        <nav class="nav">
            <a class="nav-link" href="<?= $homePath ?>">Home</a>
            <?php if ($security->isLogged()): ?>
                <a class="nav-link" href="<?= $logoutPath ?>">Logout(<?= $security->getUser()->getUsername() ?>)</a>
            <?php else: ?>
                <a class="nav-link" href="<?= $loginPath ?>">Login</a>
            <?php endif; ?>
        </nav>
    </div>
    <?= $content ?>
</div>
</body>
</html>





