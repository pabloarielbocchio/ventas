   <!-- Fixed navbar -->
    <div class="navbar navbar-inverse navbar-fixed-top" role="navigation">
      <div class="container">
        <div class="navbar-header">
          <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target=".navbar-collapse">
            <span class="sr-only">Toggle navigation</span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
          </button>
          <a class="navbar-brand" href="#">Informática DP</a>
        </div>
        <div class="navbar-collapse collapse">
          <ul class="nav navbar-nav">
            <li class="active"><a href="#">Inicio</a></li>
            <li><?php echo $this->Html->link('Productos', array('controller' => 'productos', 'action' => 'index')); ?></li>
            <li><a href="tags/add">Software</a></li>
            <li class="dropdown">
              <a href="#" class="dropdown-toggle" data-toggle="dropdown">Hardware <span class="caret"></span></a>
              <ul class="dropdown-menu" role="menu">
                <li><a href="#">Buscar</a></li>
                <li><a href="#">Monitores</a></li>
                <li><a href="#">Notebooks</a></li>
                <li><a href="#">Accesorios</a></li>
                <li><a href="#">Perifericos</a></li>
                <li class="divider"></li>
                <li class="dropdown-header">Nav header</li>
                <li><a href="#">Separated link</a></li>
                <li><a href="#">One more separated link</a></li>
              </ul>
            </li>

          </ul>
        </div><!--/.nav-collapse -->
      </div>
    </div>