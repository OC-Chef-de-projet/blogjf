<section class="presentation" id="presentation">
	<div class="container-fuild">

		 <?php $this->Form->create('Login'); ?>
			<div class="row vertical-center">
				<div class="col-sm-4"></div>
				<div class="col-sm-4">
					<h2 class="form-signin-heading">Connexion</h2>
					<?php if($error): ?>
						<div class="alert alert-danger"><?php echo $error ?></div>
					<?php endif; ?>
					<?php echo $this->Form->input([ 'field' => 'login', 'label' => '', 'type' => 'text', 'class' => 'form-control','placeholder' =>'Identifiant']); ?>
					<?php echo $this->Form->input([ 'field' => 'password', 'label' => '', 'type' => 'password', 'class' => 'form-control','placeholder' =>'Mot de passe']); ?>
					 <?php echo $this->Form->end(['value' => 'Connexion', 'class' => 'btn btn-lg btn-primary btn-block' ]) ?>
				</div>
				<div class="col-sm-4"></div>
			</div>
		</form>
	</div>
</section>

