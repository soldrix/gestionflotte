
@extends('layouts.app')

@section('content')
    @foreach( $voitureData ?? '' as $datas)
<div class="container-fluid">
    <div class="col-auto d-flex">

        <div class="col-4 border-dark border-3 border-opacity-25 p-4" style="border-right: solid">
            <img src="{{asset('storage/'.$datas->image)}}" alt="" class="w-100 rounded">
        </div>
        <div class="col-8 px-2 mt-5">
            <h2 class="text-primary">Immatriculation : <span class="text-muted">{{$datas->immatriculation}}</span></h2>
            <div class="d-flex mt-5">
                <p class="mx-2"><i class="fa-solid fa-wrench fa-xl text-info"></i> <span> 1 </span> entretiens</p>
                <p class="mx-2"><i class="fa-solid fa-gear fa-xl text-info"></i> <span> 1 </span> reparations</p>
                <p class="mx-2"><i class="fa-solid fa-gear fa-xl text-info"></i> <span> 1 </span> assurances</p>
            </div>
            <div class="col-6 mt-5 d-flex">
                <div class="col-auto mx-2">
                    <h2 class="text-primary">Marque : </h2>
                    <h2 class="text-primary">Model : </h2>
                    <h2 class="text-primary">Mise en circulation : </h2>
                    <h2 class="text-primary">Statut : </h2>
                    <h2 class="text-primary">Puissance : </h2>
                </div>
                <div class="col-auto mx-2">
                    <h2 class="text-muted">{{$datas->marque}}</h2>
                    <h2 class="text-muted">{{$datas->model}}</h2>
                    <h2 class="text-muted">{{$datas->circulation}}</h2>
                    <h2 class="text-muted">{{$datas->statut}}</h2>
                    <h2 class="text-muted">{{$datas->puissance}}</h2>
                </div>
            </div>
        </div>

    </div>
    <div class="divbottom">
        <div class="border-bottom border-top mt-2 border-dark border-opacity-25 border-2 pt-2">
            <ul id="info_voiture" class="nav nav-tabs">
                <li class="nav-item">
                    <a class="nav-link active text-dark" href="#" data-bs-toggle="tab" data-bs-target="#table_entretiens"><i class="fa-solid fa-wrench fa-lg text-dark m-2"></i>Entretiens</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link text-dark" href="#" data-bs-toggle="tab" data-bs-target="#table_reparations"><i class="fa-solid fa-gear fa-lg text-dark m-2"></i>Reparations</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link text-dark" href="#" data-bs-toggle="tab" data-bs-target="#table_assurances"><i class="fa-solid fa-calendar-check fa-lg text-dark m-2"></i>Assurances</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link text-dark" href="#" data-bs-toggle="tab" data-bs-target="#table_carburants"><i class="fa-solid fa-gas-pump fa-lg text-dark m-2"></i>Carburants</a>
                </li>
            </ul>
        </div>
        <div id="block_info_voiture" class="tab-content">
            <div id="table_entretiens" class="tab-pane fade active show" role="tabpanel">

                <!-- Button trigger modal -->
                <button type="button" class="btn btn-primary float-end" data-bs-toggle="modal" data-bs-target="#btnAddEntretiens">
                    Ajouter Entretien
                </button>
                <table id="DataTable_entretiens" class="table table-striped dataTable">
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
                    <tr>
                        <td>{{$datasEnt->garageEnt}}</td>
                        <td>{{$datasEnt->typeEnt}}</td>
                        <td>{{$datasEnt->montantEnt}}€</td>
                        <td>{{$datasEnt->dateEnt}}</td>
                        <td>{{(isset($datasEnt->noteEnt)) ? $datasEnt->noteEnt : "aucune note"}}</td>
                    </tr>
                    @endforeach
                    </tbody>
                </table>

            </div>
            <div id="table_reparations" class="tab-pane fade" role="tabpanel">
                <!-- Button trigger modal -->
                <button type="button" class="btn btn-primary float-end" data-bs-toggle="modal" data-bs-target="#btnAddReparations">
                    Ajouter Reparation
                </button>
                <table id="DataTable_reparations" class="table table-striped dataTable">
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
                        <tr>
                            <td>{{$datasRep->garageRep}}</td>
                            <td>{{$datasRep->typeRep}}</td>
                            <td>{{$datasRep->montantRep}}€</td>
                            <td>{{$datasRep->dateRep}}</td>
                            <td>{{(isset($datasRep->noteRep)) ? $datasRep->noteRep : "aucune note"}}</td>
                        </tr>
                    @endforeach
                    </tbody>
                </table>
            </div>
            <div id="table_assurances" class="tab-pane fade " role="tabpanel">
                <!-- Button trigger modal -->
                <button type="button" class="btn btn-primary float-end" data-bs-toggle="modal" data-bs-target="#btnAddAssurance">
                    Ajouter assurance
                </button>
                <table id="DataTable_assurances" class="table table-striped dataTable">
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
                        <tr>
                            <td>{{$datasAssu->nomAssu}}</td>
                            <td>{{$datasAssu->debutAssu}}</td>
                            <td>{{$datasAssu->finAssu}}</td>
                            <td>{{$datasAssu->frais}}€</td>
                        </tr>
                    @endforeach
                    </tbody>
                </table>
            </div>
            <div id="table_carburants" class="tab-pane fade" role="tabpanel">
                <!-- Button trigger modal -->
                <button type="button" class="btn btn-primary float-end" data-bs-toggle="modal" data-bs-target="#btnAddCarburant">
                    Ajouter Carburant
                </button>
                <table id="DataTable_carburants" class="table table-striped dataTable">
                    <thead>
                    <tr>
                        <th>Nombre de litre</th>
                        <th>Montant</th>
                        <th>litre/prix</th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach($consommation as $datasCons)
                        <tr>
                            <td>{{$datasCons->litre}}</td>
                            <td>{{$datasCons->montantCons}}€</td>
                            <td>{{round($datasCons->montantCons/$datasCons->litre,3)}}€</td>
                        </tr>
                    @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
@endforeach
@endsection
