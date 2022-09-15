<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
</head>
<body>
<div class="container mt-5">

    <!-- Success message -->
    @if(Session::has('success'))
        <div class="alert alert-success">
            {{Session::get('success')}}
        </div>
    @endif

    <form method="post" action="{{ action('App\Http\Controllers\HomeController@createVoitureForm') }}" enctype="multipart/form-data">

        @csrf

        <div class="form-group">
            <label>Marque</label>
            <input type="text" class="form-control {{ $errors->has('marque') ? 'error' : '' }}" name="marque" id="marque">

            <!-- Error -->
            @if ($errors->has('marque'))
                <div class="error">
                    {{ $errors->first('marque') }}
                </div>
            @endif
        </div>

        <div class="form-group">
            <label>model</label>
            <input type="text" class="form-control {{ $errors->has('model') ? 'error' : '' }}" name="model" id="model">

            @if ($errors->has('model'))
                <div class="error">
                    {{ $errors->first('model') }}
                </div>
            @endif
        </div>

        <div class="form-group">
            <label>circulation</label>
            <input type="text" class="form-control {{ $errors->has('circulation') ? 'error' : '' }}" name="circulation"
                   id="circulation">

            @if ($errors->has('circulation'))
                <div class="error">
                    {{ $errors->first('circulation') }}
                </div>
            @endif
        </div>

        <div class="form-group">
            <label>Immatriculation</label>
            <input type="text" class="form-control {{ $errors->has('immatriculation') ? 'error' : '' }}" name="immatriculation"
                   id="immatriculation">

            @if ($errors->has('immatriculation'))
                <div class="error">
                    {{ $errors->first('immatriculation') }}
                </div>
            @endif
        </div>

        <div class="form-group">
            <label>Carburant</label>
            <input type="text" class="form-control {{ $errors->has('carburant') ? 'error' : '' }}" name="carburant" id="carburant">

            @if ($errors->has('carburant'))
                <div class="error">
                    {{ $errors->first('carburant') }}
                </div>
            @endif
        </div>
        <div class="form-group">
            <label>status</label>
            <input type="text" class="form-control {{ $errors->has('status') ? 'error' : '' }}" name="status" id="status">

            @if ($errors->has('status'))
                <div class="error">
                    {{ $errors->first('status') }}
                </div>
            @endif
        </div>
        <div class="form-group">
            <label>Puissance</label>
            <input type="text" class="form-control {{ $errors->has('puissance') ? 'error' : '' }}" name="puissance" id="puissance">


            @if ($errors->has('puissance'))
                <div class="error">
                    {{ $errors->first('puissance') }}
                </div>
            @endif
        </div>
        <div class="form-group">
            <label>Image</label>
            <input type="file" class="form-control {{ $errors->has('file') ? 'error' : '' }}" name="file" id="file">

            @if ($errors->has('file'))
                <div class="error">
                    {{ $errors->first('file') }}
                </div>
            @endif
        </div>

        <input type="submit" name="send" value="Submit" class="btn btn-dark btn-block">
    </form>
</div>

