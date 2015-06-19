<div class="container" role="main">
	<div class="row">
		<a class="btn btn-primary" href="<?php echo base_url();?>index.php/Turma/edit" role="button">Nova Turma</a>
	</div>
	<div class="row">
		<table class="table table-striped">
			<tr>
				<th>&nbsp;</th>
			   	<th>
					Ano Letivo
				</th>
			   	<th>
					Curso
				</th>
			   	<th>
					Serie
				</th>
			   	<th>
					Turma
				</th>
			</tr>
			<?php if(count($list) > 0 ): ?>
		   	<?php foreach($list as $item): ?>
			<tr>
				<td>
					<div class="btn-group visible-xs-block">
					  <button type="button" class="btn dropdown-toggle" data-toggle="dropdown">Opções<span class="caret"></span></button>
					  <ul class="dropdown-menu">
					    <li><a href="<?php echo base_url();?>index.php/Turma/edit/<?php echo $item->id ;?>">Editar</a></li>
						<li><a href="<?php echo base_url();?>index.php/Turma/add/<?php echo $item->id ;?>">Adicionar</a>
					    <li><a href="#">Excluir</a></li>
					  </ul>
					</div>
					<div class="btn-group hidden-xs">
						<a class="btn btn-sm btn-info" href="<?php echo base_url();?>index.php/Turma/edit/<?php echo $item->id ;?>"><span class="glyphicon glyphicon-edit" aria-hidden="true"></span></a>
						<a class="btn btn-sm btn-info" href="<?php echo base_url();?>index.php/Turma/add/<?php echo $item->id ;?>"><span class="glyphicon glyphicon-plus" aria-hidden="true"></span></a>
						<a class="btn btn-sm btn-danger" href="#"><span class="glyphicon glyphicon-trash" aria-hidden="true"></span></a>
					</div>
				</td>
				<td>
					<?php echo $item->get_anoletivo() ;?>
				</td>
				<td>
					<?php echo $item->get_curso() ;?>
				</td>
				<td>
					<?php echo $item->get_serie() ;?>
				</td>
				<td>
					<?php echo $item->descricao;?>
				</td>
		   	</tr>
		   	<?php endforeach; ?>
		   	<?php endif; ?>
		</table>
	</div>
	<div class="row">
		<a class="btn btn-primary" href="<?php echo base_url();?>index.php/Turma/edit" role="button">Nova Turma</a>
	</div>
<div>
