<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">
    <title>Administration Billet simple pour l'Alaska</title>
    <?php echo $this->Html->js("jquery-3.2.0.min"); ?>
    <?php echo $this->Html->css("bootstrap.min"); ?>
    <?php echo $this->Html->css("blog"); ?>
</head>

<body>
    <nav class="navbar navbar-default">
        <div class="container-fluid">
            <div class="navbar-header">
                <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#navbar" aria-expanded="false" aria-controls="navbar">
                    <span class="sr-only">Toggle navigation</span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                </button>
                <a class="navbar-brand" href="#">Billet simple pour l'Alaska</a>
            </div>
            <div id="navbar" class="navbar-collapse collapse">
                <ul class="nav navbar-nav">
                    <li class="active"><a href="/blogjf/Admin">Home</a></li>
                    <li id="episode"><a href="/blogjf/episode">Episodes</a></li>
                </ul>
                <ul class="nav navbar-nav navbar-right">
                    <li><a href="/blogjf/Episode/add">Ajouter un episode</a></li>
                    <li><a href="/blogjf/Logout">Deconnexion</a></li>
                </ul>
            </div>
        </div>
    </nav>
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
