@extends('layouts.app')

@section('content')
    <div class="container-fluid">
        <!-- Button trigger modal -->
        <button type="button" class="btn btn-primary float-end" id="btnAddAgence">
            Ajouter agence
        </button>
        <div class="container">
            <h2>Page agence</h2>
            <table id="DataTable_agence" class="table table-striped dataTable table-responsive" style="width: 100%">
                <thead>
                <tr>
                    <th>Ville</th>
                    <th>Rue</th>
                </tr>
                </thead>
                <tbody>
                @foreach($agence as $datas)
                    <tr data-voiture="{{$datas->id}}" data-db="agence">
                        <td>{{$datas->ville}}</td>
                        <td class="tdBtn">
                            {{$datas->rue}}
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
    <div class="modal fade" id="AgenceModal" tabindex="-1" data-bs-backdrop="static" data-bs-keyboard="false">
        <div class="modal-dialog modal-xl">

            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="VoitureModalLabel">Ajouter une agence</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="col-6 align-self-center modal-body d-flex flex-column">
                    <div class="d-flex flex-wrap align-items-baseline">
                        <label for="nomAssu">Ville de l'agence :</label>
                        <input type="text" name="ville" class="inputForm inputAssu mb-2 me-2" required>
                    </div>
                    <div class="d-flex flex-wrap align-items-baseline">
                        <label for="debutAssu">Rue de l'agence :</label>
                        <input type="text" name="rue" class="inputForm assuDateD mb-2 me-2" required>
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
