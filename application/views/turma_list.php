<div class="container" role="main">
   	<?php if ($edit): ?>
	<div class="row">
		<a class="btn btn-primary" href="<?php echo base_url();?>index.php/turma/edit" role="button">Nova Turma</a>
	</div>
   	<?php endif; ?>
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
					<?php if ($edit || $add || $addAluno): ?>
					<div class="btn-group visible-xs-block">
					  <button type="button" class="btn dropdown-toggle" data-toggle="dropdown">Opções<span class="caret"></span></button>
					  <ul class="dropdown-menu">
						<?php if ($edit): ?>
					    <li><a href="<?php echo base_url();?>index.php/turma/edit/<?php echo $item->id ;?>">Editar</a></li>
						<?php endif; ?>
						<?php if ($add): ?>
						<li><a href="<?php echo base_url();?>index.php/turma/add/<?php echo $item->id ;?>">Adicionar Disciplina</a>
						<?php endif; ?>
						<?php if ($addAluno): ?>
						<li><a href="<?php echo base_url();?>index.php/turma/addAluno/<?php echo $item->id ;?>">Adicionar Aluno</a>
						<?php endif; ?>
						<?php if ($edit): ?>
					    <li><a href="#">Excluir</a></li>
						<?php endif; ?>
					  </ul>
					</div>
					<div class="btn-group hidden-xs">
						<?php if ($edit): ?>
						<a class="btn btn-sm btn-info" href="<?php echo base_url();?>index.php/turma/edit/<?php echo $item->id ;?>"><span class="glyphicon glyphicon-edit" aria-hidden="true"></span></a>
						<?php endif; ?>
						<?php if ($add): ?>
						<a class="btn btn-sm btn-info" href="<?php echo base_url();?>index.php/turma/add/<?php echo $item->id ;?>"><span class="glyphicon glyphicon-plus" aria-hidden="true"></span></a>
						<?php endif; ?>
						<?php if ($addAluno): ?>
						<a class="btn btn-sm btn-info" href="<?php echo base_url();?>index.php/turma/addAluno/<?php echo $item->id ;?>"><span class="glyphicon glyphicon-user" aria-hidden="true"></span></a>
						<?php endif; ?>
						<?php if ($edit): ?>
						<a class="btn btn-sm btn-danger" href="#"><span class="glyphicon glyphicon-trash" aria-hidden="true"></span></a>
						<?php endif; ?>
					</div>
   					<?php endif; ?>
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
	<nav>
	  <ul class="pagination">		
	    <li<?php if ($page == 1): ?> class="disabled"<?php endif; ?>>
          <a href="<?php echo base_url();?>index.php/turma/index/<?php echo $page-1;?>" aria-label="Previous">
	        <span aria-hidden="true">&laquo;</span>
	      </a>
		</li>
		<?php for($i=0;$i<$pages;$i++): ?>
		<li<?php if(($i+1)==$page):?> class="active"<?php endif;?>>
		  <a href="<?php echo base_url() ?>index.php/turma/index/<?php echo $i+1 ?>">
			<?php echo $i+1; if (($i+1)==$page): echo "<span class=\"sr-only\">(current)</span>"; endif;?>
		  </a>
		</li>
		<?php endfor; ?>
	    <li<?php if ($page == $i): ?> class="disabled"<?php endif; ?>>
		  <a href="<?php echo base_url();?>index.php/turma/index/<?php echo $page+1;?>" aria-label="Next">
	        <span aria-hidden="true">&raquo;</span>
	      </a>
	    </li>
	  </ul>
	</nav>
   	<?php if ($edit): ?>
	<div class="row">
		<a class="btn btn-primary" href="<?php echo base_url();?>index.php/turma/edit" role="button">Nova Turma</a>
	</div>
   	<?php endif; ?>
<div>
