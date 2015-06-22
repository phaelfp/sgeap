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
		<form method="post" name="form1" class="form-horizontal">
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
			    	<button type="button" id="validar" class="btn btn-default">Enviar</button>
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

	  		jQuery.ajax({
	  			url: "<?php echo base_url();?>index.php/login/validar",
	  			type: "POST",
	  			dataType: "json",
	  			data: {username:user,password:pass},
	  			success: function(data) {
	  				if(data.error){
	  					jQuery('.error').html(data.error);
					} else {
	  					location = "<?php echo base_url();?>index.php/welcome/";
	  				}
	  			} 					
	  		});		

		});
	});
	</script>
</script>
