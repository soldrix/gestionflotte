@extends('layouts.app')

@section('content')
<div class="container-fluid">
    <!-- Button trigger modal -->
    <button type="button" class="btn btn-primary float-end"  id="btnAddVoiture">
        Launch demo modal
    </button>
    <div class="container d-flex flex-wrap pt-5 justify-content-center">
        @foreach($voiture as $data)
        <div class="col-2 d-flex flex-column  p-2 rounded m-2 blockVoiture" style="background: #e4e4e4" data-voiture="{{$data->id}}" >
            <img src="{{asset("/storage/".$data->image)}}" alt="{{asset("/storage/".$data->image)}}" class="rounded">
            <p class="text-center">{{$data->model}}</p>
            <a  class="btn btn-primary w-75 align-self-center mt-3 btn-info-car" href="{{route('voitureData', $data->id) }}">
                En savoir plus
            </a>
            <button class="btn btn-danger delButon w-75 mt-2 align-self-center">Supprimer</button>
        </div>
        @endforeach
    </div>
</div>
@endsection
