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
			<input type="hidden" name="id" value="<?php if (!empty($disciplina)): echo $disciplina->id; endif;?>">
			<div class="form-group">
				<label for="descricao" class="col-sm-2 control-label">
					Disciplina
				</label>
				<div class="col-sm-10">
					<input type="text" class="form-control" name="descricao" id="descricao" value="<?php if (!empty($disciplina)): echo $disciplina->descricao; endif;?>">
				</div>
			</div>
			<div class="form-group">
				<label for="impressao" class="col-sm-2 control-label">
					Nome para Impress&atilde;o
				</label>
				<div class="col-sm-10">
					<input type="text" class="form-control" name="impressao" id="impressao" value="<?php if (!empty($disciplina)): echo $disciplina->impressao; endif;?>">
				</div>
			</div>
			<div class="form-group">
				<label for="ementa" class="col-sm-2 control-label">
					Ementa
				</label>
				<div class="col-sm-10">
					<textarea class="form-control" name="ementa" id="ementa">
						<?php if (!empty($disciplina)): echo $disciplina->ementa; endif;?>
					</textarea>
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
