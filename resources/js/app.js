require('datatables.net-bs5');
window.bootstrap = require('bootstrap/dist/js/bootstrap.bundle.js');
require('jquery-mask-plugin/dist/jquery.mask.js')
$(document).ready(function () {

    if ( $('.dataTable').length > 0){
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
    }).on('click','.btnAddModal',function () {
        $('.modal').ready(function () {
            $('.btnModal').prop('disabled', true);
            $('.inputForm').on('focusout',verifField)
            $('.inputForm').focus(disableBtn)
        })
    })



})
$(window).on('load',function () {
    $('.delButon').on('click',function () {
        supModal(this)
    })
})

function disableBtn(){
    $('.btnModal').prop('disabled', true)
}
function verifField(){
    let titleModal =$('.modal.fade.show .modal-header h5').html();
    if (titleModal === "Modal voiture"){
        if($('.inputMarque').val() !=="" && $('.inputModel').val() !== "" && $('.inputPuissance').val() !== "" && $('.inputCarbu').val()!=="" && $('.inputIm').val()!=="" && $('.inputFile').val()!==""){
            $('.btnModal').prop('disabled', false);
        }else{
            $('.btnModal').prop('disabled', true);
        }
    }
    if (titleModal === "Modal assurance"){
        console.log('ok')
        if($('.inputAssu').val() !=="" && $('.assuDateD').val() !== "" && $('.assuDateF').val() !== "" && $('.inputFrais').val()!==""){
            $('.btnModal').prop('disabled', false);
        }else{
            $('.btnModal').prop('disabled', true);
        }
    }
    if (titleModal === "Modal entretiens" || titleModal === "Modal reparations"){
        if($('.inputType').val() !=="" && $('.inputDate').val() !== "" && $('.inputMontant').val() !== "" && $('.inputIm').val() !== ""){
            $('.btnModal').prop('disabled', false);
        }else{
            $('.btnModal').prop('disabled', true);
        }
    }
    if (titleModal === "Modal consommation"){
        if($('.inputMontant').val() !=="" && $('.inputDate').val() !== "" && $('.inputIm').val() !== ""){
            $('.btnModal').prop('disabled', false);
        }else{
            $('.btnModal').prop('disabled', true);
        }
    }
}
function modal(name)
{
    let htmlModal = (name === "voiture") ?
                    `<h2>Ajouter une voiture</h2>
                    <div class="d-flex flex-wrap">
                        <input type="text" name="marque" placeholder="Marque" class="mb-2 me-2 inputMarque inputForm"  required>
                        <input type="text" name="model" placeholder="Model" class="mb-2 inputModel inputForm" required>
                    </div>
                    <div class="d-flex flex-wrap">
                        <input type="text" name="carburant" placeholder="Carburant ex:(diesel)" class="mb-2 me-2 inputCarbu inputForm" required>
                        <input type="date" name="circulation" placeholder="Date circulation" class="mb-2 inputCirc inputForm" required>
                    </div>
                    <div class="d-flex flex-wrap">
                        <input type="text" name="immatriculation" placeholder="Immatriculation" class="mb-2 me-2 inputIm inputForm" required>
                        <input type="text" name="puissance" placeholder="Puissance ex:(100cc)" class="mb-2 inputPuissance inputForm" required>
                    </div>
                    <div class="d-flex flex-wrap">
                         <select name="status" id="voitureSatut" class="mb-2 me-2">
                            <option value="disponible">Disponible</option>
                            <option value="indisponible">Indisponible</option>
                        </select>
                        <input type="file" name="file" accept="image/png, image/jpeg, image/jpg" class="mb-2 inputFile inputForm" required>
                    </div>
                   `
        : (name === "assurance") ?
                    `<h2>Assurance</h2>
                    <div class="d-flex flex-wrap">
                        <input type="text" name="nomAssu" placeholder="Nom assurance" class="inputForm inputAssu" required>
                        <input type="date" name="debutAssu" placeholder="Debut assurance" class="inputForm assuDateD" required>
                        <input type="date" name="finAssu" placeholder="Fin assurance"  class="inputForm assuDateF" required>
                    </div>
                    <div class="d-flex">
                        <input type="text" name="frais" placeholder="Frais assurance" class="inputForm inputFrais" required>
                        <input type="text" name="immatriculation" placeholder="Immatriculation" class="inputForm inputIm" required>
                    </div>`
        : (name === "entretiens") ?
                `<h2>Entretiens</h2>

                    <input type="text" name="typeEnt" placeholder="Type ex:(vidange)" class="inputForm inputType" required>

                    <input type="date" name="dateEnt" placeholder="Date Entretiens" class="inputForm inputDate" required>

                    <input type="text" name="montantEnt" placeholder="Montant total" class="inputForm inputMontant" required>
                    <input type="text" name="immatriculation" placeholder="Immatriculation" class="inputForm inputIm" required>
                    <textarea name="noteEnt" id="noteEnt" cols="30" rows="4" class="inputForm inputNote"></textarea>`
        : (name === "reparations") ?
                    `<h2>Reparations</h2>

                    <input type="text" name="typeRep" placeholder="Type ex:(vidange)" class="inputForm inputType" required>

                    <input type="date" name="dateRep" placeholder="Date Reparations" class="inputForm inputDate" required>

                    <input type="text" name="montantRep" placeholder="Montant total" class="inputForm inputMontant" required>
                    <input type="text" name="immatriculation" placeholder="Immatriculation" class="inputForm inputIm" required>
                    <textarea name="noteRep" id="noteRep" cols="30" rows="4" class="inputForm inputNote"></textarea>`
        : (name === "consommation") ?
                    `<h2>Consommation</h2>

                    <input type="text" name="montantCons" placeholder="Montant total" class="inputForm inputMontant" required>
                    <input type="text" name="immatriculation" placeholder="Immatriculation" class="inputForm inputIm" required>
                    <input type="date" name="litre" placeholder="Nombre de litre" class="inputForm inputDate" required>` :"";


    $('#VoitureModal').find('.modal-body').html(htmlModal)
    $('#VoitureModal .modal-header h5').html("Modal "+name)
    $('#VoitureModal').ready(function () {


        $('input[name=puissance]').mask('00000');
        $('input[name=immatriculation]').mask('SS-000-SS');
        $('.btnModal').prop('disabled', true);
        $('.inputForm').on('focusout',verifField)
        $('.inputForm').focus(disableBtn)




    })
    $('.btnModal').on('click',function () {
        $('form').attr('action',(name === 'voiture') ?"/addVoiture": (name === 'assurance') ? "/addAssurance" : (name === 'entretiens') ? '/addEntretiens' : (name === 'reparations') ? '/addReparations' : (name === 'consommation') ? '/addConsommation' :'');
    })
}
function supModal(row){
    let data = (window.location.pathname !== '/home') ? $(row).parent().parent().attr('data-voiture') : $(row).parent().attr('data-voiture');
    var myModal = new bootstrap.Modal(document.getElementById('delModal'));
    myModal.show();
    $('#btnDelModal').on('click',function () {

        let url =(window.location.pathname === '/assurance') ? '/delAssurance' : (window.location.pathname === '/entretiens') ? '/delEntretiens' : (window.location.pathname === '/reparation') ? '/delReparation' : (window.location.pathname === '/consommation') ? '/delConsommation' : (window.location.pathname === '/home') ? '/delVoiture' :  '';
        if(url !== '/delVoiture'){
            $("tr[data-voiture='"+data+"']").remove()
        }else{
            $(row).parent().remove();
        }
        if (url !== ''){

            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });
            $.ajax({
                type:"POST",
                data:{id:data},
                url:url,
                success:function () {
                    myModal.hide();
                    if (window.location.pathname === '/home' || window.location.pathname === '/delVoiture'){
                        if ($('.blockVoiture').length < 1){
                            $('.container').append(`
                        <p>Aucune voiture disponible</p>
                        `)
                        }
                    }
                    if ($('.dataTable').length > 0){
                        for (let i = 0; i < $('.dataTable').length ; i++) {
                            if ($('.dataTable tbody tr').eq(i).length < 1){
                                $('.dataTable tbody').eq(i).append(`
                            <tr class="odd">
                                <td colspan="5" class="dataTables_empty" valign="top">Aucune entrée correspondante trouvée</td>
                            </tr>
                        `)
                            }
                        }
                    }
                }
            })
        }

    })

}
