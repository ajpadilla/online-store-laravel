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
        <a href="/" class="btn btn-success">Back</a>
        <table class="table">
            <thead>
            <tr>
                <th scope="col">#</th>
                <th scope="col">Country</th>
                <th scope="col">Population</th>
                <th scope="col">Total Population</th>
                <th scope="col">Percent Population</th>
            </tr>
            </thead>
            <tbody>
            @forelse ($counties as $country)
                <tr>
                    <th scope="row">{{ $country->id }}</th>
                    <td>{{ $country->name }}</td>
                    <td>{{ $country->population }}</td>
                    <td>{{ $country->total_population }}</td>
                    <td>{{ $country->percent_population }}</td>
                </tr>
            @empty
                <tr>
                    <td>No Countries</td>
                </tr>
            @endforelse
            </tbody>
        </table>
    </div>
</div>
</body>
</html>
