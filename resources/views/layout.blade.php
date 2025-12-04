<!doctype html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <title>Soundclown</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet"
          integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"
            integrity="sha384-ka7Sk0Gln4gmtz2MlQnikT1wXgYsOg+OMhuP+IlRH9sENBO0LRn5q+8nbTov4+1p"
            crossorigin="anonymous"></script>
    <style>
        a{
            text-decoration: none;
        }
        .is-invalid{
            color: red;
        }
    </style>
</head>
<body class="d-flex flex-column h-100">

@include('navbar')

@include('error')
<div class="container">
    <div class="row">
        <div class="col-lg-3 col-sm-1"></div>
        <div class="col-lg-6 col-sm-10 d-flex flex-column align-items-center">
            @section('content')
            @show
        </div>
        <div class="col-lg-3 col-sm-1"></div>
    </div>
</div>


</body>
</html>
