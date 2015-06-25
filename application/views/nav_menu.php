<nav class="navbar navbar-default navbar-fixed-top" role="navigation">
  <div class="container">
    <div class="navbar-header">
      <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#bs-navbar-collapse">
        <span class="sr-only">Toggle navigation</span>
        <span class="icon-bar"></span>
        <span class="icon-bar"></span>
        <span class="icon-bar"></span>
      </button>
	  <a class="navbar-brand" href="<?php echo base_url()?>">SGEAP</a>
    </div>    
    <div class="collapse navbar-collapse" id="bs-navbar-collapse">
	  <ul class="nav navbar-nav">
		<li class="dropdown">
          <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false">Administra&ccedil;&atilde;o<span class="caret"></span></a>
          <ul class="dropdown-menu" role="menu">
            <li><a href="<?php echo base_url()?>index.php/pessoa">Pessoa</a></li>
            <li><a href="<?php echo base_url()?>index.php/perfil">Perfil</a></li>
            <li><a href="<?php echo base_url()?>index.php/tela">Tela</a></li>
          </ul>
        </li>
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
        <li class="dropdown">
          <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false">Relat&oacute;rios<span class="caret"></span></a>
          <ul class="dropdown-menu" role="menu">
            <li><a href="<?php echo base_url()?>index.php/turma/listaPresenca">Lista de Presen&ccedil;a</a></li>
          </ul>
        </li>
        </li>
        <li class="dropdown">
			<a href="<?php echo base_url()?>index.php/matricula">Matr&iacute;cula</a>
        </li>
        <li class="dropdown">
			<a href="<?php echo base_url()?>index.php/frequencia">Frequ&ecirc;ncia</a>
        </li>
        <li class="dropdown">
			<a href="<?php echo base_url()?>index.php/login/logoff">Sair</a>
        </li>
      </ul>
    </div>
  </div>
</nav>
