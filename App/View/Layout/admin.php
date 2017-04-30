<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">
    <title>Administration Billet simple pour l'Alaska</title>
    <?= $this->Html()->js("jquery-3.2.0.min"); ?>
    <?= $this->Html()->css("bootstrap.min"); ?>
    <?= $this->Html()->css("blog"); ?>
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
                    <li class="active"><a href="/Admin">Home</a></li>
                    <li id="episode"><a href="/episode">Episodes</a></li>
                </ul>
                <ul class="nav navbar-nav navbar-right">
                    <li><a href="/Episode/add">Ajouter un episode</a></li>
                    <li><a href="/Logout">Deconnexion</a></li>
                </ul>
            </div>
        </div>
    </nav>
    <?= $contents ?>
    <link href="https://fonts.googleapis.com/css?family=Gloria+Hallelujah|Revalia" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css?family=Playfair+Display" rel="stylesheet">
    <?= $this->Html()->js("jquery.fadethis"); ?>
    <?= $this->Html()->js("bootstrap.min"); ?>
    <?= $this->Html()->js("tinymce.min"); ?>
    <script>
    tinymce.init({
        selector: 'textarea',
        height: 500,
        theme: 'modern',
        plugins: [
            'advlist autolink lists link image charmap print preview hr anchor pagebreak',
            'searchreplace wordcount visualblocks visualchars code fullscreen',
            'insertdatetime media nonbreaking save table contextmenu directionality',
            'emoticons template paste textcolor colorpicker textpattern imagetools codesample toc'
        ],
        toolbar1: 'undo redo | insert | styleselect | bold italic | alignleft aligncenter alignright alignjustify | bullist numlist outdent indent | link image',
        toolbar2: 'print preview media | forecolor backcolor emoticons | codesample',
        image_advtab: true,
        templates: [
            { title: 'Test template 1', content: 'Test 1' },
            { title: 'Test template 2', content: 'Test 2' }
        ],
        content_css: [
            '//fonts.googleapis.com/css?family=Lato:300,300i,400,400i',
            '//www.tinymce.com/css/codepen.min.css'
        ]
    });
    $(window).fadeThis();
    </script>
</body>

</html>
