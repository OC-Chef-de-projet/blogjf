<div class="container">
    <div class="row">
        <div class="col-xs-4 chapter-head">
            <h2 class="text-center">Ajouter un episode</h2>
        </div>
        <?php if($errorMessage): ?>
        <div class="col-xs-12  alert alert-danger">
            <?= $errorMessage; ?>
        </div>
        <?php endif; ?>
    </div>
    <br>
    <div class="row">
        <?php $this->Form->create('Episode'); ?>
        <div class="form-group">
            <?= $this->Form->input([ 'field' => 'title', 'label' => 'Titre', 'type' => 'text', 'class' => 'form-control']); ?>
        </div>
        <div class="form-group">
            <?= $this->Form->input([ 'field' => 'content', 'label' => 'Contenu', 'type' => 'textarea' ]); ?>
        </div>
        <?= $this->Form->end(['value' => 'Envoyer', 'class' => 'btn btn-primary' ]) ?>
    </div>
</div>
<script type="text/javascript">
$('.active').removeClass('active');
$('#episode').addClass('active');
</script>
