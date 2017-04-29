<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">
    <title>Billet simple pour l'Alaska</title>
    <?= $this->Html->js("jquery-3.2.0.min"); ?>
    <?= $this->Html->css("bootstrap.min"); ?>
    <?= $this->Html->css("blog"); ?>
</head>

<body>
    <?= $contents ?>
    <link href="https://fonts.googleapis.com/css?family=Gloria+Hallelujah|Revalia" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css?family=Playfair+Display" rel="stylesheet">
    <?= $this->Html->js("jquery.fadethis"); ?>
    <?= $this->Html->js("bootstrap.min"); ?>
    <?= $this->Html->js("tinymce.min"); ?>
    <script>
    tinymce.init({
        selector: ".tiny",
        themes: "modern"
    });
    </script>
    <script>
    $(window).fadeThis();
    </script>
</body>

</html>
