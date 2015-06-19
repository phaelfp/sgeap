<div class="container" role="main">
	<?php if (!empty($error)) :?>
	<div class="panel panel-danger">
	  <div class="panel-heading">Erro</div>
	  <div class="panel-body">
		<?php echo $error; ?>
	  </div>
	</div>
	<?php endif; ?>
	<?php if (!empty($success)) :?>
	<div class="panel panel-success">
	  <div class="panel-heading">Sucesso</div>
	  <div class="panel-body">
		<?php echo $success; ?>
	  </div>
	</div>
	<?php endif; ?>
	<div class="row">
		<form action="<?=$action?>" method="post" <?php if(empty($form_name)): ?> name="form1" <?php else: ?> name="<?=$form_name?>" <?php endif; ?> class="form-horizontal">
			<input type="hidden" name="id_turma" value="<?php if (!empty($turma)): echo $turma->id; endif;?>">
			<div class="form-group">
				<label class="col-sm-2 control-label">
					Turma
				</label>
				<div class="col-sm-10">
					<p class="form-control-static"><?php echo $turma->descricao ?></p>
				</div>
			</div>
			<div class="form-group">
				<label class="col-sm-offset-2 col-sm-10">
					Disciplinas
				</label>
			</div>
			<?php foreach($disciplinas as $id => $item): ?>
			<div class="checkbox">
			    <label class="col-sm-offset-2 col-sm-10">
			        <input
			   	  	type="checkbox" 
			   		name="id_disciplina[]" 
			   		id="disciplina_<?php echo $item->id;?>" 
			   		value="<?php echo $item->id; ?>"
			   		<?php if(in_array($item->id,$oferecimento)): echo " checked"; endif;?>>
			   			<?php echo $item->descricao;?>
			    </label>
			</div>
			<?php endforeach; ?>
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
