require('./bootstrap');
require('datatables.net-bs5');
$(document).ready(function () {

    if ( $('#DataTable_entretiens').length > 0){
        $('.dataTable').DataTable({
            "language": {
                "lengthMenu": "Afficher _MENU_ entrées",
                "zeroRecords": "Aucune entrée correspondante trouvée",
                "info": "Affichage de _START_ à _END_ sur _TOTAL_ entrées",
                "infoEmpty": "Affichage de 0 à 0 sur 0 entrées",
                "infoFiltered": "(filtrées depuis un total de _MAX_ entrées)",
                "search": "Rechercher:",
                "paginate": {
                    "first": "Première",
                    "last": "Dernière",
                    "next": "Suivante",
                    "previous": "Précédente"
                },
            }
        });
    }

    $(document).on('click','#btnAddVoiture',function () {
        modal('voiture')
    }).on('click',"#btnAddAssurance",function () {
        modal('assurance')
    }).on('click','#btnAddEntretiens',function () {
        modal('entretiens')
    }).on('click','#btnAddReparations',function () {
        modal('reparations')
    }).on('click','#btnAddConsommation',function () {
        modal('consommation')
    })
})
function modal(name)
{
    let htmlModal = (name === "voiture") ?
                    `<h2>Voiture</h2>
                    <input type="text" name="marque" placeholder="Marque">

                    <input type="text" name="model" placeholder="Model">

                    <input type="text" name="carburant" placeholder="Carburant ex:(diesel)">

                    <input type="text" name="circulation" placeholder="Date circulation">

                    <input type="text" name="immatriculation" placeholder="Immatriculation">

                    <input type="text" name="puissance" placeholder="Puissance ex:(100cc)">

                    <select name="status" id="voitureSatut">
                        <option value="disponible">Disponible</option>
                        <option value="indisponible">Indisponible</option>
                    </select>

                    <input type="file" name="file" accept="image/png, image/jpeg, image/jpg">`
        : (name === "assurance") ?
                    `<h2>Assurance</h2>

                    <input type="text" name="nomAssu" placeholder="Nom assurance">

                    <input type="date" name="debutAssu" placeholder="Debut assurance">

                    <input type="date" name="finAssu" placeholder="Fin assurance">

                    <input type="text" name="frais" placeholder="Frais assurance">`
        : (name === "entretiens") ?
                `<h2>Entretiens</h2>

                    <input type="text" name="typeEnt" placeholder="Type ex:(vidange)">

                    <input type="date" name="dateEnt" placeholder="Date Entretiens">

                    <input type="text" name="montantEnt" placeholder="Montant total">

                    <textarea name="noteEnt" id="noteEnt" cols="30" rows="4"></textarea>`
        : (name === "reparations") ?
                    `<h2>Reparations</h2>

                    <input type="text" name="typeRep" placeholder="Type ex:(vidange)">

                    <input type="date" name="dateRep" placeholder="Date Reparations">

                    <input type="text" name="montantRep" placeholder="Montant total">

                    <textarea name="noteRep" id="noteRep" cols="30" rows="4"></textarea>`
        : (name === "consommation") ?
                    `<h2>Consommation</h2>

                    <input type="text" name="montantCons" placeholder="Montant total">

                    <input type="date" name="litre" placeholder="Nombre de litre">` :"";

    $('body').append(`
    <div class="modal fade" id="VoitureModal" tabindex="-1" aria-labelledby="VoitureModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-xl">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="VoitureModalLabel">Modal title</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    ${htmlModal}
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    <button type="button" class="btn btn-primary">Save changes</button>
                </div>
            </div>
        </div>
    </div>
    `)
}
