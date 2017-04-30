<div id="summary_<?= $last->id?>">
    <div class="row episode">
        <div class="col-xs-4 episode-head">
            <h2><?= $last->title ?></h2>
        </div>
        <div class="col-xs-12 box">
            <?= $last->content ?>
        </div>
    </div>
    <div class="row">
        <div class="col-xs-6">
            <?php if($navEpisode['previous']): ?>
            <h2 class="text-left">
				<span class="glyphicon glyphicon-backward"></span>
					<a href="#" id="prev">
						<?= $navEpisode['previous']->title ?>
					</a>
			</h2>
            <?php endif; ?>
        </div>
        <div class="col-xs-6">
            <?php if($navEpisode['next']): ?>
            <h2 class="text-left">
				<a href="#" id="next"">
					<?= $navEpisode['next']->title ?>
					<span class="glyphicon glyphicon-forward"></span>
				</a>
			</h2>
            <?php endif;?>
        </div>
    </div>
</div>
<script type="text/javascript">
$('#next').click(function() {
    alert("next");
});

$('#prev').click(function() {
    $.ajax({
        url: '/episode/navEpisode',
        type: 'POST',
        data: {
            ajax: true,
            id: "<?= $navEpisode['previous']->id ?>",
        },
        success: function(json) {
        }
    });
});

</script>
