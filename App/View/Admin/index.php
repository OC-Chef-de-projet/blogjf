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
                        <a href="/episode/view/<?= $abuse->episode_id ?>/<?= $abuse->id ?>/#cmt-<?= $abuse->id ?>">
                            <?= $abuse->id ?>
                        </a>
                    </td>
                    <td>
                        <?= $abuse->author.' &lt;'.$abuse->email.'&gt;' ?>
                    </td>
                    <td>
                        <?= $abuse->content ?>
                    </td>
                    <td>
                        <?= $abuse->created ?>
                    </td>
                    <td>
                        <a href="#" class="approve" data-id="<?= $abuse->id ?>">
                            <span class="glyphicon glyphicon-ok"></span>
                        </a>
                        <a href="#" class="delete" data-id="<?= $abuse->id ?>">
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
                        <a href="/episode/view/<?= $comment->episode_id ?>/<?= $comment->id ?>/#cmt-<?= $comment->id ?>">
                            <?= $comment->id ?>
                        </a>
                    </td>
                    <td>
                        <?= $comment->author.' &lt;'.$comment->email.'&gt;' ?>
                    </td>
                    <td>
                        <?= $comment->content ?>
                    </td>
                    <td>
                        <?= $comment->created ?>
                    </td>
                    <td>
                        <a href="#" class="delete" data-id="<?= $comment->id ?>">
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
        url: '/approveComment',
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
        url: '/removeComment',
        type: 'POST',
        data: {
            ajax: true,
            comment_id: comment_id,
        },
        success: function(json) {
            data = JSON.parse(json);
            location.reload();
        }
    });
}
</script>
