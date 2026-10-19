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
          <li class="nav-item">
            <a class="nav-link" href="index.php?pagina=produtos">Produtos</a>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="index.php?pagina=transporte">Transporte</a>
          </li>
          <li class="nav-item">
            <button class="nav-link" type="button" data-bs-toggle="menu" aria-expanded="false">
              Menu link
            </button>
            <div class="menu">
              <a class="menu-item" href="#">Action</a>
              <a class="menu-item" href="#">Another action</a>
              <a class="menu-item" href="#">Something else here</a>
            </div>
          </li>
        </ul>
      </div>
    </dialog>
    <form class="d-flex" role="search">
      <input class="form-control me-2" type="search" placeholder="Search" aria-label="Search"/>
      <button class="btn-outline theme-success" type="submit">Search</button>
    </form>
  </div>
</nav>