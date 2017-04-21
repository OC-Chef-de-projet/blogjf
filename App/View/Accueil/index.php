<!--
	Première page
-->
<section class="presentation" id="presentation">
    <div class="container-fluid">
        <!-- Titre du blog et nom de l'auteur -->
        <div class="row">
            <div class="col-xs-12">
                <h1>Billet simple pour<br/>l'Alaska</h1>
                <h2><a href="/blogjf/Biographie" data-toggle="tooltip" title="Biographie de l'auteur">Un livre de Jean Forteroche</a></h2>
            </div>
        </div>
        <!-- sidebar -->
        <div class="col-xs-12 col-sm-3 sidebar-offcanvas" id="sidebar" role="navigation">
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
            <!-- Fin entete episode -->
            <div class="row">
                <!-- Titre des episode -->
                <div class="col-xs-12 episode-nav">
                    <div id="navChap">
                        <?php foreach($episodes['episodes'] as $episode) { ?>
                        <div>
                            <h2 class="text-left">
								<a href="/blogjf/Episode/<?php echo $episode->id ?>-<?php echo $episode->url ?>">
									<?php echo $episode->title ?>
								</a>
							</h2>
                        </div>
                        <?php } ?>
                    </div>
                </div>
            </div>
            <!-- 5 derniers episodes -->
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
								<a href="#projet">Découvrir le projet</a>
							</h2>
                        </div>
                        <div>
                            <h2 class="text-left">
								<a href="#biographie">Qui est Jean Forteroche ?</a>
							</h2>
                        </div>
                        <div>
                            <h2 class="text-left">
								<a href="/blogjf/Episode/<?php echo $first->id ?>-<?php echo $first->url ?>">Commencer le roman</a>
							</h2>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!--/sidebar-->
        <!-- Résumé dernier episode -->
        <div class="col-xs-12 col-sm-8 col-sm-offset-1">
            <div class="row episode">
                <div class="col-xs-12 col-sm-8 col-md-4 episode-head">
                    <h2><?php echo $summary->title ?></h2>
                </div>
                <div class="col-xs-12 episode-box">
                    <?php echo $summary->content ?>
                </div>
                <div class="col-xs-4 col-sm-9 col-md-10 episode-box-fill">&nbsp;</div>
                <div class="col-xs-8 col-sm-3 col-md-2 text-right episode-suite">
                    <a href="/blogjf/Episode/<?php echo $summary->id ?>-<?php echo $summary->url ?>">Lire la suite</a>
                </div>
            </div>
            <div class="row episode-nav">
                <div class="col-xs-6">
                    <?php if($navEpisode['previous']): ?>
                    <h2 class="text-left episode-nav">
							<a href="/blogjf/resume/<?php echo $navEpisode['previous']->id ?>">
							<span class="glyphicon glyphicon-backward"></span>
								<?php echo $navEpisode['previous']->title ?>
							</a>
					</h2>
                    <?php endif; ?>
                </div>
                <div class="col-xs-6">
                    <?php if($navEpisode['next']): ?>
                    <h2 class="text-right episode-nav">
						<a href="/blogjf/resume/<?php echo $navEpisode['next']->id ?>">
							<?php echo $navEpisode['next']->title ?>
							<span class="glyphicon glyphicon-forward"></span>
						</a>
					</h2>
                    <?php endif;?>
                </div>
            </div>
        </div>
    </div>
</section>
<!--
	
<section class="biographie" id="biographie">
	<div class="container">
		<div class="row" style="margin-top:15px">
			<div class="card-reverse col-xs-3">
				<div class="chapter-head">
					<h2>Jean Forteroche</h2>
				</div>
				<div class="box">
					<p>Jean Forteroche, né le 20 avril 1998 à Paris 14e, est un écrivain français, connu également sous les pseudonymes de Shorinji Kempo, Lautréamont et Carelman.</p>

				</div>
			</div>

			<div class="card slide-left col-xs-3" data-plugin-options='{"speed":1000, "distance":50}'>
				<img src="/blogjf/App/www/books/book_1.jpg" alt="Le Crime d'une nuit" width="200px"/>
			</div>

			<div class="card slide-right col-xs-3" data-plugin-options='{"speed":1000, "distance":50}'>
				<img src="/blogjf/App/www/books/book_2.jpg" alt="La Coalition" width="200px"/>
			</div>

			<div class="card slide-left col-xs-3" data-plugin-options='{"speed":1000, "distance":50}'>
				<img src="/blogjf/App/www/books/book_3.jpg" alt="Journal écrit en hiver" width="200px"/>
			</div>

			<div class="card slide-right col-xs-3" data-plugin-options='{"speed":1000, "distance":40}'>
				<img src="/blogjf/App/www/books/book_4.jpg" alt="La Dernière Nuit" width="200px"/>
			</div>

			<div class="card-reverse slide-right col-xs-3" data-plugin-options='{"speed":1000, "distance":40}'>
				<h4>Lire</h4>
				<a href="#presentation" class="btn btn-small btn-primary btnlink">
					Billet simple pour l'Alaska
				</a>
				<img src="/blogjf/App/www/img/alaska.jpg" alt="nouveau" width="200px"/>
				<p></p>
				<a href="#projet" class="btn btn-small btn-primary btnlink">Voir le projet</a>
			</div>

		</div>
	</div>
</section>

		<section class="projet" id="projet">
			<div class="box">
				<h3>Le projet</h3>
			</div>
			<div class="box2">
				<p>
				<?php echo $project->content ?>
				</p>
			</div>

			<div class="navbar navbar-bottom">
    			<div class="navbar-inner">
      				<div class="pull-right">
        				<a href="#presentation" class="btn btn-small btn-primary btnlink">Lire Billet simple pour l'Alaska </a>
      				</div>
    			</div>
  			</div>
		</section>
</div>
-->
<script type="text/javascript">
var offset = 0;


$(document).ready(function() {
    $("#nextEpisode").addClass('inactive');
});

// Episodes suivants
$("#prevEpisode").click(function() {
    if ($(this).hasClass('inactive')) {
        // Don't it's inactive
    } else {
        scrollEpisode('prev');
    }
});

// Episodes précédents
$("#nextEpisode").click(function() {
    if ($(this).hasClass('inactive')) {
        // Don't it's inactive
    } else {
        scrollEpisode('next');
    }
});

// Défilement des Episodes
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
