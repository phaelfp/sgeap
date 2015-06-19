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
			<input type="hidden" name="id" value="<?php if (!empty($aluno)): echo $aluno->id; endif;?>">
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
			<div class="form-group">
				<label for="id_curso" class="col-sm-2 control-label">
					Curso
				</label>
				<div class="col-sm-10">
					<select id="id_curso" name="id_curso" class="form-control">
 						<option value=""> Selecione o Ano Letivo </option>
					</select>
				</div>
			</div>
			<div class="form-group">
				<label for="id_serie" class="col-sm-2 control-label">
					Serie
				</label>
				<div class="col-sm-10">
					<select id="id_serie" name="id_serie" class="form-control">
 						<option value=""> - </option>
					</select>
				</div>
			</div>
			<div class="form-group">
				<label for="id_turma" class="col-sm-2 control-label">
					Turma
				</label>
				<div class="col-sm-10">
					<select id="id_turma" name="id_turma" class="form-control">
 						<option value=""> - </option>
					</select>
				</div>
			</div>
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
		<script>
			jQuery('document').ready(function(){
				jQuery('#id_anoletivo').change(function(){
					var id_anoletivo = jQuery('#id_anoletivo').val();
					jQuery.ajax({
						type: 'POST',
							url: '<?php echo base_url(); ?>index.php/curso/getCurso',
				        data: {id_anoletivo:id_anoletivo}
					}).done(function(response){
						var cursos = JSON.parse(response);
						jQuery('#id_curso').html('<option value="-"> - </option>');
						for (i in cursos)
						{
							var curso = cursos[i];
							jQuery('#id_curso').append('<option value="'+ curso.id +'">'+ curso.descricao +'</option>');
						}
					});
				});
				jQuery('#id_curso').change(function(){
					var id_anoletivo = jQuery('#id_anoletivo').val();
					var id_curso = jQuery('#id_curso').val();
					jQuery.ajax({
						type: 'POST',
				        url: '<?php echo base_url(); ?>index.php/serie/getSerie',
				        data: {id_anoletivo:id_anoletivo,id_curso:id_curso}
					}).done(function(response){
						var series = JSON.parse(response);
						jQuery('#id_serie').html('<option value="-"> - </option>');
						for (i in series)
						{
							var serie = series[i];
							jQuery('#id_serie').append('<option value="'+ serie.id +'">'+ serie.descricao +'</option>');
						}
					});
				});
				jQuery('#id_serie').change(function(){
					var id_anoletivo = jQuery('#id_anoletivo').val();
					var id_curso = jQuery('#id_curso').val();
					var id_serie = jQuery('#id_serie').val();
					jQuery.ajax({
						type: 'POST',
				        url: '<?php echo base_url(); ?>index.php/turma/getTurma',
				        data: {id_anoletivo:id_anoletivo,id_curso:id_curso,id_serie:id_serie}
					}).done(function(response){
						var turmas = JSON.parse(response);
						jQuery('#id_turma').html('<option value="-"> - </option>');
						for (i in turmas)
						{
							var turma = turmas[i];
							jQuery('#id_turma').append('<option value="'+ turma.id +'">'+ turma.descricao +'</option>');
						}
					});
				});
			});
		</script>
	</div>
</div>
