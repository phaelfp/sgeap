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
	<div class="error"></div>
	<div class="row">
		<form action="<?=$action?>" method="post" <?php if(empty($form_name)): ?> name="form1" <?php else: ?> name="<?=$form_name?>" <?php endif; ?> class="form-horizontal">
			<div class="form-group">
				<label for="username" class="col-sm-2 control-label">
					Login
				</label>
				<div class="col-sm-10">
					<input type="text" class="form-control" name="username" id="username">
				</div>
			</div>
			<div class="form-group">
				<label for="password" class="col-sm-2 control-label">
					Password
				</label>
				<div class="col-sm-10">
					<input type="password" class="form-control" name="password" id="password">
				</div>
			</div>
			<div class="form-group">
			    <div class="col-sm-offset-2 col-sm-10">
			    	<button type="submit" id="validar" class="btn btn-default">Enviar</button>
			    </div>
			</div>
		</form>
	</div>
</div>
<script>
jQuery(function(){
		jQuery('#validar').click(function(){	
			var user = $('#username').val();
			var pass = $('#password').val();
			var err  = '';
			if(!user && !pass){
				err = "Todos os campos s&atilde;o obrigat&oacute;rios"; 
			}	

			if(err){
				$('.error').html('<div role="alert" class="alert alert-danger alert-dismissible fade in">
		<button aria-label="Close" data-dismiss="alert" class="close" type="button">
			<span aria-hidden="true">×</span>
		</button>
		<strong>Erro: </strong>'+ error +'
	</div>');
			} else {
				jQuery.ajax({
					url: "<?php echo base_url();?>index.php/login/validar",
					type: "POST",
					dataType: "json",
					data: {username:user,password:pass},
					success: function(data) {
						if(data.error){
							jQuery('.error').html('<div role="alert" class="alert alert-danger alert-dismissible fade in">
		<button aria-label="Close" data-dismiss="alert" class="close" type="button">
			<span aria-hidden="true">×</span>
		</button>
		<strong>Erro: </strong>'+ data.error +'
	</div>');
						} else {
							location = "<?php echo base_url();?>index.php/welcome/";
						}
					} 					
				});		

			}			
		});
	});
	</script>
</script>
