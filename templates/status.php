<!DOCTYPE html>
<html lang="<?php echo $lang ?>">
<head>
    <title><?php echo TRANSLATION['server-status']; ?> - <?php echo $config[Constants::SERVER_NAME]; ?></title>

    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <link rel="stylesheet" href="css/bootstrap.minimal.css">
    <link rel="stylesheet" href="css/custom.css">
</head>

<body>
<div id="header" class="jumbotron text-center text-white">
    <h1><?php echo $config[Constants::SERVER_NAME]; ?></h1>
    <p><?php echo TRANSLATION['server-status']; ?></p>
</div>
<div class="container">
    <?php $tester->generate_summary_card() ?>
    <?php $custom->get_cards() ?>
    <hr/>
    <?php $tester->generate_cards() ?>
</div>
</body>
</html>