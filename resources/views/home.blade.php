@extends('layouts.app')

@section('content')
    @if(Auth::user()->type === 'admin')
        <div class="container-fluid">
            <!-- Button trigger modal -->
            <button type="button" class="btn btn-primary float-end"  id="btnAddVoiture">
                Launch demo modal
            </button>
            <div class="col-9 d-flex flex-wrap pt-5 justify-content-center mx-auto">
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
        <div class="container d-flex flex-column">
            {{--div agence search--}}
            <div class="col-auto d-flex position-relative bg-light">
                <i class="fa-solid fa-magnifying-glass position-absolute" style="bottom: 7.5px"></i>
                <div class="d-flex flex-column w-50 position-relative">
                    <label for="searchBar" class="text-opacity-50 text-dark mb-2">Retrait et retour</label>
                    <input id="searchBar" type="search" autocomplete="off" placeholder="Trouver une agence" class="w-100 text-dark inputSearch ps-4" style="outline: none">
                    {{--list agence--}}
                    <div id="divSearch" class="col-12 py-2 px-4  overflow-auto">
                        @foreach($agence as $datas)
                        <button class="bg-transparent border-0 text-start my-2 w-100"> <h2 class="m-0">{{$datas->ville.' '.$datas->rue}}</h2></button>
                        @endforeach
                    </div>
                </div>

                <button class="btn btn-outline-primary" id="btnOffre">
                    Voir les offres
                </button>
            </div>
            {{--div filter voiture--}}
            <div class='divFilter px-2'>
                <p class="mb-0 align-self-center mx-2" style="font-weight: bold"><span id="nbOffre">{{$nbVoiture ?? 0}}</span> Offres</p>
                <div class="btn-group">
                    <a class='m-2 text-end' id="dropdownfilter" data-bs-toggle="dropdown" aria-expanded="false"> Type de voiture <i class="fas fa-chevron-down"></i></a>
                    <ul class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                        <div class='ligne-75'></div>
                            @foreach($type as $data)
                                <li class="dropdown-item"><input type="checkbox"> {{strtoupper($data->type)}}</li>
                            @endforeach
                    </ul>
                </div>
            </div>

            <div id="offerList" class="col-12 p-0 d-flex flex-wrap">
                @foreach($voiture as $datas)
                <div class="col-4 p-3">
                    <div class="d-flex flex-column bg-white p-3">
                        <h2>{{$datas->marque.' '.$datas->model}}</h2>
                        <p>ou similaire | {{$datas->type}}</p>
                        <div class="imageDiv w-100 justify-content-center d-flex">
                            <img src="{{asset('/storage/'.$datas->image)}}" alt="" class="w-75 rounded">
                        </div>
                        <p class="mt-2"><i class="fa-solid fa-check"></i> 250 kilomètre incl.</p>
                        <div class="d-flex justify-content-between">
                            <h3>{{$datas->prix}}€ | <span>jour</span></h3>
                            @if($datas->statut !== 'Indisponible')
                            <a class="btn btn-outline-primary text-decoration-none" href="{{route('voitureData', $datas->id) }}">Sélectionner</a>
                            @else
                                <h2 class="text-capitalize">{{$datas->statut}}</h2>
                            @endif
                        </div>
                    </div>
                </div>
                @endforeach
            </div>
        </div>

    @endif
@endsection
