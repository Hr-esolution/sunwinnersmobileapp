<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>SUNWINNERS - {{ isset($title) ? $title : 'Dashboard' }}</title>

    <!-- Bootstrap 5 CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Bootstrap Icons -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.0/font/bootstrap-icons.css">
    
    <!-- Styles personnalisés -->
    <style>
        body {
            padding-top: 56px;
        }
        .sidebar {
            min-height: calc(100vh - 56px);
        }
        .main-content {
            min-height: calc(100vh - 56px);
        }
    </style>
</head>
<body>
    <!-- En-tête de navigation -->
    <nav class="navbar navbar-expand-md navbar-dark bg-primary fixed-top">
        <div class="container-fluid">
            <a class="navbar-brand" href="{{ url('/') }}">
                SUNWINNERS
            </a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="{{ __('Toggle navigation') }}">
                <span class="navbar-toggler-icon"></span>
            </button>

            <div class="collapse navbar-collapse" id="navbarSupportedContent">
                <!-- Liens de navigation -->
                <ul class="navbar-nav me-auto">
                    <li class="nav-item">
                        <a class="nav-link {{ request()->is('/') ? 'active' : '' }}" href="{{ url('/') }}">Accueil</a>
                    </li>
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle" href="#" id="usersDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                            Utilisateurs
                        </a>
                        <ul class="dropdown-menu" aria-labelledby="usersDropdown">
                            <li><a class="dropdown-item" href="{{ route('users.index') }}">Liste des utilisateurs</a></li>
                            <li><a class="dropdown-item" href="{{ route('users.create') }}">Créer un utilisateur</a></li>
                        </ul>
                    </li>
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle" href="#" id="quotesDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                            Devis
                        </a>
                        <ul class="dropdown-menu" aria-labelledby="quotesDropdown">
                            <li><a class="dropdown-item" href="{{ route('quotes.index') }}">Liste des devis</a></li>
                            <li><a class="dropdown-item" href="{{ route('quotes.create') }}">Créer un devis</a></li>
                        </ul>
                    </li>
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle" href="#" id="projectsDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                            Projets
                        </a>
                        <ul class="dropdown-menu" aria-labelledby="projectsDropdown">
                            <li><a class="dropdown-item" href="{{ route('projects.index') }}">Liste des projets</a></li>
                            <li><a class="dropdown-item" href="{{ route('projects.create') }}">Créer un projet</a></li>
                        </ul>
                    </li>
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle" href="#" id="subsidiesDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                            Subventions
                        </a>
                        <ul class="dropdown-menu" aria-labelledby="subsidiesDropdown">
                            <li><a class="dropdown-item" href="{{ route('subsidies.index') }}">Liste des subventions</a></li>
                            <li><a class="dropdown-item" href="{{ route('subsidies.create') }}">Créer une subvention</a></li>
                        </ul>
                    </li>
                </ul>

                <!-- Menu utilisateur -->
                <ul class="navbar-nav ms-auto">
                    @guest
                        @if (Route::has('login'))
                            <li class="nav-item">
                                <a class="nav-link" href="{{ route('login') }}">Connexion</a>
                            </li>
                        @endif

                        @if (Route::has('register'))
                            <li class="nav-item">
                                <a class="nav-link" href="{{ route('register') }}">Inscription</a>
                            </li>
                        @endif
                    @else
                        <li class="nav-item dropdown">
                            <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                                {{ Auth::user()->name }}
                            </a>

                            <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="navbarDropdown">
                                <li><a class="dropdown-item" href="{{ route('logout') }}"
                                       onclick="event.preventDefault();
                                                     document.getElementById('logout-form').submit();">
                                        Déconnexion
                                    </a>

                                    <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                                        @csrf
                                    </form>
                                </li>
                            </ul>
                        </li>
                    @endguest
                </ul>
            </div>
        </div>
    </nav>

    <!-- Contenu principal -->
    <main class="container-fluid">
        <div class="row">
            <div class="col-md-12">
                @yield('content')
            </div>
        </div>
    </main>

    <!-- Scripts Bootstrap 5 -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    
    <!-- Scripts personnalisés -->
    @stack('scripts')
</body>
</html>