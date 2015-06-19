<nav class="navbar navbar-default navbar-fixed-top" role="navigation">
  <div class="container">
    <div class="navbar-header">
      <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#bs-navbar-collapse">
        <span class="sr-only">Toggle navigation</span>
        <span class="icon-bar"></span>
        <span class="icon-bar"></span>
        <span class="icon-bar"></span>
      </button>
	  <a class="navbar-brand" href="<?php echo base_url()?>">CP II</a>
    </div>    
    <div class="collapse navbar-collapse" id="bs-navbar-collapse">
      <ul class="nav navbar-nav">
        <li class="dropdown">
          <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false">Cadastro<span class="caret"></span></a>
          <ul class="dropdown-menu" role="menu">
            <li><a href="<?php echo base_url()?>index.php/AnoLetivo">Ano Letivo</a></li>
            <li><a href="<?php echo base_url()?>index.php/Serie">S&eacute;rie</a></li>
            <li><a href="<?php echo base_url()?>index.php/Curso">Curso</a></li>
            <li class="divider"></li>
            <li><a href="<?php echo base_url()?>index.php/Disciplina">Disciplina</a></li>
            <li><a href="<?php echo base_url()?>index.php/Turma">Turma</a></li>
            <li><a href="<?php echo base_url()?>index.php/Horario">Horario</a></li>
            <li class="divider"></li>
            <li><a href="<?php echo base_url()?>index.php/Aluno">Aluno</a></li>
          </ul>
        </li>
        <li class="dropdown">
			<a href="<?php echo base_url()?>index.php/Matricula">Matr&iacute;cula</a>
        </li>
        <li class="dropdown">
			<a href="<?php echo base_url()?>index.php/Frequencia">Frequ&ecirc;ncia</a>
        </li>
      </ul>
    </div>
  </div>
</nav>
