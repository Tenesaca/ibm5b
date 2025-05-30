<nav class="navbar navbar-expand-lg navbar-dark bg-primary mb-4">
    <div class="container">
        <a class="navbar-brand" href="/ibm5b/public">
            <i class="fas fa-users me-2"></i>Sistema de Personas
        </a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarNav">
            <ul class="navbar-nav me-auto">
                <li class="nav-item">
                    <a class="nav-link" href="/ibm5b/public/persona">
                        <i class="fas fa-user-friends me-1"></i> Personas
                    </a>
                </li>
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-bs-toggle="dropdown">
                        <i class="fas fa-list-alt me-1"></i> Catálogos
                    </a>
                    <ul class="dropdown-menu">
                        <li>
                            <a class="dropdown-item" href="/ibm5b/public">
                                <i class="fas fa-venus-mars me-1"></i> Sexos
                            </a>
                        </li>
                        <li>
                            <a class="dropdown-item" href="/ibm5b/public/estado-civil">
                                <i class="fas fa-heart me-1"></i> Estados Civiles
                            </a>
                        </li>
                    </ul>
                </li>
            </ul>
            <form class="d-flex" action="/ibm5b/public/persona" method="GET">
                <div class="input-group">
                    <input class="form-control" type="search" name="search" placeholder="Buscar persona...">
                    <button class="btn btn-light" type="submit">
                        <i class="fas fa-search"></i>
                    </button>
                </div>
            </form>
        </div>
    </div>
</nav>