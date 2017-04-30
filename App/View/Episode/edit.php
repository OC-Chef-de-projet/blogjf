<script>

</script>
<div class="container">
    <div class="row">
        <div class="col-xs-4 chapter-head">
            <h2 class="text-center">Modifier un episode</h2>
        </div>
    </div>
    <br>
    <div class="row">
        <?= $this->Form()->create('episode'); ?>
        <div class="form-group">
            <?= $this->Form()->input([
				'field' => 'title',
				'label' => 'Titre',
				'type' => 'text',
				'class' => 'form-control',
				'value' => $episode->title
				]);
			?>
        </div>
        <div class="form-group">
            <?= $this->Form()->input([
				'field' => 'content',
				'label' => 'Contenu',
				'type' => 'textarea',
				'value' => $episode->content
				]); ?>
        </div>
        <?= $this->Form()->end([
			'value' => 'Envoyer',
			'class' => 'btn btn-primary'
		]) ?>
    </div>
</div>
<script type="text/javascript">
$('.active').removeClass('active');
$('#episode').addClass('active');
</script>
