<style>
h2 {
    color: black !important;
}
</style>
<div class="container">
    <div class="jumbotron">
        <h2 class="text-left">Commnentaires signalés comme abusif</h2>
        <table class="table">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Commentaire de</th>
                    <th>Contenu</th>
                    <th>Date</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach($abuses as $abuse): ?>
                <tr>
                    <td>
                        <a href="/blogjf/episode/view/<?php echo $abuse->episode_id ?>/<?php echo $abuse->id ?>/#cmt-<?php echo $abuse->id ?>">
                            <?php echo $abuse->id ?>
                        </a>
                    </td>
                    <td>
                        <?php echo $abuse->author.' &lt;'.$abuse->email.'&gt;' ?>
                    </td>
                    <td>
                        <?php echo $abuse->content ?>
                    </td>
                    <td>
                        <?php echo $abuse->created ?>
                    </td>
                    <td>
                        <a href="#" class="approve" data-id="<?php echo $abuse->id ?>">
                            <span class="glyphicon glyphicon-ok"></span>
                        </a>
                        <a href="#" class="delete" data-id="<?php echo $abuse->id ?>">
                            <span class="glyphicon glyphicon-trash"></span>
                        </a>
                    </td>
                </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
    <div class="jumbotron">
        <h2 class="text-left">Commnentaires</h2>
        <table class="table">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Commentaire de</th>
                    <th>Contenu</th>
                    <th>Date</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach($comments as $comment): ?>
                <tr>
                    <td>
                        <a href="/blogjf/episode/view/<?php echo $comment->episode_id ?>/<?php echo $comment->id ?>/#cmt-<?php echo $comment->id ?>">
                            <?php echo $comment->id ?>
                        </a>
                    </td>
                    <td>
                        <?php echo $comment->author.' &lt;'.$comment->email.'&gt;' ?>
                    </td>
                    <td>
                        <?php echo $comment->content ?>
                    </td>
                    <td>
                        <?php echo $comment->created ?>
                    </td>
                    <td>
                        <a href="#" class="delete" data-id="<?php echo $comment->id ?>">
                            <span class="glyphicon glyphicon-trash"></span>
                        </a>
                    </td>
                </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
</div>
<script type="text/javascript">
$(function() {

    $('.approve').click(function(e) {
        var comment_id = $(e.currentTarget).data('id');
        approve(comment_id);
    });

    $('.delete').click(function(e) {
        var comment_id = $(e.currentTarget).data('id');
        remove(comment_id);
    });
});


function approve(comment_id) {
    $.ajax({
        url: '/blogjf/approveComment',
        type: 'POST',
        data: {
            ajax: true,
            comment_id: comment_id,
        },
        success: function(json) {
            data = JSON.parse(json);
            //alert(data.message);
            location.reload();
        }
    });
}

function remove(comment_id) {
    $.ajax({
        url: '/blogjf/removeComment',
        type: 'POST',
        data: {
            ajax: true,
            comment_id: comment_id,
        },
        success: function(json) {
            data = JSON.parse(json);
            //alert(data.message);
            location.reload();
        }
    });
}
</script>
