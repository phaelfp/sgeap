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
			<input type="hidden" name="id" value="<?php if (!empty($anoletivo)): echo $anoletivo->id; endif;?>">
			<input type="hidden" name="is_ativo" value="<?php if (!empty($anoletivo)): echo $anoletivo->is_ativo; endif;?>">
			<input type="hidden" name="dt_inicio" value="<?php if (!empty($anoletivo)): echo $anoletivo->dt_inicio; endif;?>">
			<input type="hidden" name="dt_termino" value="<?php if (!empty($anoletivo)): echo $anoletivo->dt_termino; endif;?>">
			<div class="form-group">
				<label for="ano" class="col-sm-2 control-label">
					Ano Letivo
				</label>
				<div class="col-sm-10">
					<input type="text" class="form-control" name="ano" id="ano" value="<?php if (!empty($anoletivo)): echo $anoletivo->ano; endif;?>">
				</div>
			</div>
			<div class="form-group">
			    <div class="col-sm-offset-2 col-sm-10">
			    	<button type="submit" class="btn btn-default">Enviar</button>
			    </div>
			</div>
		</form>
	</div>
</div>
