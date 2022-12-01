@extends('layouts.app')

@section('content')
    @if(Auth::user()->type === 'admin')
        <div class="container-fluid py-4">
            <!-- Button trigger modal -->
            <button type="button" class="btn btn-primary float-end"  id="btnAddVoiture">
                Launch demo modal
            </button>
            <div class="col-9 d-flex flex-wrap pt-5 justify-content-center mx-auto containerVoiture">
                @foreach($voiture as $data)
                    <div class="col-12 col-lg-3 col-xxl-2 d-flex flex-column  p-2 rounded m-2 blockVoiture" style="background: #e4e4e4" data-voiture="{{$data->id}}" data-db="voiture">
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
        <div class="container-fluid px-0" style="background-image: url('{{asset("/images/fondHome.png")}}');background-repeat: no-repeat;background-size: cover;min-height: 800px;height: 50vh ">
            <div class="fondHome position-relative py-4">
                <div class="container px-0 pt-5 h-75">
                    <div class="col-auto d-flex position-relative bg-light p-2">
                        <i class="fa-solid fa-magnifying-glass position-absolute" style="bottom: 18.5px"></i>
                        <div class="d-flex flex-column w-100 position-relative">
                            <label for="searchBar" class="text-opacity-50 text-dark mb-2">Retrait et retour</label>
                            <input id="searchBar" type="search" autocomplete="off" placeholder="Trouver une agence" class="w-100 text-dark inputSearch ps-4" style="outline: none">
                            {{--list agence--}}
                            <div id="divSearch" class="col-12 py-2 px-4  overflow-auto">

                            </div>
                        </div>
                    </div>
                    <div class="position-absolute vw-100 bottom-0 p-5 d-flex justify-content-around container" >
                        <div class="col-auto mx-3">
                            <h2 class="text-white titreHome">Véhicules Premium</h2>
                            <p class="text-white textHome">Sentez-vous comme un VIP <br> où que vous alliez avec nos voitures.</p>
                        </div>
                        <div class="col-auto mx-3">
                            <h2 class="text-white titreHome">Nouvelles voitures</h2>
                            <p class="text-white textHome">Ne cherchez pas ailleurs <br> les véhicules les plus récents.</p>
                        </div>
                        <div class="col-auto mx-3">
                            <h2 class="text-white titreHome">Entièrement numérique</h2>
                            <p class="text-white textHome">Évitez les longues files d'attente au guichet.</p>
                        </div>
                    </div>
                </div>
                <div class="col-auto">

                </div>
            </div>
        </div>
    @endif
@endsection
