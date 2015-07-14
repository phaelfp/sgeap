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
	<div id="alert"></div>
	<div class="row">
		<form action="<?=$action?>" method="post" <?php if(empty($form_name)): ?> name="form1" <?php else: ?> name="<?=$form_name?>" <?php endif; ?> target="_blank" class="form-horizontal">
			<div class="form-group">
				<label for="id_anoletivo" class="col-sm-2 control-label">
					Ano Letivo
				</label>
				<div class="col-sm-10">
					<select id="id_anoletivo" name="id_anoletivo" class="form-control">
 						<option value=""> - </option>
						<?php foreach ($anoletivo as $item): ?>
						<option value="<?php echo $item->id?>"><?php echo $item->ano; ?></option>
						<?php endforeach; ?>
					</select>
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
