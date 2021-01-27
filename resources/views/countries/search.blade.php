<!DOCTYPE html>
<html>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <meta name="description" content="Simple CMS" />
    <meta name="author" content="Sheikh Heera" />
    <link rel="shortcut icon" href={{ asset("favicon.png") }} />

    <title>Login</title>

    <!-- Bootstrap core CSS -->
    <link href = {{ asset("assets/bootstrap/css/bootstrap.css") }} rel="stylesheet" />

</head>
<body>
<div class="container">
    <div class="row">
        @if ($errors->any())
            @foreach ($errors->all() as $error)
                <div>{{$error}}</div>
            @endforeach
        @endif
    </div>
    <div class="row">
        @if (session('status'))
            <div class="alert alert-success">
                {{ session('status') }}
            </div>
        @endif
        <div class="col-md-4 col-md-offset-4">
            <div class="panel panel-default">
                <div class="panel-heading">
                    <h3 class="panel-title">Please enter a number greater than 3</h3>
                </div>
                <div class="panel-body">
                    <form name="login" id="login" action="{{ route('countries') }}" method="get" role="form">
                        <fieldset>
                            <div class="form-group">
                                <input class="form-control" placeholder="Country Name Length" name="country_name_length" type="text" size="20" />
                            </div>
                            <input class="btn btn-lg btn-success btn-block" type="submit" value="Search">
                        </fieldset>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
</body>
</html>
