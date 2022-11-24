@extends('layouts.app')

@section('content')
    <div class="container-fluid py-4">
        <!-- Button trigger modal -->
        <button type="button" class="btn btn-primary float-end " id="btnAddLocation">
            Ajouter une location
        </button>
        <div class="container">
            <h2>Page location</h2>
            <table id="DataTable_location" class="table table-striped dataTable table-responsive" style="width: 100%">
                <thead>
                <tr>
                    <th>Date de début</th>
                    <th>Date de Fin</th>
                    <th>Immatriculation</th>
                </tr>
                </thead>
                <tbody>
                @foreach($location as $datas)
                    <tr data-voiture="{{$datas->id}}" data-db="location">
                        <td>{{date('d/m/Y', strtotime($datas->dateDebut))}}</td>
                        <td>{{date('d/m/Y', strtotime($datas->dateFin))}}</td>
                        <td class="tdBtn">
                            {{($datas->immatriculation === null) ? 'Vide' :$datas->immatriculation}}
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
    <div class="modal fade" id="LocationModal" tabindex="-1" data-bs-backdrop="static" data-bs-keyboard="false">
        <div class="modal-dialog modal-xl">

            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="VoitureModalLabel">Ajouter une location</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="col-6 align-self-center modal-body d-flex flex-column">
                    <div class="d-flex flex-wrap align-items-baseline">
                        <label for="imLocation">L'immatriculation :</label>
                        <select name="id_voiture" id="imLocation">
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
