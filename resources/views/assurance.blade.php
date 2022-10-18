@extends('layouts.app')

@section('content')
    <div class="container-fluid">
        <!-- Button trigger modal -->
        <button type="button" class="btn btn-primary float-end btnAddModal">
            Ajouter Assurance
        </button>
        <div class="container">
            <h2>Page assurance</h2>
            <table id="DataTable_assurances" class="table table-striped dataTable table-responsive" style="width: 100%">
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

                        <td>{{date('d/m/Y', strtotime($datasAssu->debutAssu))}}</td>
                        <td>{{date('d/m/Y', strtotime($datasAssu->finAssu))}}</td>
                        <td>{{$datasAssu->immatriculation}}</td>
                        <td class="tdBtn">
                            {{$datasAssu->frais.'€'}}
                            <div class="divBtnTab d-flex flex-column flex-md-row">
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
    <div class="modal fade" id="AssuranceModal" tabindex="-1" data-bs-backdrop="static" data-bs-keyboard="false">
        <div class="modal-dialog modal-xl">

            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="VoitureModalLabel">Ajouter une assurance</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="col-6 align-self-center modal-body d-flex flex-column">
                    <div class="d-flex flex-wrap align-items-baseline">
                        <label for="nomAssu">Nom de l'assurance :</label>
                        <input type="text" name="nomAssu" placeholder="Nom assurance" class="inputForm inputAssu mb-2 inputText me-2" required>
                    </div>
                    <div class="d-flex flex-wrap align-items-baseline">
                        <label for="debutAssu">Date de début :</label>
                        <input type="text" name="debutAssu" class="inputForm assuDateD mb-2 inputDate me-2" required>
                    </div>
                    <div class="d-flex flex-wrap align-items-baseline">
                        <label for="finAssu">Date de fin :</label>
                        <input type="text" name="finAssu" class="inputForm assuDateF inputDate mb-2 me-2" required>
                    </div>
                    <div class="d-flex flex-wrap align-items-baseline">
                        <label for="frais">Frais de l'assurance :</label>
                        <input type="text" name="frais" placeholder="Frais assurance" class="inputForm inputFrais inputNumber mb-2 me-2" required>
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
