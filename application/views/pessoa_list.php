<div class="container" role="main">
	<div id="alert"></div>
   	<?php if ($edit): ?>
	<div class="row">
		<a class="btn btn-primary" href="<?php echo base_url();?>index.php/pessoa/edit" role="button">Novo Pessoa</a>
	</div>
   	<?php endif; ?>
	<div class="row">
		<table class="table table-striped">
			<tr>
				<th>&nbsp;</th>
			   	<th>
					Pessoa
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
					    <li><a href="<?php echo base_url();?>index.php/pessoa/edit/<?php echo $item->id ;?>">Editar</a></li>
					    <li><a href="#">Excluir</a></li>
					  </ul>
					</div>
					<div class="btn-group hidden-xs">
						<a class="btn btn-sm btn-info" href="<?php echo base_url();?>index.php/pessoa/edit/<?php echo $item->id ;?>"><span class="glyphicon glyphicon-edit" aria-hidden="true"></span></a>
						<a class="btn btn-sm btn-danger delete-pessoa" href="#" data-id="<?php echo $item->id;?>"><span class="glyphicon glyphicon-trash" aria-hidden="true"></span></a>
					</div>
   					<?php endif; ?>
				</td>
				<td>
					<?php echo $item->nome ;?>
				</td>
		   	</tr>
		   	<?php endforeach; ?>
		   	<?php endif; ?>
		</table>
	</div>
   	<?php if ($edit): ?>
	<div class="row">
		<a class="btn btn-primary" href="<?php echo base_url();?>index.php/pessoa/edit" role="button">Novo Pessoa</a>
	</div>
   	<?php endif; ?>
<div>
<script>
	jQuery(document).ready(function(){
		jQuery('.delete-pessoa').click(function(){
			if (confirm('Você realmente deseja excluir este pessoa?'))
			{
				var id_pessoa = jQuery(this).attr('data-id');
	   			jQuery.ajax({
	   		   		type: 'POST',
	   		   		url: 'pessoa/delete',
	   		   		data: {id:id_pessoa}
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
