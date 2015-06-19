<div class="container" role="main">
	<?php if (!empty($error)) :?>
	<div role="alert" class="alert alert-danger alert-dismissible fade in">
		<button aria-label="Close" data-dismiss="alert" class="close" type="button">
			<span aria-hidden="true">×</span>
		</button>
		<strong>Erro: </strong><?php echo $error;?>
	</div>
	<?php endif; ?>
	<?php if (!empty($success)) :?>
	<div role="alert" class="alert alert-success alert-dismissible fade in">
		<button aria-label="Close" data-dismiss="alert" class="close" type="button">
			<span aria-hidden="true">×</span>
		</button>
		<strong>Sucesso: </strong><?php echo $success;?>
	</div>
	<?php endif; ?>
	<div class="row">
		<form action="<?=$action?>" method="post" <?php if(empty($form_name)): ?> name="form1" <?php else: ?> name="<?=$form_name?>" <?php endif; ?> class="form-horizontal">
			<input type="hidden" name="id" value="<?php if (!empty($aluno)): echo $aluno->id; endif;?>">
			<div class="form-group">
				<label for="nm_aluno" class="col-sm-2 control-label">
					Aluno
				</label>
				<div class="col-sm-10">
					<input type="text" class="form-control" name="nm_aluno" id="nm_aluno" value="<?php if (!empty($aluno)): echo $aluno->nm_aluno; endif;?>">
				</div>
			</div>
			<div class="form-group">
				<label for="cpf" class="col-sm-2 control-label">
					CPF
				</label>
				<div class="col-sm-10">
					<input type="text" class="form-control" name="cpf" id="cpf" value="<?php if (!empty($aluno)): echo $aluno->cpf; endif;?>">
				</div>
			</div>
			<div class="form-group">
				<label for="banco" class="col-sm-2 control-label">
					Banco
				</label>
				<div class="col-sm-10">
					<input type="text" class="form-control" name="banco" id="banco" value="<?php if (!empty($aluno)): echo $aluno->banco; endif;?>">
				</div>
			</div>
			<div class="form-group">
				<label for="agencia" class="col-sm-2 control-label">
					Agencia
				</label>
				<div class="col-sm-10">
					<input type="text" class="form-control" name="agencia" id="agencia" value="<?php if (!empty($aluno)): echo $aluno->agencia; endif;?>">
				</div>
			</div>
			<div class="form-group">
				<label for="c_corrente" class="col-sm-2 control-label">
					N&ordm; Conta Corrente
				</label>
				<div class="col-sm-10">
					<input type="text" class="form-control" name="c_corrente" id="c_corrente" value="<?php if (!empty($aluno)): echo $aluno->c_corrente; endif;?>">
				</div>
			</div>
			<div class="checkbox">
			    <label class="col-sm-offset-2 col-sm-10">
			        <input
			   	  	type="checkbox" 
			   		name="is_ativo" 
			   		id="is_ativo" 
			   		value="1"
			   		<?php if(!empty($aluno) && ($aluno->is_ativo == 1)): echo " checked"; endif;?>>
			   			Abandonou
			    </label>
			</div>
			<div class="checkbox">
			    <label class="col-sm-offset-2 col-sm-10">
			        <input
			   	  	type="checkbox" 
			   		name="is_trancado" 
			   		id="is_trancado" 
			   		value="1"
			   		<?php if(!empty($aluno) && ($aluno->is_trancado == 1)): echo " checked"; endif;?>>
			   			Trancou
			    </label>
			</div>
			<hr>
			<div class="form-group">
			    <div class="col-sm-offset-2 col-sm-10">
			    	<button type="submit" class="btn btn-default">Enviar</button>
			    </div>
			</div>
		</form>
	</div>
</div>
<!-- <?php print_r($oferecimento);?> -->
