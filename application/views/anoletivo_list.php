<div class="container" role="main">
	<div class="row">
		<a class="btn btn-primary" href="<?php echo base_url();?>index.php/anoletivo/edit" role="button">Novo ano letivo</a>
	</div>
	<div class="row">
		<table class="table table-striped">
			<tr>
				<th>&nbsp;</th>
			   	<th>
					Ano Letivo
				</th>
			</tr>
			<?php if(count($list) > 0 ): ?>
		   	<?php foreach($list as $item): ?>
			<tr>
                <td>
					<div class="btn-group visible-xs-block">
					  <button type="button" class="btn dropdown-toggle" data-toggle="dropdown">Opções<span class="caret"></span></button>
					  <ul class="dropdown-menu">
					    <li><a href="<?php echo base_url();?>index.php/anoletivo/edit/<?php echo $item->id ;?>">Editar</a></li>
					    <li><a href="#">Excluir</a></li>
					  </ul>
					</div>
					<div class="btn-group hidden-xs">
						<a class="btn btn-sm btn-info" href="<?php echo base_url();?>index.php/anoletivo/edit/<?php echo $item->id ;?>"><span class="glyphicon glyphicon-edit" aria-hidden="true"></span></a>
						<a class="btn btn-sm btn-danger" href="#"><span class="glyphicon glyphicon-trash" aria-hidden="true"></span></a>
					</div>
				</td>
				<td>
					<?php echo $item->ano ;?>
				</td>
		   	</tr>
		   	<?php endforeach; ?>
		   	<?php endif; ?>
		</table>
	</div>
	<div class="row">
		<a class="btn btn-primary" href="<?php echo base_url();?>index.php/anoletivo/edit" role="button">Novo ano letivo</a>
	</div>
<div>
