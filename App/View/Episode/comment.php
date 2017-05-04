<?php $col = 'col-xs-'.(12 - $comment->depth) ?>
<?php $off = 'col-xs-offset-'.$comment->depth ?>
<?php
$abuse = '';
if($comment->abuse){
	$abuse = 'abuse-on';
}

$highlight = '';
if($focus == $comment->id){
	$highlight = 'focus';
	$abuse = '';
}
?>
    <div class="<?= $col.' '.$off ?> comment-box" id="cmt-<?= $comment->id ?>">
        <div class="row comment-head">
            <div class="col-xs-6 comment-name">
                <?= htmlspecialchars($comment->author) ?>
            </div>
            <div class="col-xs-4 comment-date">
                <?= $comment->created ?>
            </div>
            <div class="col-xs-2 comment-action">
                <?php if(!$comment->abuse): ?>
                <a class="abuse" data-id="<?= $comment->id?>">
                    <span class="glyphicon glyphicon-ban-circle" title="Signaler un abus"></span>
                </a>
                <?php endif; ?>
                <?php if($comment->depth < $maxDepth): ?>
                <a href="#">
				<span class="glyphicon glyphicon-comment" data-toggle="modal" data-parent="<?= $comment->id?>" title="Laissez un commentaire" data-toggle="modal" data-target="#modal-comment"></span>
			</a>
                <?php endif; ?>
            </div>
        </div>
        <div class="comment-text <?= $abuse.' '.$highlight ?>">
            <?= htmlspecialchars($comment->content) ?>
        </div>
    </div>
    <?php if(isset($comment->children)): ?>
    <?php foreach($comment->children as $comment): ?>
    <?php require('comment.php'); ?>
    <?php endforeach; ?>
    <?php endif; ?>
