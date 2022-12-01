
@extends('layouts.app')

@section('content')
    @if(Auth::user()->type === 'admin')
        @foreach( $voitureData ?? '' as $datas)
            <div class="container-fluid py-4">
                <div class="col-auto d-flex flex-column flex-lg-row">

                    <div class="col-12 col-lg-4 border-dark border-3 border-opacity-25 p-4 d-flex justify-content-center" style="border-right: solid">
                        <img id="imageVoiture" src="{{asset('storage/'.$datas->image)}}" alt="" class="w-100 rounded">
                    </div>
                    <div class="col-12 col-lg-8 px-2 mt-5" data-voiture="{{$datas->id}}" data-db="voiture">
                        <h2 class="text-primary text-center text-lg-start">Immatriculation : <span class="text-muted" id="immatriculation">{{$datas->immatriculation}}</span></h2>
                        <div class="d-flex mt-5">

                            <p class="mx-2"><i class="fa-solid fa-wrench fa-xl text-info"></i> <span id="nbEnt"> {{$nbData->nbEnt}} </span> entretiens</p>
                            <p class="mx-2"><i class="fa-solid fa-gear fa-xl text-info"></i> <span id="nbRep"> {{$nbData->nbRep}} </span> reparations</p>
                            <p class="mx-2"><i class="fa-solid fa-calendar-check fa-xl text-info"></i> <span id="nbAssu"> {{$nbData->nbAssu}} </span> assurances</p>
                            <p class="mx-2"><i class="fa-solid fa-gas-pump fa-xl text-info"></i> <span id="nbCons"> {{$nbData->nbCons}} </span> Consommation</p>

                        </div>
                        <div class="col-12 col-lg-6 mt-5 d-flex flex-wrap justify-content-center justify-content-lg-start">
                            <div class="col-auto mx-2">
                                <h2 class="text-primary">Marque : </h2>
                                <h2 class="text-primary">Model : </h2>
                                <h2 class="text-primary">Mise en circulation : </h2>
                                <h2 class="text-primary">Statut : </h2>
                                <h2 class="text-primary">Puissance : </h2>
                                <h2 class="text-primary">Carburant : </h2>
                                <h2 class="text-primary">Type : </h2>
                                <h2 class="text-primary">nombre de siège : </h2>
                                <h2 class="text-primary">nombre de porte : </h2>
                                <h2 class="text-primary">Agence : </h2>
                            </div>
                            <div class="col-auto mx-2">
                                <h2 class="text-muted" id="marque">{{$datas->marque}}</h2>
                                <h2 class="text-muted" id="model">{{$datas->model}}</h2>
                                <h2 class="text-muted" id="circulation">{{$datas->circulation}}</h2>
                                <h2 class="text-muted" id="statut">{{$datas->statut}}</h2>
                                <h2 class="text-muted" id="puissance">{{$datas->puissance}}</h2>
                                <h2 class="text-muted" id="carburant">{{$datas->carburant}}</h2>
                                <h2 class="text-muted" id="typeVoiture">{{$datas->type}}</h2>
                                <h2 class="text-muted" id="nbPlace">{{$datas->nbPlace}}</h2>
                                <h2 class="text-muted" id="nbPorte">{{$datas->nbPorte}}</h2>
                                <h2 class="text-muted" id="agence">{{($datas->ville !== null) ? $datas->ville.' '.$datas->rue : 'vide'}}</h2>
                            </div>
                            <div class="col-auto mx-2 p-0  align-self-center">
                                <button class="btn btn-info editButton ms-lg-5" style="height: fit-content">modifier</button>
                            </div>
                        </div>
                    </div>

                </div>
                <div class="divbottom">
                    <div class="border-bottom border-top mt-2 border-dark border-opacity-25 border-2 pt-2">
                        <ul id="info_voiture" class="nav nav-tabs">
                            <li class="nav-item">
                                <a id="btnTabEnt" class="nav-link active text-dark" href="#" data-bs-toggle="tab" data-bs-target="#table_entretiens"><i class="fa-solid fa-wrench fa-lg text-dark m-2"></i>Entretiens</a>
                            </li>
                            <li class="nav-item">
                                <a id="btnTabRep" class="nav-link text-dark" href="#" data-bs-toggle="tab" data-bs-target="#table_reparations"><i class="fa-solid fa-gear fa-lg text-dark m-2"></i>Reparations</a>
                            </li>
                            <li class="nav-item">
                                <a id="btnTabAssu" class="nav-link text-dark" href="#" data-bs-toggle="tab" data-bs-target="#table_assurances"><i class="fa-solid fa-calendar-check fa-lg text-dark m-2"></i>Assurances</a>
                            </li>
                            <li class="nav-item">
                                <a id="btnTabCons" class="nav-link text-dark" href="#" data-bs-toggle="tab" data-bs-target="#table_carburants"><i class="fa-solid fa-gas-pump fa-lg text-dark m-2"></i>Carburants</a>
                            </li>
                        </ul>
                    </div>
                    <div id="block_info_voiture" class="tab-content">
                        <div id="table_entretiens" class="tab-pane fade active show" role="tabpanel">

                            <!-- Button trigger modal -->
                            <button type="button" class="btn btn-primary float-end" id="btnAddEntretiens">
                                Ajouter Entretien
                            </button>
                            <table id="DataTable_entretiens" class="table table-striped dataTable dt-responsive" style="width: 100%">
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
                                <tr data-voiture="{{{$datasEnt->id}}}" data-db="entretiens">
                                    <td>{{$datasEnt->garageEnt}}</td>
                                    <td>{{$datasEnt->typeEnt}}</td>
                                    <td>{{$datasEnt->montantEnt.'€'}}</td>
                                    <td>{{$datasEnt->dateEnt}}</td>
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
                        <div id="table_reparations" class="tab-pane fade" role="tabpanel">
                            <!-- Button trigger modal -->
                            <button type="button" class="btn btn-primary float-end" id="btnAddReparations">
                                Ajouter Reparation
                            </button>
                            <table id="DataTable_reparations" class="table table-striped dataTable dt-responsive" style="width: 100%">
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
                                    <tr data-voiture="{{$datasRep->id}}" data-db="reparations">
                                        <td>{{$datasRep->garageRep}}</td>
                                        <td>{{$datasRep->typeRep}}</td>
                                        <td>{{$datasRep->montantRep.'€'}}</td>
                                        <td>{{$datasRep->dateRep}}</td>
                                        <td class="tdBtn">
                                            <div class="noteSupp">
                                                {{(isset($datasRep->noteRep)) ? $datasRep->noteRep : "aucune note"}}
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
                        <div id="table_assurances" class="tab-pane fade " role="tabpanel">
                            <!-- Button trigger modal -->
                            <button type="button" class="btn btn-primary float-end" id="btnAddAssurance">
                                Ajouter assurance
                            </button>
                            <table id="DataTable_assurances" class="table table-striped dataTable dt-responsive" style="width: 100%">
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
                                    <tr data-voiture="{{$datasAssu->id}}" data-db="assurance">
                                        <td>{{$datasAssu->nomAssu}}</td>
                                        <td>{{$datasAssu->debutAssu}}</td>
                                        <td>{{$datasAssu->finAssu}}</td>
                                        <td class="tdBtn">
                                            {{$datasAssu->frais."€"}}
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
                        <div id="table_carburants" class="tab-pane fade" role="tabpanel">
                            <!-- Button trigger modal -->
                            <button type="button" class="btn btn-primary float-end " id="btnAddConsommation">
                                Ajouter Carburant
                            </button>
                            <table id="DataTable_carburants" class="table table-striped dataTable dt-responsive" style="width: 100%">
                                <thead>
                                <tr>
                                    <th>Nombre de litre</th>
                                    <th>Montant</th>
                                    <th>litre/prix</th>
                                </tr>
                                </thead>
                                <tbody>
                                @foreach($consommation as $datasCons)
                                    <tr data-voiture="{{$datasCons->id}}" data-db="consommation">
                                        <td>{{$datasCons->litre}}</td>
                                        <td>{{$datasCons->montantCons.'€'}}</td>
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
                </div>
            </div>
        @endforeach
    @else
        <div id="containerVoiture" class="container  px-5 py-4 d-flex flex-column">
            <div class="w-100 d-flex justify-content-between">
                @foreach($voitureData as $datas)
                    <div class="col-7 p-3 imageVoiture" style="background-image: url({{asset('/storage/'.$datas->image)}});">
                        <!--todo ajouter type de véhicule ex berline -->
                        <h2 class="text-white">{{$datas->model}} ou similaire | Berline</h2>
                        <div class="w-100 d-flex align-items-baseline">
                            <i class="fa-solid fa-user-group text-white iconVoiture"></i>
                            <!--todo ajouter nombre de place -->
                            <p class="text-white mx-3">4 Siège</p>
                            <!--todo ajouter nombre de porte -->
                            <div class="iconVoiture">
                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                                    <path fill="#191919" fill-rule="evenodd" d="M4 12v3.062c2.929.364 5.4 2.303 5.906 4.938H20v-8H4zm.618-2H20V4H7.618l-3 6zM2 10.764L6.382 2H22v20H8v-1c0-2.218-2.29-4-5-4H2v-6.236zM7 15v-2h3v2H7z" clip-rule="evenodd"></path>
                                </svg>
                            </div>
                            <p class="text-white mx-2">4 porte</p>
                            <!--todo ajouter type de boîte de vitesse -->
                            <div class="iconVoiture">
                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                                    <path fill="#191919" fill-rule="evenodd" d="M11 13H8v5H6V6h2v5h3V6h2v5h3V6h2v7h-5v5h-2v-5zM8 4H6V2h2v2zm5 0h-2V2h2v2zm5 0h-2V2h2v2zm-5 18h-2v-2h2v2zm-5 0H6v-2h2v2z" clip-rule="evenodd"></path>
                                </svg>
                            </div>
                            <p class="text-white mx-2">Manuelle</p>
                        </div>
                    </div>
                    <div id="blockSell" class="col-4 p-3 bg-light rounded d-flex flex-column">
                        <h3 class="mb-3">{{{$datas->model.' '.$datas->marque}}}</h3>
                        <h4>Période de location</h4>
                        <div class="d-flex flex-column mx-2 mt-2 mb-4">
                            <div class="d-flex ps-2">
                                <label for="dateD" class="text-opacity-50 text-dark mb-2 me-5">Date de départ</label>
                                <label for="dateF" class="text-opacity-50 text-dark mb-2 ms-4">Date de retour</label>
                            </div>
                            <div class="d-flex" id="LocationDate">
                                <input type="text" id="dateD" class="ms-2 inputSearch" placeholder="_ _ / _ _ / _ _ _ _" required>
                                <input type="text" id="dateF" class="me-2 inputSearch" placeholder="_ _ / _ _ / _ _ _ _" required readonly>
                            </div>
                        </div>
                        <div class="w-100 d-flex justify-content-between px-4">
                            <p class="m-0 textSell">Durée de location</p>
                            <p class="m-0" id="prixTimeLocation">1 jour</p>
                        </div>
                        <h4>Frais</h4>
                        <div class="w-100 d-flex px-4 flex-column">
                            <div class="col-auto p-0 d-flex justify-content-between">
                                <p class="m-0 textSell">Participation environnementale</p>
                                <p id="prixEnv" class="m-0">30€</p>
                            </div>
                            <div class="col-auto p-0 d-flex justify-content-between">
                                <p class="m-0 textSell">Supplément local</p>
                                <p id="prixSuppLocal" class="m-0">10€</p>
                            </div>
                            <p class="m-0 textSell">250 kilomètre inclus, 2.75€ / km supplémentaire</p>
                        </div>
                        <div class="ligne-75 align-self-center my-4"></div>
                        <div class="d-flex w-100 justify-content-between">
                            <h3>Total</h3>
                            <div class="d-flex flex-column">
                                <h3 id="priceVoiture" class="m-0">{{$datas->prix + 40}}€</h3>
                                <span class="taxeText">Taxes incluse</span>
                            </div>
                        </div>
                        <button class="btn btn-outline-primary mt-3" id="validationBtn">Continuer</button>
                    </div>
                @endforeach
            </div>
            <h5>
                Le véhicule peut être récuperer à partir de 8h et doit être remis à l'agence avant 22h. <br>
                L'annulation peut être gratuite jusqu'à 24 heures avant le début de la location.
            </h5>

            <h2 class="my-5">Choisissez votre protection et vos options</h2>
            <div class="d-flex w-100">
                <div class="col-4 d-flex flex-column bg-white p-2 rounded h-fit">
                    <h3 class="m-0">
                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 40 40" style="height: 2.5rem">
                            <path fill="#007aff" d="M19 17H8.303l-1.734 1.156 4.244 1.819-.788 1.838L6 20.088V29h4v-1H8v-2h11v2h-7v3H4V17.465l1.583-1.055-1.925-.963.895-1.789 2.8 1.4L10.382 9h18.236l1 2h-18l-2 4H19v2zm0 3.5V23h-6l1-2.5h5zm4-4.5h13v10.5c0 2.194-2.09 4.094-6.086 5.91l-.414.188-.414-.188C25.091 30.594 23 28.694 23 26.5V16zm2 2v8.5c0 1.092 1.446 2.452 4.5 3.898 3.054-1.446 4.5-2.806 4.5-3.898V18h-9z"></path>
                        </svg>
                        Protégez votre location
                    </h3>
                    <div class="d-flex flex-column w-100 px-4-5">
                        <h4>Protection vol et collision</h4>
                        <p class="text-start ps-4 pe-2 mb-1">Réduisez votre franchise en cas de vol
                            ou de dommages accidentels à la carrosserie
                            et aux jantes du véhicule.</p>
                        <div class="d-flex my-1">
                            <input type="radio" id="fp1" class="franchiseP" name="protection" checked>
                            <label for="fp1">Actuellement responsable des dommages
                                Jusqu’à la valeur total du véhicule</label>
                        </div>
                        <div class="d-flex justify-content-between">
                            <div class="col-auto p-0">
                                <input type="radio" id="fp2" class="franchiseP" name="protection">
                                <label for="fp2">3000€ de franchise</label>
                            </div>
                            <p><span id="pPrice1">{{(($datas->prix*5)/100) * 1.5}}</span>€ | jour</p>
                        </div>
                        <div class="d-flex justify-content-between">
                            <div class="col-auto p-0">
                                <input type="radio" id="fp3" class="franchiseP" name="protection">
                                <label for="fp3">1500€ de franchise</label>
                            </div>
                            <p><span id="pPrice2">{{(($datas->prix*10)/100) * 1.5}}</span>€ | jour</p>
                        </div>
                        <div class="d-flex justify-content-between">
                            <div class="col-auto p-0">
                                <input type="radio" id="fp4" class="franchiseP" name="protection">
                                <label for="fp4">0€ de franchise</label>
                            </div>
                            <p><span id="pPrice3">{{(($datas->prix*15)/100) * 1.5}}</span>€ | jour</p>
                        </div>
                    </div>
                    <div class="ligne-75 align-self-center my-2"></div>
                    <div class="w-100 d-flex px-4-5 flex-column">
                        <h4 class="m-0">Protection des pneus et vitres</h4>
                        <div class="d-flex col-auto py-2 justify-content-around">
                            <input type="checkbox" class="franchisePneu" id="protecPneu">
                            <label for="protecPneu">Franchise à 0 EUR.</label>
                            <p class="m-0"> <span id="pneuPrice">10</span>€ | Jour</p>
                        </div>
                        <p class="m-0">Protection pour les dommages
                            causés au pare-brise, aux fenêtres ou aux pneus.</p>
                    </div>
                </div>
                <div class="col-4 mx-2 d-flex flex-column">
                    <div class="w-100 d-flex flex-column bg-white p-3 rounded mx-2 mb-2 h-fit">
                        <h3 class="m-0">
                            <i class="fa-solid fa-user-plus text-primary"></i>
                            Conducteur supplémentaire
                        </h3>
                        <div class="d-flex flex-column w-100 p-2">
                            <p class="text-start ps-4 pe-2 mb-1">Partagez le plaisir de conduire et arrivez à destination en toute sécurité.</p>
                            <div class="d-flex w-100 justify-content-around my-2 align-items-baseline">
                                <select name="addDriver" id="addDriver">
                                    <option value="0" selected>0</option>
                                    @for($i=1;$i < 9;$i++)
                                    <option value="{{$i}}">{{$i}}</option>
                                    @endfor
                                </select>
                                <p class="mb-0"><span id="driverPrice">10</span>€ | Jour/Conducteur</p>
                            </div>
                        </div>
                    </div>
                    <div id="navigationV" class="w-100 d-flex flex-column bg-white p-3 rounded m-2 h-fit">
                        <h3 class="m-0">
                            <i class="fa-solid fa-map-location-dot text-primary me-3"></i>
                            Systèmes de navigation <br> <span class="ms-5">garanti</span>
                        </h3>
                        <div class="p-4">
                            <p class="mb-4">
                                <input type="checkbox" id="gps">
                                Trouvez le meilleur itinéraire avec le GPS
                            </p>
                            <p class="m-0"> <span id="navigationPrice">10</span>€ | jour</p>
                        </div>
                    </div>
                </div>
                <div class="col-4 d-flex flex-column bg-white p-3 rounded mx-2 h-fit">
                    <h3 class="m-0">
                        <i class="fa-regular fa-snowflake text-primary"></i>
                        Équipement d'hiver
                    </h3>
                    <div class="d-flex flex-column w-100 p-3">
                        <div class="d-flex w-100 justify-content-around align-items-center mt-2">
                            <input type="checkbox" id="chainesV">
                            <label for="chainesV">Chaînes à neige</label>
                            <p class="m-0"><span id="eqpPrice">10</span>€ | Jour</p>
                        </div>
                        <p class="ms-4">Ne laissez pas la neige vous prendre au dépourvu</p>
                    </div>
                </div>


            </div>

        </div>
    @endif
@endsection
