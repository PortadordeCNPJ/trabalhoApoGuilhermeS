<nav class="navbar lg:navbar-expand bg-1 fg-2">
  <div class="container-fluid">
    <a class="navbar-brand" href="#">TranspTech</a>
    <button class="btn-icon navbar-toggler" type="button" data-bs-toggle="drawer" data-bs-target="#navbarNavMenu" aria-controls="navbarNavMenu" aria-expanded="false" aria-label="Toggle navigation">
      <span class="navbar-toggler-icon" aria-hidden="true"></span>
    </button>
    <dialog class="drawer drawer-end" tabindex="-1" id="navbarNavMenu" aria-labelledby="navbarNavMenuLabel">
      <div class="drawer-header">
        <h5 class="drawer-title" id="navbarNavMenuLabel">Menu</h5>
        <button type="button" class="btn-close" data-bs-dismiss="drawer" aria-label="Close"></button>
      </div>
      <div class="drawer-body">
        <ul class="navbar-nav">
          <li class="nav-item">
            <a class="nav-link active" aria-current="page" href="index.php?pagina=home">Home</a>
          </li>
          <?php //if ($_SESSION['tipo_usuario'] === "admin") : 
          ?>
          <li class="nav-item">
            <button class="nav-link" type="button" data-bs-toggle="menu" aria-expanded="false">
              Menu de Admistrador
            </button>
            <div class="menu">
              <a class="menu-item" href="index.php?pagina=transportador">Cadastrar Transportadores</a>
              <a class="menu-item" href="index.php?pagina=cadastroProdutos">Cadastrar Produtos</a>
              <a class="menu-item" href="index.php?pagina=criarUsuarios">Cadastrar Usuário</a>
              <a class="menu-item" href="index.php?pagina=endereco">Cadastrar Endereco</a>
              <a class="menu-item" href="index.php?pagina=frete">Cadastrar Frete</a>
            </div>
          </li>
          <?php //endif; 
          ?>
        </ul>
      </div>
    </dialog>
    <a href="index.php?pagina=logout" class="tt-logout">
      <i class="bi bi-box-arrow-right"></i>
      Sair
    </a>
  </div>
</nav>