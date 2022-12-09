
<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }}</title>

    <!-- Scripts -->
    <script src="{{asset('js/fontawesome.js')}}" defer></script>
    @if(\Illuminate\Support\Facades\Auth::user())
        @if(\Illuminate\Support\Facades\Auth::user()->type === 'admin')
            <script src="{{ asset('js/app.js') }}" defer></script>
            <link href="{{ asset('css/dataTables.bootstrap5.css') }}" rel="stylesheet">
            @else
                <script src="{{asset('js/main.js')}}" defer></script>
        @endif
    @endif


    <!-- Fonts -->
    <link rel="dns-prefetch" href="//fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css?family=Nunito" rel="stylesheet">

    <!-- Styles -->
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
    <link href="{{ asset('css/style.css') }}" rel="stylesheet">
    <link href="{{ asset('css/all.css') }}" rel="stylesheet">

    <link href="{{ asset('css/CustomScrollbar.css') }}" rel="stylesheet">
</head>
<body>
    <div id="app">
        <nav class="navbar sticky-top navbar-expand-md navbar-light bg-white shadow-sm">
            <div class="container">
                <a class="navbar-brand" href="{{ url('/home') }}">
                   Home
                </a>

                <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="{{ __('Toggle navigation') }}">
                    <span class="navbar-toggler-icon"></span>
                </button>

                <div class="collapse navbar-collapse" id="navbarSupportedContent">
                    <!-- Left Side Of Navbar -->
                    @if(\Illuminate\Support\Facades\Auth::user())
                        @if(\Illuminate\Support\Facades\Auth::user()->type === 'admin')
                            <ul class="navbar-nav me-auto">
                                <a href="{{url('/entretiens')}}" class="mx-2 text-dark text-decoration-none">Entretiens</a>
                                <a href="{{url('/assurance')}}" class="mx-2 text-dark text-decoration-none">Assurance</a>
                                <a href="{{url('/reparations')}}" class="mx-2 text-dark text-decoration-none">Reparation</a>
                                <a href="{{url('/consommation')}}" class="mx-2 text-dark text-decoration-none">Consommation</a>
                                <a href="{{url('/agence')}}" class="mx-2 text-dark text-decoration-none">Agence</a>
                                <a href="{{url('/location')}}" class="mx-2 text-dark text-decoration-none">Location</a>
                            </ul>
                            @else
                            <ul class="navbar-nav me-auto">
                                <a href="{{url('/location')}}" class="mx-2 text-dark text-decoration-none">Mes locations</a>
                            </ul>
                        @endif
                    @endif
                    <!-- Right Side Of Navbar -->
                    <ul class="navbar-nav ms-auto">
                        <!-- Authentication Links -->
                        @guest
                            @if (Route::has('login'))
                                <li class="nav-item">
                                    <a class="nav-link" href="{{ route('login') }}">{{ __('Login') }}</a>
                                </li>
                            @endif

                            @if (Route::has('register'))
                                <li class="nav-item">
                                    <a class="nav-link" href="{{ route('register') }}">{{ __('Register') }}</a>
                                </li>
                            @endif
                        @else
                            <li class="nav-item dropdown">
                                @if(\Illuminate\Support\Facades\Auth::user())
                                <a id="navbarDropdown" class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false" v-pre>
                                    {{ \Illuminate\Support\Facades\Auth::user()->name }}
                                </a>
                                @endif
                                <div class="dropdown-menu dropdown-menu-end" aria-labelledby="navbarDropdown">
                                    <a class="dropdown-item" href="{{url('/profil')}}" role="button">Profil</a>

                                    <a class="dropdown-item" href="{{ route('logout') }}"
                                       onclick="event.preventDefault();
                                                     document.getElementById('logout-form').submit();">
                                        {{ __('Déconnexion') }}
                                    </a>
                                    <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                                        @csrf
                                    </form>
                                </div>
                            </li>
                        @endguest
                    </ul>
                </div>
            </div>
        </nav>

        <main>
            @yield('content')
        </main>
    </div>
    <div class="modal fade" id="AddModal" tabindex="-1" data-bs-backdrop="static" data-bs-keyboard="false">
        <div class="modal-dialog modal-xl">
            <div class="modal-content">
                <div class="modal-header">
                    <h3 class="modal-title" id="VoitureModalLabel">Modal </h3>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="col-6 align-self-center modal-body d-flex flex-column">

                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Annuler</button>
                    <button type="submit" class="btn btn-primary btnModal">Creer</button>
                </div>
            </div>
        </div>
    </div>

        <div class="toast-container position-absolute start-0 p-3 top-0 mt-5" >

            <!-- Then put toasts within -->
            <div id="saveToast" class="toast" role="alert">
                <div class="toast-header">
                    <strong class="me-auto">Enregistrement des données</strong>
                    <button type="button" class="btn-close" data-bs-dismiss="toast" aria-label="Close"></button>
                </div>
                <div class="toast-body">
                    Les données ont été enregistrées
                </div>
            </div>
            <div id="toastSupp" class="toast" role="alert">
                <div class="toast-header">
                    <strong class="me-auto">Suppression données</strong>
                    <button type="button" class="btn-close" data-bs-dismiss="toast" aria-label="Close"></button>
                </div>
                <div class="toast-body">
                    Les données ont été supprimé
                </div>
            </div>
            <div id="toastLocation" class="toast" role="alert">
                <div class="toast-header">
                    <strong class="me-auto">Location véhicule</strong>
                    <button type="button" class="btn-close" data-bs-dismiss="toast" aria-label="Close"></button>
                </div>
                <div class="toast-body">
                    La location a été réalié avec succès.
                </div>
            </div>
            <div id="toastAnnul" class="toast" role="alert">
                <div class="toast-header">
                    <strong class="me-auto">Annulation de location</strong>
                    <button type="button" class="btn-close" data-bs-dismiss="toast" aria-label="Close"></button>
                </div>
                <div class="toast-body">
                    La location a été annuler.
                </div>
            </div>

            <div id="toastUpdateProfil" class="toast" role="alert">
                <div class="toast-header">
                    <strong class="me-auto">Modification de données </strong>
                    <button type="button" class="btn-close" data-bs-dismiss="toast" aria-label="Close"></button>
                </div>
                <div class="toast-body">
                    Les données ont été modifié.
                </div>
            </div>
        </div>


    <div class="modal" tabindex="-1" id="delModal" data-bs-backdrop="static">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Êtes-vous sûr de vouloir supprimer</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Annuler</button>
                    <button type="button" class="btn btn-primary" id="btnDelModal">Supprimer</button>
                </div>
            </div>
        </div>
    </div>
    <div class="modal" tabindex="-1" id="annulModal" data-bs-backdrop="static">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Êtes-vous sûr de vouloir Annuler ?</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Annuler</button>
                    <button type="button" class="btn btn-primary" id="btnAnnulModal">Valider</button>
                </div>
            </div>
        </div>
    </div>
    <div class="modal fade" id="deluser" aria-hidden="true" aria-labelledby="exampleModalToggleLabel2" tabindex="-1">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Êtes-vous sûr de vouloir supprimer votre compte ?</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-footer">
                    <button class="btn btn-primary" data-bs-target="#exampleModalToggle" data-bs-toggle="modal" data-bs-dismiss="modal">Annuler</button>
                    <button type="button" class="btn btn-primary" id="btnAnnulModal" onclick="event.preventDefault();
                                                     document.getElementById('delProfil-form').submit();">
                        Valider
                    </button>
                    <form id="delProfil-form" action="{{route('delprofil') }}" method="POST" class="d-none">
                        @csrf
                    </form>
                </div>
            </div>
        </div>
    </div>
    <div class="modal fade" id="modifEmailmodal" aria-hidden="true" aria-labelledby="exampleModalToggleLabel" tabindex="-1">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalToggleLabel">Mon profil</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        @if(\Illuminate\Support\Facades\Auth::user())
                            <div class="flex-column w-100 d-flex">
                                <label for="emailProfil">Email :</label>
                                <input id="emailProfil" type="email" class="form-control emailProfil" name="email" value="{{auth()->user()->email}}" required autocomplete="email" autofocus>
                                <div id="errorEmail" class="errormsg">

                                </div>
                                <label for="passwordE">Mot de passe actuel :</label>
                                <input id="passwordE" type="password" class="form-control passwordProfil" name="password" required autocomplete="current-password">
                                <div class="errormsg errorPassword">

                                </div>
                            </div>
                        @endif
                    </div>
                    <div class="modal-footer">
                        <button class="btn btn-primary" data-bs-dismiss="modal">Annuler</button>
                        <button class="btn btn-outline-success mx-2" type="button" id="btnProfilEmail">valider</button>
                    </div>
            </div>
        </div>
    </div>
    <div class="modal fade" id="modifNamemodal" aria-hidden="true" aria-labelledby="exampleModalToggleLabel" tabindex="-1">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalToggleLabel">Changer prenom</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        @if(\Illuminate\Support\Facades\Auth::user())
                            <div class="flex-column w-100 d-flex">
                                <label for="nameProfil">Prenom :</label>
                                <input id="nameProfil" type="text" class="form-control" name="name" value="{{ Auth::user()->name }}" required autocomplete="name" autofocus>
                                <div id="errorName" class="errormsg">

                                </div>
                                <label for="password">Mot de passe actuel :</label>
                                <input id="password" type="password" class="form-control passwordProfil" name="password" required autocomplete="current-password">
                                <div class="errormsg errorPassword">

                                </div>
                            </div>
                        @endif
                    </div>
                    <div class="modal-footer">
                        <button class="btn btn-primary" data-bs-dismiss="modal">Annuler</button>
                        <button class="btn btn-outline-success mx-2" id="btnProfilName">valider</button>
                    </div>
            </div>
        </div>
    </div>

    <div class="modal fade" id="modifPasswordmodal" aria-hidden="true" aria-labelledby="exampleModalToggleLabel" tabindex="-1">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalToggleLabel">Changer de mot de passe</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        @if(\Illuminate\Support\Facades\Auth::user())
                            <div class="flex-column w-100 d-flex">
                                <label for="password">Mot de passe actuel :</label>
                                <input id="password" type="password" class="form-control passwordProfil" name="password" required autocomplete="current-password">
                                <div class="errormsg errorPassword">

                                </div>
                                <label for="newPassword">Nouveau mot de passe :</label>
                                <input id="newPassword" type="password" class="form-control" name="newPassword" required>
                                <div class="errormsg errorNewPassword">

                                </div>
                            </div>
                        @endif
                    </div>
                    <div class="modal-footer">
                        <button class="btn btn-primary" data-bs-dismiss="modal">Annuler</button>
                        <button class="btn btn-outline-success mx-2" id="btnProfilPassword">valider</button>
                    </div>
            </div>
        </div>
    </div>

</body>
</html>
