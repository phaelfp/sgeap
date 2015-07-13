<div class="container" role="main">
	<?php if ($edit): ?>
	<div class="row">
		<a class="btn btn-primary" href="<?php echo base_url();?>index.php/curso/edit" role="button">Novo Curso</a>
	</div>
   	<?php endif; ?>
	<div class="row">
		<table class="table table-striped">
			<tr>
				<th>&nbsp;</th>
			   	<th>
					Curso
				</th>
			</tr>
			<?php if(count($list) > 0 ): ?>
		   	<?php foreach($list as $item): ?>
			<tr>
				<td>
   					<?php if ($edit): ?>
					<div class="btn-group visible-xs-block">
					  <button type="button" class="btn dropdown-toggle" data-toggle="dropdown">Opções<span class="caret"></span></button>
					  <ul class="dropdown-menu">
					    <li><a href="<?php echo base_url();?>index.php/curso/edit/<?php echo $item->id ;?>">Editar</a></li>
					    <li><a href="#">Excluir</a></li>
					  </ul>
					</div>
					<div class="btn-group hidden-xs">
						<a class="btn btn-sm btn-info" href="<?php echo base_url();?>index.php/curso/edit/<?php echo $item->id ;?>"><span class="glyphicon glyphicon-edit" aria-hidden="true"></span></a>
						<a class="btn btn-sm btn-danger" href="#"><span class="glyphicon glyphicon-trash" aria-hidden="true"></span></a>
					</div>
   					<?php endif; ?>
				</td>
				<td>
					<?php echo $item->descricao ;?>
				</td>
		   	</tr>
		   	<?php endforeach; ?>
		   	<?php endif; ?>
		</table>
	</div>
	<nav>
	  <ul class="pagination">		
	    <li<?php if ($page == 1): ?> class="disabled"<?php endif; ?>>
          <a href="<?php echo base_url();?>index.php/curso/index/<?php echo $page-1;?>" aria-label="Previous">
	        <span aria-hidden="true">&laquo;</span>
	      </a>
		</li>
		<?php for($i=0;$i<$pages;$i++): ?>
		<li<?php if(($i+1)==$page):?> class="active"<?php endif;?>>
		  <a href="<?php echo base_url() ?>index.php/curso/index/<?php echo $i+1 ?>">
			<?php echo $i+1; if (($i+1)==$page): echo "<span class=\"sr-only\">(current)</span>"; endif;?>
		  </a>
		</li>
		<?php endfor; ?>
	    <li<?php if ($page == $i): ?> class="disabled"<?php endif; ?>>
		  <a href="<?php echo base_url();?>index.php/curso/index/<?php echo $page+1;?>" aria-label="Next">
	        <span aria-hidden="true">&raquo;</span>
	      </a>
	    </li>
	  </ul>
	</nav>
	<?php if ($edit): ?>
	<div class="row">
		<a class="btn btn-primary" href="<?php echo base_url();?>index.php/curso/edit" role="button">Novo Curso</a>
	</div>
	<?php endif; ?>
<div>
