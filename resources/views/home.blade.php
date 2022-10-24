@extends('layouts.app')

@section('content')
    @if(Auth::user()->type === 'admin')
        <div class="container-fluid">
            <!-- Button trigger modal -->
            <button type="button" class="btn btn-primary float-end"  id="btnAddVoiture">
                Launch demo modal
            </button>
            <div class="container d-flex flex-wrap pt-5 justify-content-center">
                @foreach($voiture as $data)
                <div class="col-12 col-lg-3 col-xxl-4 d-flex flex-column  p-2 rounded m-2 blockVoiture" style="background: #e4e4e4" data-voiture="{{$data->id}}" data-db="voiture">
                    <img src="{{asset("/storage/".$data->image)}}" alt="{{asset("/storage/".$data->image)}}" class="rounded">
                    <p class="text-center my-1">Marque : {{$data->marque}}</p>
                    <p class="text-center m-0">Model : {{$data->model}}</p>
                    <a  class="btn btn-primary w-75 align-self-center mt-3 btn-info-car" href="{{route('voitureData', $data->id) }}">
                        En savoir plus
                    </a>
                    <button class="btn btn-danger delButton w-75 mt-2 align-self-center">Supprimer</button>
                </div>
                @endforeach
            </div>
        </div>
    @else
        <div class="container d-flex flex-column">
            <div class="col-auto d-flex position-relative">
                <i class="fa-solid fa-magnifying-glass position-absolute" style="bottom: 7.5px"></i>
                <div class="d-flex flex-column">
                    <label for="searchBar">Retrait et retour</label>
                    <input id="searchBar" type="search" autocomplete="off" placeholder="Trouver une agence" class="border-0 w-100 bg-light text-dark border-bottom border-2 border-dark ps-3" style="outline: none">
                </div>
                <div class="d-flex flex-column">
                    <label for="dateTime">Date de debut et de fin</label>
                    <input type="text" id="dateTime">
                </div>
            </div>
        </div>

    @endif
@endsection
