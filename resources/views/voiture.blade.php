
@extends('layouts.app')

@section('content')
    @if(Auth::user()->type === 'admin')
        @foreach( $voitureData ?? '' as $datas)
            <div class="container-fluid">
                <div class="col-auto d-flex flex-column flex-lg-row">

                    <div class="col-12 col-lg-4 border-dark border-3 border-opacity-25 p-4 d-flex justify-content-center" style="border-right: solid">
                        <img src="{{asset('storage/'.$datas->image)}}" alt="" class="w-100 rounded">
                    </div>
                    <div class="col-12 col-lg-8 px-2 mt-5" data-voiture="{{$datas->id}}" data-db="voiture">
                        <h2 class="text-primary text-center text-lg-start">Immatriculation : <span class="text-muted">{{$datas->immatriculation}}</span></h2>
                        <div class="d-flex mt-5">

                            <p class="mx-2"><i class="fa-solid fa-wrench fa-xl text-info"></i> <span id="nbEnt"> {{$nbData->nbEnt}} </span> entretiens</p>
                            <p class="mx-2"><i class="fa-solid fa-gear fa-xl text-info"></i> <span id="nbRep"> {{$nbData->nbRep}} </span> reparations</p>
                            <p class="mx-2"><i class="fa-solid fa-calendar-check fa-xl text-info"></i> <span id="nbAssu"> {{$nbData->nbAssu}} </span> assurances</p>
                            <p class="mx-2"><i class="fa-solid fa-gas-pump fa-xl text-info"></i> <span id="nbCons"> {{$nbData->nbCons}} </span> assurances</p>

                        </div>
                        <div class="col-12 col-lg-6 mt-5 d-flex flex-wrap justify-content-center justify-content-lg-start">
                            <div class="col-auto mx-2">
                                <h2 class="text-primary">Marque : </h2>
                                <h2 class="text-primary">Model : </h2>
                                <h2 class="text-primary">Mise en circulation : </h2>
                                <h2 class="text-primary">Statut : </h2>
                                <h2 class="text-primary">Puissance : </h2>
                                <h2 class="text-primary">Carburant : </h2>
                            </div>
                            <div class="col-auto mx-2">
                                <h2 class="text-muted">{{$datas->marque}}</h2>
                                <h2 class="text-muted">{{$datas->model}}</h2>
                                <h2 class="text-muted">{{$datas->circulation}}</h2>
                                <h2 class="text-muted">{{$datas->statut}}</h2>
                                <h2 class="text-muted">{{$datas->puissance}}</h2>
                                <h2 class="text-muted">{{$datas->carburant}}</h2>
                            </div>
                            <div class="col-auto mx-2 p-0  align-self-center">
                                <button class="btn btn-info editButton ms-lg-5" style="height: fit-content">modifier</button>
                            </div>
                        </div>
                    </div>

                </div>
                <div class="divbottom">
                    <div class="border-bottom border-top mt-2 border-dark border-opacity-25 border-2 pt-2">
                        <ul id="info_voiture" class="nav nav-tabs">
                            <li class="nav-item">
                                <a id="btnTabEnt" class="nav-link active text-dark" href="#" data-bs-toggle="tab" data-bs-target="#table_entretiens"><i class="fa-solid fa-wrench fa-lg text-dark m-2"></i>Entretiens</a>
                            </li>
                            <li class="nav-item">
                                <a id="btnTabRep" class="nav-link text-dark" href="#" data-bs-toggle="tab" data-bs-target="#table_reparations"><i class="fa-solid fa-gear fa-lg text-dark m-2"></i>Reparations</a>
                            </li>
                            <li class="nav-item">
                                <a id="btnTabAssu" class="nav-link text-dark" href="#" data-bs-toggle="tab" data-bs-target="#table_assurances"><i class="fa-solid fa-calendar-check fa-lg text-dark m-2"></i>Assurances</a>
                            </li>
                            <li class="nav-item">
                                <a id="btnTabCons" class="nav-link text-dark" href="#" data-bs-toggle="tab" data-bs-target="#table_carburants"><i class="fa-solid fa-gas-pump fa-lg text-dark m-2"></i>Carburants</a>
                            </li>
                        </ul>
                    </div>
                    <div id="block_info_voiture" class="tab-content">
                        <div id="table_entretiens" class="tab-pane fade active show" role="tabpanel">

                            <!-- Button trigger modal -->
                            <button type="button" class="btn btn-primary float-end" id="btnAddEntretiens">
                                Ajouter Entretien
                            </button>
                            <table id="DataTable_entretiens" class="table table-striped dataTable dt-responsive" style="width: 100%">
                                <thead>
                                <tr>
                                    <th>Nom garage</th>
                                    <th>Type</th>
                                    <th>Montant</th>
                                    <th>Date</th>
                                    <th>Note</th>
                                </tr>
                                </thead>
                                <tbody>
                                @foreach($entretiens as $datasEnt)
                                <tr data-voiture="{{{$datasEnt->id}}}" data-db="entretiens">
                                    <td>{{$datasEnt->garageEnt}}</td>
                                    <td>{{$datasEnt->typeEnt}}</td>
                                    <td>{{$datasEnt->montantEnt.'€'}}</td>
                                    <td>{{$datasEnt->dateEnt}}</td>
                                    <td class="tdBtn">
                                        <div class="noteSupp">
                                            {{(isset($datasEnt->noteEnt)) ? $datasEnt->noteEnt : "aucune note"}}
                                        </div>
                                        <div class="divBtnTab">
                                            <button class="btn btn-info editButton text-white"><i class="fa-solid fa-pencil "></i></button>
                                            <button class="btn btn-danger delButton"><i class="fa-solid fa-trash-can"></i></button>
                                        </div>
                                    </td>
                                </tr>
                                @endforeach
                                </tbody>
                            </table>

                        </div>
                        <div id="table_reparations" class="tab-pane fade" role="tabpanel">
                            <!-- Button trigger modal -->
                            <button type="button" class="btn btn-primary float-end" id="btnAddReparations">
                                Ajouter Reparation
                            </button>
                            <table id="DataTable_reparations" class="table table-striped dataTable dt-responsive" style="width: 100%">
                                <thead>
                                <tr>
                                    <th>Nom garage</th>
                                    <th>Type</th>
                                    <th>Montant</th>
                                    <th>Date</th>
                                    <th>Note</th>
                                </tr>
                                </thead>
                                <tbody>
                                @foreach($reparations as $datasRep)
                                    <tr data-voiture="{{$datasRep->id}}" data-db="reparations">
                                        <td>{{$datasRep->garageRep}}</td>
                                        <td>{{$datasRep->typeRep}}</td>
                                        <td>{{$datasRep->montantRep.'€'}}</td>
                                        <td>{{$datasRep->dateRep}}</td>
                                        <td class="tdBtn">
                                            <div class="noteSupp">
                                                {{(isset($datasRep->noteRep)) ? $datasRep->noteRep : "aucune note"}}
                                            </div>
                                            <div class="divBtnTab">
                                                <button class="btn btn-info editButton text-white"><i class="fa-solid fa-pencil "></i></button>
                                                <button class="btn btn-danger delButton"><i class="fa-solid fa-trash-can"></i></button>
                                            </div>
                                        </td>
                                    </tr>
                                @endforeach
                                </tbody>
                            </table>
                        </div>
                        <div id="table_assurances" class="tab-pane fade " role="tabpanel">
                            <!-- Button trigger modal -->
                            <button type="button" class="btn btn-primary float-end" id="btnAddAssurance">
                                Ajouter assurance
                            </button>
                            <table id="DataTable_assurances" class="table table-striped dataTable dt-responsive" style="width: 100%">
                                <thead>
                                <tr>
                                    <th>Nom assurance</th>
                                    <th>Debut assurance</th>
                                    <th>Fin assurance</th>
                                    <th>Frais</th>
                                </tr>
                                </thead>
                                <tbody>
                                @foreach($assurance as $datasAssu)
                                    <tr data-voiture="{{$datasAssu->id}}" data-db="assurance">
                                        <td>{{$datasAssu->nomAssu}}</td>
                                        <td>{{$datasAssu->debutAssu}}</td>
                                        <td>{{$datasAssu->finAssu}}</td>
                                        <td class="tdBtn">
                                            {{$datasAssu->frais."€"}}
                                            <div class="divBtnTab">
                                                <button class="btn btn-info editButton text-white"><i class="fa-solid fa-pencil "></i></button>
                                                <button class="btn btn-danger delButton"><i class="fa-solid fa-trash-can"></i></button>
                                            </div>
                                        </td>
                                    </tr>
                                @endforeach
                                </tbody>
                            </table>
                        </div>
                        <div id="table_carburants" class="tab-pane fade" role="tabpanel">
                            <!-- Button trigger modal -->
                            <button type="button" class="btn btn-primary float-end " id="btnAddConsommation">
                                Ajouter Carburant
                            </button>
                            <table id="DataTable_carburants" class="table table-striped dataTable dt-responsive" style="width: 100%">
                                <thead>
                                <tr>
                                    <th>Nombre de litre</th>
                                    <th>Montant</th>
                                    <th>litre/prix</th>
                                </tr>
                                </thead>
                                <tbody>
                                @foreach($consommation as $datasCons)
                                    <tr data-voiture="{{$datasCons->id}}" data-db="consommation">
                                        <td>{{$datasCons->litre}}</td>
                                        <td>{{$datasCons->montantCons.'€'}}</td>
                                        <td class="tdBtn">
                                            {{round($datasCons->montantCons/$datasCons->litre,3).'€'}}
                                            <div class="divBtnTab">
                                                <button class="btn btn-info editButton text-white"><i class="fa-solid fa-pencil "></i></button>
                                                <button class="btn btn-danger delButton"><i class="fa-solid fa-trash-can"></i></button>
                                            </div>
                                        </td>
                                    </tr>
                                @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        @endforeach
    @else
        <div id="containerVoiture" class="container p-2 d-flex justify-content-between">
            @foreach($voitureData as $datas)
                <div class="col-7 p-3 imageVoiture" style="background-image: url({{asset('/storage/'.$datas->image)}});">
                    <!--todo ajouter type de véhicule ex berline -->
                    <h2 class="text-white">{{$datas->model}} ou similaire | Berline</h2>
                    <div class="w-100 d-flex align-items-baseline">
                        <i class="fa-solid fa-user-group text-white iconVoiture"></i>
                        <!--todo ajouter nombre de place -->
                        <p class="text-white mx-3">4 Siège</p>
                        <!--todo ajouter nombre de porte -->
                        <div class="iconVoiture">
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                                <path fill="#191919" fill-rule="evenodd" d="M4 12v3.062c2.929.364 5.4 2.303 5.906 4.938H20v-8H4zm.618-2H20V4H7.618l-3 6zM2 10.764L6.382 2H22v20H8v-1c0-2.218-2.29-4-5-4H2v-6.236zM7 15v-2h3v2H7z" clip-rule="evenodd"></path>
                            </svg>
                        </div>
                        <p class="text-white mx-2">4 porte</p>
                        <!--todo ajouter type de boîte de vitesse -->
                        <div class="iconVoiture">
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                                <path fill="#191919" fill-rule="evenodd" d="M11 13H8v5H6V6h2v5h3V6h2v5h3V6h2v7h-5v5h-2v-5zM8 4H6V2h2v2zm5 0h-2V2h2v2zm5 0h-2V2h2v2zm-5 18h-2v-2h2v2zm-5 0H6v-2h2v2z" clip-rule="evenodd"></path>
                            </svg>
                        </div>
                        <p class="text-white mx-2">Manuelle</p>
                    </div>
                </div>
                <div class="col-4 p-3 bg-light rounded">
                    <h3>{{{$datas->model.' '.$datas->marque}}}</h3>
                    <h4>Période de location</h4>
                    <div class="w-100 d-flex justify-content-between px-4">
                        <p class="m-0">Durée de location</p>
                        <p class="m-0" id="prixTimeLocation">150€</p>
                    </div>
                    <h4>Frais</h4>
                    <div class="w-100 d-flex px-4 flex-column">
                        <div class="col-auto p-0 d-flex justify-content-between">
                            <p class="m-0">Participation environnementale</p>
                            <p id="prixEnv" class="m-0">30€</p>
                        </div>
                        <div class="col-auto p-0 d-flex justify-content-between">
                            <p class="m-0">Supplément local</p>
                            <p id="prixSuppLocal" class="m-0">10€</p>
                        </div>
                        <p class="m-0">250 kilomètre inclus, 2.75€ / km supplémentaire</p>
                    </div>
                    <div class="ligne-75"></div>
                </div>
            @endforeach
        </div>
    @endif
@endsection
