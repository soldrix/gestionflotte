@extends('layouts.app')

@section('content')
    <div class="container-fluid">
        <!-- Button trigger modal -->
        <button type="button" class="btn btn-primary float-end btnAddModal">
            Ajouter consommation
        </button>
        <div class="container">
            <h2>Page Consommation</h2>
            <table id="DataTable_carburants" class="table table-striped dataTable">
                <thead>
                <tr>
                    <th>Nombre de litre</th>
                    <th>Montant</th>
                    <th>Immatriculation</th>
                    <th>Litre/Prix</th>
                </tr>
                </thead>
                <tbody>
                @foreach($consommation as $datasCons)
                    <tr data-voiture="{{$datasCons->id}}" data-db="consommation">
                        <td>{{$datasCons->litre}}</td>
                        <td>{{$datasCons->montantCons}}€</td>
                        <td>{{$datasCons->immatriculation}}</td>
                        <td>{{round($datasCons->montantCons/$datasCons->litre,3)}}€
                            <button class="btn btn-info editButton">modifier</button>
                            <button class="btn btn-danger delButton">supprimer</button></td>
                    </tr>
                @endforeach
                </tbody>
            </table>
        </div>
    </div>
    <div class="modal fade" id="ConsommationModal" tabindex="-1">
        <div class="modal-dialog modal-xl">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Modal consommation</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="col-6 align-self-center modal-body d-flex flex-column">
                    <h2>Consommation</h2>
                    <div class="d-flex">
                        <input type="text" name="montantCons" placeholder="Montant total" class="inputForm inputMontant" required>
                        <input type="text" name="litre" placeholder="Nombre de litre" class="inputForm inputDate" required>
                    </div>

                    <select name="id_voiture" id="idSelect">
                        @foreach($voiture as $datas)
                            <option value="{{$datas->id}}">{{$datas->immatriculation}}</option>
                        @endforeach
                    </select>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Annuler</button>
                    <button type="button" class="btn btn-primary btnModal">Creer</button>
                </div>
            </div>
        </div>
    </div>
@endsection
