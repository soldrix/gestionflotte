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
                        <td>{{$datasCons->montantCons.'€'}}</td>
                        <td>{{$datasCons->immatriculation}}</td>
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
    <div class="modal fade" id="ConsommationModal" tabindex="-1" data-bs-backdrop="static" data-bs-keyboard="false">
        <div class="modal-dialog modal-xl">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Ajouter une consommation</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="col-6 align-self-center modal-body d-flex flex-column">
                    <div class="d-flex flex-wrap align-items-baseline">
                        <label for="montantCons">Montant :</label>
                        <input type="text" name="montantCons" placeholder="Montant total" class="inputForm inputMontant inputNumber mb-2 me-2" required>
                    </div>
                    <div class="d-flex flex-wrap align-items-baseline">
                        <label for="litre">Nombre de litre :</label>
                        <input type="text" name="litre" placeholder="Nombre de litre" class="inputForm inputDate mb-2 inputNumber" required>
                    </div>
                    <div class="d-flex flex-wrap align-items-baseline">
                        <label for="id_voiture">Immatriculation du véhicule :</label>
                        <select name="id_voiture" id="idSelect" class="mb-2 me-2">
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
