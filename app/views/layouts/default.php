<!doctype html>
<html lang="en">
  <head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="<?= PROOT ?>css/bootstrap.min.css" media="screen" charset="utf-8" >
    <link rel="stylesheet" href="<?= PROOT ?>css/custom.css" media="screen" charset="utf-8" >
    <script src="<?= PROOT ?>js/bootstrap.min.js"></script>
    <script src="<?= PROOT ?>js/jQuery-2.2.4.min.js"></script>

    <?= $this->content("head") ?>

    <title><?= $this->siteTitle() ?></title>
  </head>
  <body>

  <?= $this->content('body') ?>

  </body>
</html>
