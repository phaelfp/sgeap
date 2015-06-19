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
            <li><a href="<?php echo base_url()?>index.php/anoletivo">Ano Letivo</a></li>
            <li><a href="<?php echo base_url()?>index.php/serie">S&eacute;rie</a></li>
            <li><a href="<?php echo base_url()?>index.php/curso">Curso</a></li>
            <li class="divider"></li>
            <li><a href="<?php echo base_url()?>index.php/disciplina">Disciplina</a></li>
            <li><a href="<?php echo base_url()?>index.php/turma">Turma</a></li>
            <li><a href="<?php echo base_url()?>index.php/horario">Horario</a></li>
            <li class="divider"></li>
            <li><a href="<?php echo base_url()?>index.php/aluno">Aluno</a></li>
          </ul>
        </li>
        <li class="dropdown">
			<a href="<?php echo base_url()?>index.php/matricula">Matr&iacute;cula</a>
        </li>
        <li class="dropdown">
			<a href="<?php echo base_url()?>index.php/frequencia">Frequ&ecirc;ncia</a>
        </li>
      </ul>
    </div>
  </div>
</nav>
