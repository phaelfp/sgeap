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
			<input type="hidden" name="id" value="<?php if (!empty($serie)): echo $serie->id; endif;?>">
			<div class="form-group">
				<label for="descricao" class="col-sm-2 control-label">
					Serie
				</label>
				<div class="col-sm-10">
					<input type="text" class="form-control" name="descricao" id="descricao" value="<?php if (!empty($serie)): echo $serie->descricao; endif;?>">
				</div>
			</div>
			<div class="form-group">
				<label for="serieanterior" class="col-sm-2 control-label">
					Serie Anterior
				</label>
				<div class="col-sm-10">
					<select class="form-control" name="id_serie_anterior" id="serieanterior">
						<option value=""> - </option>
					<?php foreach ($series as $item): ?>
					<?php if ($item->id === $serie->id_serie_anterior): ?>
						<option selected="selected" value="<?php echo $item->id?>"><?php echo $item->descricao; ?></option>
					<?php else: ?>
						<option value="<?php echo $item->id?>"><?php echo $item->descricao; ?></option>
					<?php endif; ?>
					<?php endforeach; ?>
					</select>					
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
