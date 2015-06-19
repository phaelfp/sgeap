	<?php if (!empty($title)): ?><h1><?=$title?></h1><?php endif;?>

	<div id="body">
		<?php if(count($students) && !empty($students)):?>
		<ul>
		<?php foreach($students as $i => $student): ?>
		<li><?=$student->name?> - <a href="<?php echo base_url();?>index.php/Student/edit/<?=$student->id;?>">Editar</a></li>
		<?php endforeach; ?>
		</ul>
		<?php endif; ?>
	</div>
