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
			<input type="hidden" name="id" value="<?php if (!empty($certificacao)): echo $certificacao->id; endif;?>">
			<div class="form-group">
				<label for="descricao" class="col-sm-2 control-label">
					Certifica&ccedil;&atilde;o
				</label>
				<div class="col-sm-10">
					<input type="text" class="form-control" name="descricao" id="descricao" value="<?php if (!empty($certificacao)): echo $certificacao->descricao; endif;?>">
				</div>
			</div>
			<div class="form-group">
				<label for="media" class="col-sm-2 control-label">
					Formula&ccedil;&atilde;o para a m&eacute;dia
				</label>
				<div class="col-sm-10">
					<input type="text" class="form-control" name="media" id="media" value="<?php if (!empty($certificacao)): echo $certificacao->media; endif;?>">
				</div>
			</div>
			<div class="form-group">
				<label for="id_certificacao" class="col-sm-2 control-label">
					Certifica&ccedil;&atilde;o Anterior
				</label>
				<div class="col-sm-10">
					<select class="form-control" name="id_certificacao" id="id_certificacao">
						<option value=""> - </option>
					<?php foreach ($certificacoes as $item): ?>
					<?php if ($item->id === $certificacao->id_certificacao): ?>
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
