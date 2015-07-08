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
			<input type="hidden" name="id" value="<?php if (!empty($pessoa)): echo $pessoa->id; endif;?>">
			<div class="form-group">
				<label for="nome" class="col-sm-2 control-label">
					Nome Completo
				</label>
				<div class="col-sm-10">
					<p class="form-control-static"><?php echo $pessoa->nome ?></p>
				</div>
			</div>
			<div class="form-group">
				<label for="login" class="col-sm-2 control-label">
					Login
				</label>
				<div class="col-sm-10">
					<p class="form-control-static"><?php echo $pessoa->login ?></p>
				</div>
			</div>
			<div class="form-group">
				<label for="password" class="col-sm-2 control-label">
					Senha Atual
				</label>
				<div class="col-sm-10">
					<input type="password" class="form-control" name="password" id="password">
				</div>
			</div>
			<div class="form-group">
				<label for="newpassword" class="col-sm-2 control-label">
					Nova Senha
				</label>
				<div class="col-sm-10">
					<input type="password" class="form-control" name="newpassword" id="newpassword">
				</div>
			</div>
			<div class="form-group">
				<label for="confirmnew" class="col-sm-2 control-label">
					Confirmar Nova Senha
				</label>
				<div class="col-sm-10">
					<input type="password" class="form-control" name="confirmnew" id="confirmnew">
				</div>
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
