@extends('layouts.app')

@section('content')
    <div class="container-fluid">
        <!-- Button trigger modal -->
        <button type="button" class="btn btn-primary float-end btnAddModal">
            Ajouter Entretien
        </button>
        <div class="container">
            <h2>Page entretiens</h2>
            <table id="DataTable_entretiens" class="table table-striped dataTable">
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
                @foreach($entretiens as $datasEnt)
                    <tr data-voiture="{{$datasEnt->id}}" data-db="entretiens">
                        <td>{{$datasEnt->garageEnt}}</td>
                        <td>{{$datasEnt->typeEnt}}</td>
                        <td>{{$datasEnt->montantEnt}}€</td>
                        <td>{{$datasEnt->dateEnt}}</td>
                        <td>{{$datasEnt->immatriculation}}</td>
                        <td>{{(isset($datasEnt->noteEnt)) ? $datasEnt->noteEnt : "aucune note"}}
                            <button class="btn btn-info editButton">modifier</button>
                            <button class="btn btn-danger delButton">supprimer</button></td>
                    </tr>
                @endforeach
                </tbody>
            </table>
        </div>
    </div>
    <div class="modal fade" id="EntretiensModal" tabindex="-1">
        <div class="modal-dialog modal-xl">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="VoitureModalLabel">Modal entretiens</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="col-6 align-self-center modal-body d-flex flex-column">
                    <h2>Entretiens</h2>
                    <div class="d-flex flex-wrap">
                        <input type="text" name="typeEnt" placeholder="Type ex:(vidange)" class="inputForm inputType" required>
                        <input type="date" name="dateEnt" placeholder="Date Entretiens" class="inputForm inputDate" required>
                        <input type="text" name="garageEnt" placeholder="Garage" class="inputForm inputGarage" required>
                    </div>

                    <div class="d-flex">
                        <input type="text" name="montantEnt" placeholder="Montant total" class="inputForm inputMontant" required>
                        <select name="id_voiture" id="idSelect">
                            @foreach($voiture as $datas)
                                <option value="{{$datas->id}}">{{$datas->immatriculation}}</option>
                            @endforeach
                        </select>
                    </div>
                    <textarea name="noteEnt" id="noteEnt" cols="30" rows="4" class="inputForm inputNote"></textarea>

                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Annuler</button>
                    <button type="submit" class="btn btn-primary btnModal">Creer</button>
                </div>
            </div>
        </div>
    </div>
@endsection
