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
                        <td>{{$datasEnt->montantEnt."€"}}</td>
                        <td>{{date('d/m/Y', strtotime($datasEnt->dateEnt))}}</td>
                        <td>{{$datasEnt->immatriculation}}</td>
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
    </div>
    <div class="modal fade" id="EntretiensModal" tabindex="-1" data-bs-backdrop="static" data-bs-keyboard="false">
        <div class="modal-dialog modal-xl">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="VoitureModalLabel">Ajouter un entretiens</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="col-6 align-self-center modal-body d-flex flex-column">
                    <div class="d-flex flex-wrap align-items-baseline">
                        <label for="typeEnt">Type d'entretiens :</label>
                        <input type="text" name="typeEnt" placeholder="Type ex:(vidange)" class="inputForm inputType inputText mb-2 me-2" required>
                    </div>
                    <div class="d-flex flex-wrap align-items-baseline">
                        <label for="dateEnt">Date de l'entretiens</label>
                        <input type="text" name="dateEnt" placeholder="Date Entretiens" class="inputForm inputDate mb-2 me-2" required>
                    </div>
                    <div class="d-flex flex-wrap align-items-baseline">
                        <label for="garageEnt">Nom du garage :</label>
                        <input type="text" name="garageEnt" placeholder="Garage" class="inputForm inputGarage inputText mb-2 me-2" required>
                    </div>
                    <div class="d-flex flex-wrap align-items-baseline">
                        <label for="montantEnt">Montant :</label>
                        <input type="text" name="montantEnt" placeholder="Montant total" class="inputForm inputMontant inputNumber mb-2 me-2" required>
                    </div>
                    <div class="d-flex flex-wrap align-items-baseline">
                        <label for="id_voiture">Immatricualtion véhicule :</label>
                        <select name="id_voiture" id="idSelect">
                            @foreach($voiture as $datas)
                                <option value="{{$datas->id}}">{{$datas->immatriculation}}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="d-flex flex-wrap align-items-baseline">
                        <label for="noteEnt">Note supplémentaire :</label>
                        <textarea name="noteEnt" id="noteEnt" cols="30" rows="4" class="inputForm inputNote"></textarea>
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
