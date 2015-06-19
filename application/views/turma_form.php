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
			<input type="hidden" name="id" value="<?php if (!empty($turma)): echo $turma->id; endif;?>">
			<div class="form-group">
				<label for="id_anoletivo" class="col-sm-2 control-label">
					Ano Let&iacute;vo
				</label>
				<div class="col-sm-10">
					<select class="form-control" name="id_anoletivo" id="id_anoletivo">
						<option value="0">Selecione</option>
						<?php foreach($anoletivo as $id => $item): ?>
						<option value="<?php echo $id;?>"<?php if (!empty($turma) && ($turma->id_anoletivo == $id)) : echo " selected"; endif;?>><?php echo $item; ?></option>
						<?php endforeach; ?>
					</select>
				</div>
			</div>
			<div class="form-group">
				<label for="id_curso" class="col-sm-2 control-label">
					Curso
				</label>
				<div class="col-sm-10">
					<select class="form-control" name="id_curso" id="id_curso">
						<option value="0">Selecione</option>
						<?php foreach($curso as $id => $item): ?>
						<option value="<?php echo $id;?>"<?php if (!empty($turma) && ($turma->id_curso == $id)) : echo " selected"; endif;?>><?php echo $item; ?></option>
						<?php endforeach; ?>
					</select>
				</div>
			</div>
			<div class="form-group">
				<label for="id_serie" class="col-sm-2 control-label">
					Serie
				</label>
				<div class="col-sm-10">
					<select class="form-control" name="id_serie" id="id_serie">
						<option value="0">Selecione</option>
						<?php foreach($serie as $id => $item): ?>
						<option value="<?php echo $id;?>"<?php if (!empty($turma) && ($turma->id_serie == $id)) : echo " selected"; endif;?>><?php echo $item; ?></option>
						<?php endforeach; ?>
					</select>
				</div>
			</div>
			<div class="form-group">
				<label for="descricao" class="col-sm-2 control-label">
					Turma
				</label>
				<div class="col-sm-10">
					<input type="text" class="form-control" name="descricao" id="descricao" value="<?php if (!empty($turma)): echo $turma->descricao; endif;?>">
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
