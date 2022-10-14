@extends('layouts.app')

@section('content')
    <div class="container-fluid">
        <!-- Button trigger modal -->
        <button type="button" class="btn btn-primary float-end btnAddModal">
            Ajouter Reparation
        </button>
        <div class="container">
            <h2>Page reparation</h2>
            <table id="DataTable_reparations" class="table table-striped dataTable table-responsive" style="width: 100%">
                <thead>
                <tr>
                    <th>Nom garage</th>
                    <th>Type</th>
                    <th>Montant</th>
                    <th>Date</th>
                    <th>Immatriculation</th>
                    <th>Note</th>
                </tr>
                </thead>
                <tbody>
                @foreach($reparation as $datas)
                    <tr data-voiture="{{$datas->id}}" data-db="reparations">
                        <td>{{$datas->garageRep}}</td>
                        <td>{{$datas->typeRep}}</td>
                        <td>{{$datas->montantRep.'€'}}</td>
                        <td>{{date('d/m/Y', strtotime($datas->dateRep))}}</td>
                        <td>{{$datas->immatriculation}}</td>
                        <td class="tdBtn">
                            <div class="noteSupp">
                                {{(isset($datas->noteRep)) ? $datas->noteRep : "Aucune note"}}
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
    </div>
    <div class="modal fade" id="ReparationsModal" tabindex="-1" data-bs-backdrop="static" data-bs-keyboard="false">
        <div class="modal-dialog modal-xl">

            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Ajouter une réparations</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="col-6 align-self-center modal-body d-flex flex-column">
                    <div class="d-flex flex-wrap">
                        <label for="typeRep">Type de réparations :</label>
                        <input type="text" name="typeRep" placeholder="Type ex:(vidange)" class="inputForm inputType inputText mb-2 me-2" required>
                    </div>
                    <div class="d-flex flex-wrap align-items-baseline">
                        <label for="dateRep">Date de la réparations :</label>
                        <input type="text" name="dateRep" placeholder="Date Entretiens" class="inputForm inputDate mb-2 me-2" required>
                    </div>
                    <div class="d-flex flex-wrap align-items-baseline">
                        <label for="garageRep">Nom du garage :</label>
                        <input type="text" name="garageRep" placeholder="Garage" class="inputForm inputGarage mb-2 me-2 inputText" required>
                    </div>
                    <div class="d-flex flex-wrap align-items-baseline">
                        <label for="montantRep">Montant :</label>
                        <input type="text" name="montantRep" placeholder="Montant total" class="inputForm inputMontant inputNumber mb-2 me-2" required>
                    </div>
                    <div class="d-flex flex-wrap align-items-baseline">
                        <label for="id_voiture">Immatriculation du véhicule :</label>
                        <select name="id_voiture" id="idSelect" class="mb-2 me-2">
                            @foreach($voiture as $datas)
                                <option value="{{$datas->id}}">{{$datas->immatriculation}}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="d-flex flex-wrap align-items-baseline">
                        <label for="noteEnt">Note supplémentaire :</label>
                        <textarea name="noteEnt" id="noteRep" cols="30" rows="4" class="inputForm inputNote  mb-2 me-2"></textarea>
                    </div>


                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Annuler</button>
                    <button type="button" class="btn btn-primary btnModal">Creer</button>
                </div>
            </div>
        </div>
    </div>
@endsection
