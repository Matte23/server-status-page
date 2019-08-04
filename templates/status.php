<!DOCTYPE html>
<html lang="<?php echo $lang ?>">
<head>
    <title><?php echo TRANSLATION['server-status']; ?> - <?php echo $config[Constants::SERVER_NAME]; ?></title>

    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <?php
        if ($require_full_bootstrap) {
            echo "
                <link rel=\"stylesheet\" href=\"https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css\" integrity=\"sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T\" crossorigin=\"anonymous\">
                <script src=\"https://code.jquery.com/jquery-3.3.1.slim.min.js\" integrity=\"sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo\" crossorigin=\"anonymous\"></script>
                <script src=\"https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js\" integrity=\"sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM\" crossorigin=\"anonymous\"></script>
            ";
        } else {
            echo "<link rel=\"stylesheet\" href=\"css/bootstrap.minimal.css\">";
        }
    ?>
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
