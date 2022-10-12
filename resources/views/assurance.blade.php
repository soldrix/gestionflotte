@extends('layouts.app')

@section('content')
    <div class="container-fluid">
        <!-- Button trigger modal -->
        <button type="button" class="btn btn-primary float-end btnAddModal">
            Ajouter Assurance
        </button>
        <div class="container">
            <h2>Page assurance</h2>
            <table id="DataTable_assurances" class="table table-striped dataTable">
                <thead>
                <tr>
                    <th>Nom assurance</th>
                    <th>Debut assurance</th>
                    <th>Fin assurance</th>
                    <th>Immatriculation</th>
                    <th>Frais</th>
                </tr>
                </thead>
                <tbody>
                @foreach($assurance as $datasAssu)
                    <tr data-voiture="{{$datasAssu->id}}" data-db="assurance">
                        <td>{{$datasAssu->nomAssu}}</td>
                        <td>{{$datasAssu->debutAssu}}</td>
                        <td>{{$datasAssu->finAssu}}</td>
                        <td>{{$datasAssu->immatriculation}}</td>
                        <td>{{$datasAssu->frais}}€
                            <button class="btn btn-info editButton">modifier</button>
                        <button class="btn btn-danger delButton">supprimer</button></td>
                    </tr>
                @endforeach
                </tbody>
            </table>
        </div>
    </div>
    <div class="modal fade" id="AssuranceModal" tabindex="-1" data-bs-backdrop="static" data-bs-keyboard="false">
        <div class="modal-dialog modal-xl">

            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="VoitureModalLabel">Modal assurance</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="col-6 align-self-center modal-body d-flex flex-column">
                    <h2>Assurance</h2>
                    <div class="d-flex flex-wrap">
                        <input type="text" name="nomAssu" placeholder="Nom assurance" class="inputForm inputAssu" required>
                        <input type="date" name="debutAssu" placeholder="Debut assurance" class="inputForm assuDateD" required>
                        <input type="date" name="finAssu" placeholder="Fin assurance"  class="inputForm assuDateF" required>
                    </div>
                    <div class="d-flex">
                        <input type="text" name="frais" placeholder="Frais assurance" class="inputForm inputFrais" required>
                        <select name="id_voiture" id="idSelect">
                            @foreach($voiture as $datas)
                                <option value="{{$datas->id}}">{{$datas->immatriculation}}</option>
                            @endforeach
                        </select>
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
