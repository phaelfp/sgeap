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
			<input type="hidden" name="id" value="<?php if (!empty($perfil)): echo $perfil->id; endif;?>">
			<div class="form-group">
				<label for="descricao" class="col-sm-2 control-label">
					Perfil
				</label>
				<div class="col-sm-10">
					<input type="text" class="form-control" name="descricao" id="descricao" value="<?php if (!empty($perfil)): echo $perfil->descricao; endif;?>">
				</div>
			</div>
			<div class="checkbox">
				<?php foreach ($tela as $key => $value) : ?>
				<div class="col-sm-offset-2 col-sm-10"><label><input type="checkbox" <?php if(in_array($value->id, $acessa)): ?>checked="checked" <?php endif; ?>name="tela[]" value="<?=$value->id?>"><?=$value->nome?></label></div>
				<?php endforeach; ?>
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
<!--
<?php 
	print_r($tela);
	echo "\n\n\n";
	print_r($acessa);
?>
-->
