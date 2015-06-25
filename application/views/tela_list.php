<div class="container" role="main">
	<div id="alert"></div>
	<div class="row">
		<a class="btn btn-primary" href="<?php echo base_url();?>index.php/tela/edit" role="button">Novo Tela</a>
	</div>
	<div class="row">
		<table class="table table-striped">
			<tr>
				<th>&nbsp;</th>
			   	<th>
					Tela
				</th>
			</tr>
			<?php if(count($list) > 0 ): ?>
		   	<?php foreach($list as $item): ?>
			<tr>
				<td>
					<div class="btn-group visible-xs-block">
					  <button type="button" class="btn dropdown-toggle" data-toggle="dropdown">Opções<span class="caret"></span></button>
					  <ul class="dropdown-menu">
					    <li><a href="<?php echo base_url();?>index.php/tela/edit/<?php echo $item->id ;?>">Editar</a></li>
					    <li><a href="#">Excluir</a></li>
					  </ul>
					</div>
					<div class="btn-group hidden-xs">
						<a class="btn btn-sm btn-info" href="<?php echo base_url();?>index.php/tela/edit/<?php echo $item->id ;?>"><span class="glyphicon glyphicon-edit" aria-hidden="true"></span></a>
						<a class="btn btn-sm btn-danger delete-tela" href="#" data-id="<?php echo $item->id;?>"><span class="glyphicon glyphicon-trash" aria-hidden="true"></span></a>
					</div>
				</td>
				<td>
					<?php echo $item->nome ;?>
				</td>
		   	</tr>
		   	<?php endforeach; ?>
		   	<?php endif; ?>
		</table>
	</div>
	<div class="row">
		<a class="btn btn-primary" href="<?php echo base_url();?>index.php/tela/edit" role="button">Novo Tela</a>
	</div>
<div>
<script>
	jQuery(document).ready(function(){
		jQuery('.delete-tela').click(function(){
			if (confirm('Você realmente deseja excluir este tela?'))
			{
				var id_tela = jQuery(this).attr('data-id');
	   			jQuery.ajax({
	   		   		type: 'POST',
	   		   		url: 'tela/delete',
	   		   		data: {id:id_tela}
				}).done(function(response){
					if (-1 > response.lastIndexOf('success'))
					{
						location.reload();
					}
					jQuery('#alert').append(response);
				});
			}
		});
	});
</script>
