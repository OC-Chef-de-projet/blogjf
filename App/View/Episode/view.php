<div class="modal fade" id="modal-comment" tabindex="-1" role="dialog" aria-labelledby="modal-commentLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <!-- Modal Header -->
            <div class="modal-header chapter-head">
                <button type="button" class="close" data-dismiss="modal">
                    <span aria-hidden="true">&times;</span>
                    <span class="sr-only">Close</span>
                </button>
                <h4 class="modal-title" id="myModalLabel">
                    <span class="glyphicon glyphicon-comment"></span>&nbsp;Laisser un commentaire
                </h4>
            </div>
            <!-- Modal Body -->
            <div class="modal-body">
                <form class="form-horizontal" role="form" id="CommentForm">
                    <div class="form-group">
                        <label class="col-sm-2 control-label" for="inputName">Nom</label>
                        <div class="col-sm-10">
                            <input type="text" class="form-control required" id="inputName" placeholder="Votre nom" />
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-sm-2 control-label" for="inputEmail">Email</label>
                        <div class="col-sm-10">
                            <input type="email" class="form-control required" id="inputEmail" placeholder="Votre email" />
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-sm-2 control-label" for="inputComment">Commentaire</label>
                        <div class="col-sm-10">
                            <input type="hidden" value="" id="parent" name="parent">
                            <textarea class="form-control required" id="inputComment"></textarea>
                        </div>
                    </div>
                </form>
            </div>
            <!-- Modal Footer -->
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">
                    Annuler
                </button>
                <button type="button" class="btn btn-primary" id="CommentSubmit">
                    Envoyer
                </button>
            </div>
        </div>
    </div>
</div>
<section class="presentation" id="presentation">
    <div class="container">
        <h1>Billet simple pour<br/>l'Alaska</h1>
        <h2><a href="/blogjf/#biographie" data-toggle="tooltip" title="Biographie de l'auteur">Un livre de Jean Forteroche</a></h2>
        <hr>
        <div class="row episode">
            <div class="col-xs-12 col-sm-6 col-md-4 episode-head">
                <h2>
            <?php echo $episode->title ?>
            <a href="/blogjf/">
              <span class="pull-right glyphicon glyphicon-th-list" data-toggle="tooltip" title="Sommaire"></span>
            </a>
          </h2>
            </div>
            <div class="col-xs-12 episode-box">
                <?php echo $episode->content ?>
            </div>
        </div>
        <br>
        <!-- Commentaires -->
        <?php if(count($comments)){ ?>
        <div class="row episode-head">
            <div class="col-xs-12 col-sm-6">
                <h2 class="text-left">Commentaires</h2></div>
            <div class="col-xs-12 col-sm-6">
                <h2 class="text-right">
          <a href="#" data-toggle="modal" data-parent="0" title="N'hésitez pas à laisser un commentaire !" data-toggle="modal" data-target="#modal-comment">
          <span class="glyphicon glyphicon-comment" ></span>
            &nbsp;N'hésitez pas à laisser un commentaire !
          </a>
        </h2>
            </div>
        </div>
        <div class="row">
            <?php foreach($comments as $comment): ?>
            <?php require('comment.php'); ?>
            <?php endforeach; ?>
        </div>
        <?php } else { ?>
        <div class="row episode-head">
            <div class="col-xs-12">
                <h2 class="text-left">
        <a href="#" data-toggle="modal" data-parent="0" title="Soyez le premier à réagir !" data-toggle="modal" data-target="#modal-comment">
          <span class="glyphicon glyphicon-comment" ></span>
            &nbsp;Soyez le premier à réagir !
        </a>
      </h2>
            </div>
        </div>
        <?php } ?>
    </div>
</section>
<script type="text/javascript">
$(function() {
    $('#CommentSubmit').click(function(e) {
        e.preventDefault();
        var success = true;

        var data = $("#inputName");
        if (!data.val()) {
            data.closest('.form-group').removeClass('has-success').addClass('has-error');
            success = false;
        } else {
            data.closest('.form-group').removeClass('has-error').addClass('has-success');
        }

        data = $("#inputEmail");
        if (!data.val()) {
            data.closest('.form-group').removeClass('has-success').addClass('has-error');
            success = false;
        } else {
            if (!validateEmail(data.val())) {
                data.closest('.form-group').removeClass('has-success').addClass('has-error');
                success = false;
            } else {
                data.closest('.form-group').removeClass('has-error').addClass('has-success');
            }
        }

        data = $("#inputComment");
        if (!data.val()) {
            data.closest('.form-group').removeClass('has-success').addClass('has-error');
            success = false;
        } else {
            data.closest('.form-group').removeClass('has-error').addClass('has-success');
        }
        if (success) {
            addComment();
        }
    });

    $('.abuse').click(function(e) {
        var comment_id = $(e.currentTarget).data('id');
        setAbuse(comment_id);
        $(this).addClass('abuse-on');
    });
});

/*
 * Ajout de la valeur du parent
 */
$('#modal-comment').on('show.bs.modal', function(e) {
    var parent = $(e.relatedTarget).data('parent');
    $("#parent").val(parent);
});


function addComment() {
    $.ajax({
        url: '/blogjf/Commenter',
        type: 'POST',
        data: {
            ajax: true,
            episode_id: "<?php echo $episode->id?>",
            author: $("#inputName").val(),
            email: $("#inputEmail").val(),
            content: $("#inputComment").val(),
            parent_id: $("#parent").val()
        },
        success: function(json) {
            data = JSON.parse(json);
            $("#modal-comment").modal('hide');
            alert(data.message);
            location.reload();
        }
    });
}

function setAbuse(comment_id) {
    $.ajax({
        url: '/blogjf/CommentaireAbusif',
        type: 'POST',
        data: {
            ajax: true,
            comment_id: comment_id,
        },
        success: function(json) {
            data = JSON.parse(json);
            $("#modal-comment").modal('hide');
            alert(data.message);
            location.reload();
        }
    });
}

function validateEmail($email) {
    var emailReg = /^([\w-\.]+@([\w-]+\.)+[\w-]{2,4})?$/;
    return emailReg.test($email);
}
</script>
