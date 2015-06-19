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
		<form action="<?=$action?>" method="post" <?php if(empty($form_name)): ?> name="form1" <?php else: ?> name="<?=$form_name?>" <?php endif; ?> class="form-horizontal">
			<input type="hidden" name="id_dia_horario" id="id_dia_horario">
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
			<div class="row" id="detail">
				<button type="button" class="btn btn-primary btn-sm" data-toggle="modal" data-target="#formHorario">
				  Adicionar
				</button>
				<table class="table">
					<thead>
						<tr>
							<th>Dia</th>
							<th>Horário</th>
							<th>Tempos</th>
							<th>&nbsp;</th>
						<tr>
					</thead>
					<tbody id="horario">
						<tr>
							<td colspan='4'>Nenhum registro encontrado</td>
						</tr>
					</tbody>
				</table>
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
					jQuery('#cadastro').css('display','none');
					jQuery('#detail').css('display','none');
					jQuery('#id_anoletivo').change(function(){
					var id_anoletivo = jQuery('#id_anoletivo').val();
					jQuery.ajax({
						type: 'POST',
				        url: 'Curso/getCurso',
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
				        url: 'Serie/getSerie',
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
				        url: 'Turma/getTurma',
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
				        url: 'Horario/getDisciplina',
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
					jQuery('#detail').css('display','block');
					loadTable();
				});
				jQuery('#btn_salvar').click(function(){
					var id_turma = jQuery('#id_turma_horario').val();
					var id_disciplina = jQuery('#id_disciplina_horario').val();
					var id_dia_semana = jQuery('#id_dia_semana').val();
					var id_horario = jQuery('#id_horario').val();
					var n_tempos = jQuery('#n_tempos').val();
					jQuery.ajax({
						type: 'POST',
						url: 'Horario/salvarHorario',
						data: {id_turma:id_turma,id_disciplina:id_disciplina,id_dia_semana:id_dia_semana,id_horario:id_horario,n_tempos:n_tempos}
					}).done(function(response){
						loadTable();
						jQuery('#formHorario').modal('hide');
					});
					return false;
				});
			});
   			function loadTable()
   			{
   				var id_turma = jQuery('#id_turma').val();
   				var id_disciplina = jQuery('#id_disciplina').val();
   				jQuery('#id_turma_horario').val(id_turma);
   				jQuery('#id_disciplina_horario').val(id_disciplina);
   				jQuery.ajax({
   					type: 'POST',
   					url: 'Horario/getHorario',
   					data: {id_turma:id_turma,id_disciplina:id_disciplina}
				}).done(function(response){
					jQuery('#id_dia_horario').val(response);
   					var horarios = JSON.parse(response);
   					jQuery('#horario').html('');
   					for (i in horarios)
   					{
   						var horario = horarios[i];
   						jQuery('#horario').append('<tr><td>'+ horario.dia +'</td><td>'+horario.horario+'</td><td>'+horario.n_tempos+'</td><td><a class="btn btn-danger btn-sm" href="#" onclick="delHorario(\''+horario.id+'\')"><span class="glyphicon glyphicon-trash" aria-hidden="true"></span></a></td></tr>');
   					}
   				});
			}
			function delHorario(id_dia_horario)
			{
				if (confirm('Deseja realmente apagar o horário?'))
				{
					jQuery.ajax({
						type: 'GET',
						url: 'Horario/deletarHorario/'+id_dia_horario,
					}).done(function(response){
						var alert_text = '<div role="alert" class="alert alert-success alert-dismissible fade in">\r\n<button aria-label="Close" data-dismiss="alert" class="close" type="button"><span aria-hidden="true">×</span></button>\r\n<strong>'+response+'</strong>\r\n</div>';
						jQuery('#alert').append(alert_text);
						loadTable();
					});
				}
			}
		</script>
	</div>
</div>
<div class="modal fade" id="formHorario" data-backdrop="static" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Fechar"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title">Dia e Horário</h4>
      </div>
		<form action="<?=$action?>" method="post" <?php if(empty($form_name)): ?> name="form1" <?php else: ?> name="<?=$form_name?>" <?php endif; ?> class="form-horizontal">
	  <div class="modal-body">

			<input type="hidden" name="id_turma" value="" id="id_turma_horario">
			<input type="hidden" name="id_disciplina" value="" id="id_disciplina_horario">
			<div class="form-group">
				<label for="id_dia_semana" class="col-sm-4 control-label">
					Dia da Semana
				</label>
				<div class="col-sm-8">
					<select id="id_dia_semana" name="id_dia_semana" class="form-control">
						<option value='2'>Segunda-Feira</option>
						<option value='3'>Terça-Feira</option>
						<option value='4'>Quarta-Feira</option>
						<option value='5'>Quinta-Feira</option>
						<option value='6'>Sexta-Feira</option>
						<option value='7'>Sábado</option>
					</select>
				</div>
			</div>
			<div class="form-group">
				<label for="id_horario" class="col-sm-4 control-label">
					Horário Início
				</label>
				<div class="col-sm-8">
					<select id="id_horario" name="id_horario" class="form-control">
						<option value='1'>18h00</option>
						<option value='2'>18h40</option>
						<option value='3'>19h35</option>
						<option value='4'>20h15</option>
						<option value='5'>20h55</option>
						<option value='6'>21h35</option>
					</select>
				</div>
			</div>
			<div class="form-group">
				<label for="n_tempos" class="col-sm-4 control-label">
					Número de tempos
				</label>
				<div class="col-sm-8">
					<input type="text" id="n_tempos" name="n_tempos" class="form-control">
				</div>
			</div>

      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">Cancelar</button>
        <button type="submit" id="btn_salvar" class="btn btn-primary">Salvar</button>
      </div>
		</form>
    </div>
  </div>
</div>
