<div class="container" role="main">
	<?php if (!empty($error)) :?>
	<div class="panel panel-danger">
	  <div class="panel-heading">Erro</div>
	  <div class="panel-body">
		<?php echo $error; ?>
	  </div>
	</div>
	<?php endif; ?>
	<?php if (!empty($success)) :?>
	<div class="panel panel-success">
	  <div class="panel-heading">Sucesso</div>
	  <div class="panel-body">
		<?php echo $success; ?>
	  </div>
	</div>
	<?php endif; ?>
	<div class="row">
		<form action="<?=$action?>" method="post" <?php if(empty($form_name)): ?> name="form1" <?php else: ?> name="<?=$form_name?>" <?php endif; ?> class="form-horizontal">
			<input type="hidden" name="id_turma" value="<?php if (!empty($turma)): echo $turma->id; endif;?>">
			<div class="form-group">
				<label class="col-sm-2 control-label">
					Turma
				</label>
				<div class="col-sm-10">
					<p class="form-control-static"><?php echo $turma->descricao ?></p>
				</div>
			</div>
			<div class="form-group">
				<label class="col-sm-2 control-label">
					Aluno
				</label>
				<div class="col-sm-10">
			    	<input type="text" name="nm_aluno" id="nm_aluno" class="form-control autocomplete" placeholder="Localizar">
					<input type="hidden" name="id_aluno" id="id_aluno" value="" class="valuecomplete">
					<div id="resultcomplete" class="col-sm-10"></div>
				</div>
			</div>
			<hr>
			<div class="form-group">
			    <div class="col-sm-offset-2 col-sm-10">
			    	<button type="submit" class="btn btn-default">Enviar</button>
			    </div>
			</div>
		</form>
	</div>
	<div class="row">
		<div class="row">
			<label class="col-sm-offset-2 col-sm-10">
				Alunos
			</label>
		</div>
		<?php foreach($alunos as $id => $item): ?>
		<div class="row">
			<label class="col-sm-offset-2 col-sm-10">
   				<?php echo $item->nm_aluno;?>
			</label>
		</div>
		<?php endforeach; ?>
	</div>
</div>
<script>
var MIN_LENGTH = 2;
jQuery( document ).ready(function() {
	jQuery(".autocomplete").attr('autocomplete','off');
	jQuery(".autocomplete").keyup(function() {
		var keyword = jQuery(".autocomplete").val();
		if (keyword.length >= MIN_LENGTH) {

			$.get( "<?php echo base_url()?>index.php/turma/getAluno/" + keyword)
			.done(function( data ) {
				jQuery('#resultcomplete').html('');
				var results = jQuery.parseJSON(data);
				jQuery(results).each(function(key, value) {
					jQuery('#resultcomplete').append('<div class="item" rel="'+ value.id +'">' + value.nm_aluno + '</div>');
				})

			    jQuery('.item').click(function() {
					var text = jQuery(this).html();
					var key  = jQuery(this).attr('rel');
					$('.autocomplete').val(text);
					$('.valuecomplete').val(key);
			    })

			});
		} else {
			$('#resultcomplete').html('');
		}
	});

    $(".autocomplete").blur(function(){
    		$("#resultcomplete").fadeOut(500);
    	})
        .focus(function() {		
    	    $("#resultcomplete").show();
    	});

});
</script>
