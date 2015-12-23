<div class="container-fluid">
    <div class="row-fluid">
        <div class="col-xs-10">
            <img class="img-responsive pull-left" src="{{ URL::asset('custom/img/logo.png') }}" alt="Logo" id="logo"/>
            <h1>Lutin Manager</h1>
            <p class="subtitle">Et Joyeux Noël à  tous!</p>
        </div>
        <div class="col-xs-2 text-center">
            <div class="well well-sm">
                <h6>Bonjour <span class="text-primary">{{ Auth::user()->name }}</span></h6>
                <a href="{{ URL::route('auth::logout') }}" class="btn btn-danger" role="button"><i class="fa fa-power-off"></i></a>
            </div>
        </div>
    </div>
    <div class="row-fluid">
        <div class="col-xs-12">
            <nav class="navbar navbar-default">
                <div class="container-fluid">
                    <div class="navbar-header">
                        <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#bs-example-navbar-collapse">
                            <span class="sr-only">Toggle navigation</span>
                            <span class="icon-bar"></span>
                            <span class="icon-bar"></span>
                            <span class="icon-bar"></span>
                        </button>
                    </div>
                    <div class="collapse navbar-collapse" id="bs-example-navbar-collapse">
                        <ul class="nav navbar-nav">
                            <li @if(Route::getCurrentRoute()->getName() == 'orders::viewAll') class="active" @endif>
                                <a href="{{ URL::route('orders::viewAll') }}">Liste des Commandes</a>
                            </li>
                            <li @if(Route::getCurrentRoute()->getName() == 'items::viewAll') class="active" @endif>
                                <a href="{{ URL::route('items::viewAll') }}">Gestion des Articles</a>
                            </li>
                            <li @if(Route::getCurrentRoute()->getName() == 'users::viewAll') class="active" @endif>
                                <a href="{{ URL::route('users::viewAll') }}">Gestion des Employés</a>
                            </li>
                            <li @if(Route::getCurrentRoute()->getName() == 'orders::deliveryNotes') class="active" @endif>
                                <a href="{{ URL::route('orders::deliveryNotes') }}">Archives</a>
                            </li>
                           {{-- 
                            <li @if(Route::getCurrentRoute()->getName() == '') class="active" @endif>
                                <a href="{{ URL::route('') }}">Statistiques</a>
                            </li>
                            --}}
                        </ul>
                    </div>
                </div>
            </nav>
        </div>
    </div>
</div>
