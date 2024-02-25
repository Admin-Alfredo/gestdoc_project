<link rel="stylesheet" href="/bootstrap/css/bootstrap.min.css">
<link rel="stylesheet" href="/css/form.css">

@if ($mensagem = Session::get('erro'))
    <div class="alert alert-warning" role="alert">
        {{ $mensagem }}
    </div>
@endif

<form method="POST" action="{{ route('auth.login') }}" class="d-flex justify-content-center mt-5">
    @csrf
    <div class="col-md-3">
        <div class="form-row ">
            <div class="form-group col-sm-12">
                <label>Email</label>
                <input type="email" name="email" class="form-control form-control-lg">
            </div>
            <div class="col-sm-12">
                @if (errors->has('email'))
                    <span>{{ errors - first('email') }}</span>
                @else
                    <span>&nbsp;&nbsp;&nbsp;</span>
                @endif
            </div>
        </div>
        <div class="form-row">
            <div class="form-group col-sm-12">
                <label>Email</label>
                <input type="password" name="senha" class="form-control form-control-lg">
            </div>
            <div class="col-sm-12">
                @if (errors->has('senha'))
                    <span>{{ errors - first('senha') }}</span>
                @else
                    <span>&nbsp;&nbsp;&nbsp;</span>
                @endif
            </div>
        </div>
        <div class="form-row">
            <div class="form-group col-sm-12">
                <input type="submit" class="form-control form-control-lg btn btn-primary btn-lg">
            </div>
        </div>
    </div>
</form>
