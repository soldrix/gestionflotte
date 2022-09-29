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

    $('.btnModal').attr('type','button');
    if (titleModal === "Modal voiture"){
        if($('.inputMarque').val() !=="" && $('.inputModel').val() !== "" && $('.inputPuissance').val() !== "" && $('.inputCarbu').val()!=="" && $('.inputIm').val()!=="" && $('.inputFile').val()!==""){
            $('.btnModal').prop('disabled', false);
            $('.btnModal').attr('type','submit');
        }else{
            $('.btnModal').prop('disabled', true);
        }
    }
    if (titleModal === "Modal assurance"){
        if($('.inputAssu').val() !=="" && $('.assuDateD').val() !== "" && $('.assuDateF').val() !== "" && $('.inputFrais').val()!==""){
            $('.btnModal').prop('disabled', false);
        }else{
            $('.btnModal').prop('disabled', true);
        }
    }
    if (titleModal === "Modal entretiens" || titleModal === "Modal reparations"){
        if($('.inputType').val() !=="" && $('.inputDate').val() !== "" && $('.inputMontant').val() !== "" && $('.inputGarage').val() !== ""){
            $('.btnModal').prop('disabled', false);
        }else{
            $('.btnModal').prop('disabled', true);
        }
    }
    if (titleModal === "Modal consommation"){
        if($('.inputMontant').val() !=="" && $('.inputDate').val() !== ""){
            $('.btnModal').prop('disabled', false);
        }else{
            $('.btnModal').prop('disabled', true);
        }
    }
}
let myModal1 = new bootstrap.Modal(document.getElementById('AddModal'));

function modal(name)
{
    myModal1.show();
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
                    </div>`
        : (name === "entretiens") ?
                `<h2>Entretiens</h2>

                    <input type="text" name="typeEnt" placeholder="Type ex:(vidange)" class="inputForm inputType" required>

                    <input type="date" name="dateEnt" placeholder="Date Entretiens" class="inputForm inputDate" required>

                    <input type="text" name="montantEnt" placeholder="Montant total" class="inputForm inputMontant" required>
                    <input type="text" name="garageEnt" placeholder="Garage" class="inputForm inputGarge" required>
                    <textarea name="noteEnt" id="noteEnt" cols="30" rows="4" class="inputForm inputNote"></textarea>`
        : (name === "reparations") ?
                    `<h2>Reparations</h2>

                    <input type="text" name="typeRep" placeholder="Type ex:(vidange)" class="inputForm inputType" required>

                    <input type="date" name="dateRep" placeholder="Date Reparations" class="inputForm inputDate" required>

                    <input type="text" name="montantRep" placeholder="Montant total" class="inputForm inputMontant" required>
                    <input type="text" name="garageRep" placeholder="Garage" class="inputForm inputGarage" required>
                    <textarea name="noteRep" id="noteRep" cols="30" rows="4" class="inputForm inputNote"></textarea>`
        : (name === "consommation") ?
                    `<h2>Consommation</h2>

                    <input type="text" name="montantCons" placeholder="Montant total" class="inputForm inputMontant" required>
                    <input type="text" name="litre" placeholder="Nombre de litre" class="inputForm inputDate" required>` :"";


    $('#AddModal').find('.modal-body').html(htmlModal)
    $('#AddModal .modal-header h5').html("Modal "+name)
    $('#AddModal').ready(function () {
        $('input[name=puissance]').mask('00000');
        $('input[name=immatriculation]').mask('SS-000-SS');
        $('.btnModal').prop('disabled', true);
        $('.inputForm').on('focusout',verifField)
        $('.inputForm').focus(disableBtn)
    })
    $('.btnModal').on('click',function () {
        if($(this).attr('type') === 'submit'){
            $('.modal.fade.show form').attr("action","/addVoiture");
        }else{
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });
            let id_voiture =window.location.pathname.replace('/voiture/','');
            if (name === 'assurance'){
                $.ajax({
                    type:"POST",
                    url:"/voiture/addAssurance",
                    data:{
                        nomAssu:     $('input[name=nomAssu]').val(),
                        debutAssu:   $('input[name=debutAssu]').val(),
                        finAssu:     $('input[name=finAssu]').val(),
                        frais:       $('input[name=frais]').val(),
                        id_voiture : id_voiture
                    },
                    success:function (row) {
                        myModal1.hide();
                        row.forEach(datas =>{
                            $('#DataTable_assurances tbody').prepend(`
                            <tr data-voiture="${datas.id}">
                                <td>${datas.nomAssu}</td>
                                <td>${datas.debutAssu}</td>
                                <td>${datas.finAssu}</td>
                                <td>${datas.frais}€
                                <button class="btn btn-info editButon">modifier</button>
                                <button class="btn btn-danger delButon">supprimer</button></td>
                            </tr>
                        `)
                        })
                    }
                })
            }
            if (name === 'entretiens'){
                let note = ($('input[name=noteEnt]').val() !== '' && $('input[name=noteEnt]').val() !== undefined) ? $('input[name=noteEnt]').val() : 'aucune note';
                $.ajax({
                    type:"POST",
                    url:"/voiture/addEntretien",
                    data:{
                        noteEnt:note,
                        typeEnt:$('input[name=typeEnt]').val(),
                        dateEnt:$('input[name=dateEnt]').val(),
                        montantEnt:$('input[name=montantEnt]').val(),
                        garageEnt:$('input[name=garageEnt]').val(),
                        id_voiture : id_voiture
                    },
                    dataType:"json",
                    success:function (row) {
                        myModal1.hide();
                        row.forEach(datas =>{
                            $('#DataTable_entretiens tbody').prepend(`
                            <tr data-voiture="${datas.id}">
                                <td>${datas.garageEnt}</td>
                                <td>${datas.typeEnt}</td>
                                <td>${datas.montantEnt}€</td>
                                <td>${datas.dateEnt}</td>
                                <td>${datas.noteEnt}
                                <button class="btn btn-info editButon">modifier</button>
                                <button class="btn btn-danger delButon">supprimer</button></td>
                            </tr>
                        `)
                        })
                    }
                })
            }
            if (name === 'reparations'){
                let note = ($('input[name=noteRep]').val() !== '' && $('input[name=noteRep]').val() !== undefined) ? $('input[name=noteRep]').val() : 'aucune note';
                $.ajax({
                    type:"POST",
                    url:"/voiture/addReparation",
                    data:{
                        noteRep:note,
                        typeRep:$('input[name=typeRep]').val(),
                        dateRep:$('input[name=dateRep]').val(),
                        montantRep:$('input[name=montantRep]').val(),
                        garageRep:$('input[name=garageRep]').val(),
                        id_voiture : id_voiture
                    },
                    dataType:"json",
                    success:function (row) {
                        myModal1.hide();
                        row.forEach(datas =>{
                            $('#DataTable_reparations tbody').prepend(`
                            <tr data-voiture="${datas.id}">
                                <td>${datas.garageRep}</td>
                                <td>${datas.typeRep}</td>
                                <td>${datas.montantRep}€</td>
                                <td>${datas.dateRep}</td>
                                <td>${datas.noteRep}
                                <button class="btn btn-info editButon">modifier</button>
                                <button class="btn btn-danger delButon">supprimer</button></td>
                            </tr>
                        `)
                        })
                    }
                })
            }
            if (name === 'consommation'){
                $.ajax({
                    type:"POST",
                    url:"/voiture/addConsommation",
                    data:{
                        "montantCons":$('input[name=montantCons]').val(),
                        "litre":$('input[name=litre]').val(),
                        "id_voiture" : id_voiture
                    },
                    dataType:"json",
                    success:function (row) {
                        myModal1.hide();
                        row.forEach(datas =>{
                            $('#DataTable_carburants tbody').prepend(`
                            <tr data-voiture="${datas.id}">
                                <td>${datas.litre}</td>
                                <td>${datas.montantCons}€</td>
                                <td>${Math.round(datas.montantCons/datas.litre)}€
                                <button class="btn btn-info editButon">modifier</button>
                                <button class="btn btn-danger delButon">supprimer</button></td>
                            </tr>
                        `)
                        })

                    }
                })
            }
        }
    })
}
var myModal = new bootstrap.Modal(document.getElementById('delModal'));
function supModal(row){
    let data = (window.location.pathname !== '/home') ? $(row).parent().parent().attr('data-voiture') : $(row).parent().attr('data-voiture');
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
