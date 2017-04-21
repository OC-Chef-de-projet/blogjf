<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">
    <title>Billet simple pour l'Alaska</title>
    <?php echo $this->Html->js("jquery-3.2.0.min"); ?>
    <?php echo $this->Html->css("bootstrap.min"); ?>
    <?php echo $this->Html->css("blog"); ?>
</head>

<body>
    <?php echo $contents ?>
    <link href="https://fonts.googleapis.com/css?family=Gloria+Hallelujah|Revalia" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css?family=Playfair+Display" rel="stylesheet">
    <?php echo $this->Html->js("jquery.fadethis"); ?>
    <?php echo $this->Html->js("bootstrap.min"); ?>
    <?php echo $this->Html->js("tinymce.min"); ?>
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
