<div class="row-fluid">
    <div class="col-xs-10">
        <img class="img-responsive pull-left" src="{{ URL::asset('custom/img/logo.png') }}" alt="Logo" id="logo"/>
        <h1>Lutin Management</h1>
        <h6><em>Et Joyeux Noël à  tous!</em></h6>
    </div>
    <div class="col-xs-2 text-center">
        <div class="well well-sm">
            <h6>Bonjour <span class="text-primary">{{ Auth::user()->name }}</span></h6>
            <a href="{{ URL::route('auth::logout') }}" class="btn btn-danger" role="button"><i class="fa fa-power-off"></i></a>
        </div>
    </div>

</div>