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
		<input type="hidden" name="dt_aula" value="<?=$dt_aula?>" />
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
				<label for="id_disciplina" class="col-sm-2 control-label">
					Disciplina
				</label>
				<div class="col-sm-10">
					<select id="id_disciplina" name="id_disciplina" class="form-control">
 						<option value=""> - </option>
					</select>
				</div>
			</div>
			<div class="checkbox" id="detail">
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
					jQuery('#detail').css('display','none');
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
				jQuery('#id_turma').change(function(){
					var id_turma = jQuery('#id_turma').val();
					jQuery.ajax({
						type: 'POST',
				        url: '<?php echo base_url(); ?>index.php/horario/getDisciplina',
				        data: {id_turma:id_turma}
					}).done(function(response){
						var disciplinas = JSON.parse(response);
						jQuery('#id_disciplina').html('<option value="-"> - </option>');
						for (i in disciplinas)
						{
							var disciplina = disciplinas[i];
							jQuery('#id_disciplina').append('<option value="'+ disciplina.id +'">'+ disciplina.descricao +'</option>');
						}
					});
				});
				jQuery('#id_disciplina').change(function(){
					var id_turma = jQuery('#id_turma').val();
					jQuery.ajax({
						type: 'POST',
						url: '<?php echo base_url(); ?>index.php/frequencia/getAluno',
						data: {id_turma:id_turma}
					}).done(function(response){
						jQuery('#detail').html('');
						var alunos = JSON.parse(response);
						for(i in alunos)
						{
							var aluno = alunos[i];
							jQuery('#detail').append('<div class="col-sm-offset-2 col-sm-10"><label><input type="checkbox" name="id_aluno[]" value="'+ aluno.id +'">'+aluno.nm_aluno+'</label></div>');
						}
					});
					jQuery('#detail').css('display','block');
				});
			});
		</script>
	</div>
</div>
