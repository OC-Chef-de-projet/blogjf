<!--
	Première page
-->
<section class="presentation" id="presentation">
    <div class="container-fluid">
        <div class="row">
            <div class="col-xs-12">
                <h1>Billet simple pour<br/>l'Alaska</h1>
                <h2><a href="/blogjf/Biographie" data-toggle="tooltip" title="Biographie de l'auteur">Un livre de Jean Forteroche</a></h2>
            </div>
        </div>

        <div class="col-xs-12 col-sm-4 col-md-3 sidebar-offcanvas" id="sidebar" role="navigation">
            <!-- 5 derniers épisodes -->
            <div class="row">
                <!-- Entete avec navigation Précédent/suivant -->
                <div class="col-xs-2 episode-head">
                    <h2>
						<a href="#" id="nextEpisode">
							<span class="glyphicon glyphicon-forward gly-rotate-270"></span>
						</a>
					</h2>
                </div>
                <div class="col-xs-8 episode-head">
                    <h2 class="text-center">Les épisodes</h2>
                </div>
                <div class="col-xs-2 episode-head">
                    <h2>
						<a href="#" id="prevEpisode">
							<span class="glyphicon glyphicon-forward gly-rotate-90"></span>
						</a>
					</h2>
                </div>
            </div>
            <div class="row">
                <div class="col-xs-12 episode-nav">
                    <div id="navChap">
                        <?php foreach($episodes['episodes'] as $episode) { ?>
                        <div>
                            <h2 class="text-left">
								<a href="/blogjf/Episode/<?= $episode->id ?>-<?= $episode->url ?>">
									<?= $episode->title ?>
								</a>
							</h2>
                        </div>
                        <?php } ?>
                    </div>
                </div>
            </div>
            <p></p>
            <div class="row">
                <div class="col-xs-12 episode-head">
                    <h2 class="text-center">Nouveaux lecteurs</h2>
                </div>
            </div>
            <div class="row">
                <div class="col-xs-12 episode-nav">
                    <div id="navChap">
                        <div>
                            <h2 class="text-left">
								<a href="/blogjf/projet">Découvrir le projet</a>
							</h2>
                        </div>
                        <div>
                            <h2 class="text-left">
								<a href="/blogjf/biographie">Qui est Jean Forteroche ?</a>
							</h2>
                        </div>
                        <div>
                            <h2 class="text-left">
								<a href="/blogjf/Episode/<?= $first->id ?>-<?= $first->url ?>">Commencer le roman</a>
							</h2>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-xs-12 col-sm-7 col-sm-offset-1 col-md-8 col-sm-offset-1">
            <div class="row episode">
                <div class="col-xs-12 col-sm-8 col-md-4 episode-head">
                    <h2><?= $summary->title ?></h2>
                </div>
                <div class="col-xs-12 episode-box episode-summary">
                    <?= $summary->content ?>
                </div>
                <div class="col-xs-4 col-sm-9 col-md-10 episode-box-fill">&nbsp;</div>
                <div class="col-xs-8 col-sm-3 col-md-2 text-right episode-suite">
                    <a href="/blogjf/Episode/<?= $summary->id ?>-<?= $summary->url ?>">Lire la suite</a>
                </div>
            </div>
            <div class="row episode-nav">
                <div class="col-xs-6">
                    <?php if($navEpisode['previous']): ?>
                    <h2 class="text-left episode-nav">
							<a href="/blogjf/resume/<?= $navEpisode['previous']->id ?>">
							<span class="glyphicon glyphicon-backward"></span>
								<?= $navEpisode['previous']->title ?>
							</a>
					</h2>
                    <?php endif; ?>
                </div>
                <div class="col-xs-6">
                    <?php if($navEpisode['next']): ?>
                    <h2 class="text-right episode-nav">
						<a href="/blogjf/resume/<?= $navEpisode['next']->id ?>">
							<?= $navEpisode['next']->title ?>
							<span class="glyphicon glyphicon-forward"></span>
						</a>
					</h2>
                    <?php endif;?>
                </div>
            </div>
        </div>
    </div>
</section>
<script type="text/javascript">
var offset = 0;


$(document).ready(function() {
    $("#nextEpisode").addClass('inactive');
});

$("#prevEpisode").click(function() {
    if ($(this).hasClass('inactive')) {
        // Don't it's inactive
    } else {
        scrollEpisode('prev');
    }
});

$("#nextEpisode").click(function() {
    if ($(this).hasClass('inactive')) {
        // Don't it's inactive
    } else {
        scrollEpisode('next');
    }
});

function scrollEpisode(direction) {
    $.ajax({
        url: '/blogjf/episode/getEpisodesTitle',
        type: 'POST',
        data: {
            ajax: true,
            offset: offset,
            direction: direction
        },
        success: function(json) {
            data = JSON.parse(json);
            updateScrollEpisode(data);
        }
    });
}




function updateScrollEpisode(data) {


    if (data.isLast == 1) {
        $("#nextEpisode").addClass('inactive');
    } else {
        $("#nextEpisode").removeClass('inactive');
        offset = data.offset;
    }

    if (data.isFirst == 1) {
        $("#prevEpisode").addClass('inactive')
    } else {
        $("#prevEpisode").removeClass('inactive');
        offset = data.offset;
    }

    var html = "";
    for (var i = 0; i < data.episodes.length; i++) {
        html += "<h2 class='navChap'>";
        html += "<a href=\"/blogjf/Episode/view/" + data.episodes[i].id + "\">";
        html += data.episodes[i].title;
        html + "</a>";
        html += "</h2>";
    }
    if (html) {
        $("#navEpisode").html("");
        $("#navEpisode").html(html);
    }
}
</script>
