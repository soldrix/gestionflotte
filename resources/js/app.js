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
                    "next": "Suivant",
                    "previous": "Précédent"
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
    $(document).on('click','.delButton',function () {
        supModal(this)
    }).on('click','.editButton',function () {
        let db = $(this).parent().parent().attr('data-db');
        let dataid = (window.location.pathname.includes('/voiture/')) ? window.location.pathname.replace('/voiture/','') : $(this).parent().parent().attr('data-voiture');
        let url  = (db === 'voiture') ? '/getVoiture': (db === 'consommation') ? '/getConsommation' : (db === 'entretiens') ? '/getEntretiens' :(db === 'reparations') ? '/getReparations' :(db === 'assurance') ? '/getAssurance' :'';
        modal(db,'edit',url,dataid);
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

function modal(name,type,url,dataid) {

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
                    <label for="montantCons">Montant :</label>
                    <input type="text" name="montantCons" placeholder="Montant total" class="inputForm inputMontant" required>
                    <label for="litre">nombre de litres :</label>
                    <input type="text" name="litre" placeholder="Nombre de litre" class="inputForm inputDate" required>` : "";


    $('#AddModal').find('.modal-body').html(htmlModal)
    $('#AddModal .modal-header h5').html("Modal " + name)
    $('#AddModal').ready(function () {
        $('input[name=puissance]').mask('00000');
        $('input[name=immatriculation]').mask('SS-000-SS');
    })
    if (type=== "edit"){
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        })
        $.ajax({
            type:"POST",
            data:{
                id:dataid
            },
            dataType:'json',
            url:url,
            success:function (dataRow) {
                dataRow.forEach(datas =>{
                    if(url === '/getConsommation'){
                        $('input[name=montantCons]').val(datas.montantCons);
                        $('input[name=litre]').val(datas.litre);
                    }
                    if(url === '/getAssurance'){
                        $('input[name=nomAssu]').val(datas.nomAssu);
                        $('input[name=frais]').val(datas.frais);
                        $('input[name=debutAssu]').val(datas.debutAssu);
                        $('input[name=finAssu]').val(datas.finAssu);
                    }
                    if(url === '/getReparations'){
                        $('input[name=typeRep]').val(datas.typeRep);
                        $('input[name=dateRep]').val(datas.dateRep);
                        $('input[name=montantRep]').val(datas.montantRep);
                        $('input[name=garageRep]').val(datas.garageRep);
                        $('input[name=noteRep]').val(datas.noteRep);
                    }
                    if(url === '/getEntretiens'){
                        $('input[name=typeEnt]').val(datas.typeEnt);
                        $('input[name=dateEnt]').val(datas.dateEnt);
                        $('input[name=montantEnt]').val(datas.montantEnt);
                        $('input[name=garageEnt]').val(datas.garageEnt);
                        $('input[name=noteEnt]').val(datas.noteEnt);
                    }
                    if(url === '/getVoiture'){
                        $('input[name=marque]').val(datas.marque);
                        $('input[name=model]').val(datas.model);
                        $('input[name=puissance]').val(datas.puissance);
                        $('input[name=circulation]').val(datas.circulation);
                        $('input[name=carburant]').val(datas.carburant);
                        $('input[name=immatriculation]').val(datas.immatriculation);
                        if(datas.status === 'disponible'){
                            $('select[name=status]').children().first().prop('selected',true);
                        }else{
                            $('select[name=status]').children().last().prop('selected',true);
                        }
                    }
                })
                $('.btnModal').on('click',function () {
                    updateDatas(dataid,name);
                    // $(this).prop('disabled',true)
                })
                document.getElementById('AddModal').addEventListener('hide.bs.modal', function () {
                    $('.modal input').val('');
                    $('.btnModal').prop('disabled',false);
                })
            }
        })
    }
    if (type !== "edit"){
        $('.btnModal').on('click', function () {
            if ($(this).attr('type') === 'submit') {
                $('.modal.fade.show form').attr("action", "/addVoiture");
            } else {
                $.ajaxSetup({
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    }
                });
                let id_voiture = window.location.pathname.replace('/voiture/', '');
                if (name === 'assurance') {
                    $.ajax({
                        type: "POST",
                        url: "/voiture/addAssurance",
                        data: {
                            nomAssu: $('input[name=nomAssu]').val(),
                            debutAssu: $('input[name=debutAssu]').val(),
                            finAssu: $('input[name=finAssu]').val(),
                            frais: $('input[name=frais]').val(),
                            id_voiture: id_voiture
                        },
                        success: function (row) {
                            myModal1.hide();
                            row.forEach(datas => {
                                $('#DataTable_assurances tbody').prepend(`
                                <tr data-voiture="${datas.id}">
                                    <td>${datas.nomAssu}</td>
                                    <td>${datas.debutAssu}</td>
                                    <td>${datas.finAssu}</td>
                                    <td>${datas.frais}€
                                    <button class="btn btn-info editButon">modifier</button>
                                    <button class="btn btn-danger delButton">supprimer</button></td>
                                </tr>
                            `)
                            })
                        }
                    })
                }
                if (name === 'entretiens') {
                    let note = ($('input[name=noteEnt]').val() !== '' && $('input[name=noteEnt]').val() !== undefined) ? $('input[name=noteEnt]').val() : 'aucune note';
                    $.ajax({
                        type: "POST",
                        url: "/voiture/addEntretien",
                        data: {
                            noteEnt: note,
                            typeEnt: $('input[name=typeEnt]').val(),
                            dateEnt: $('input[name=dateEnt]').val(),
                            montantEnt: $('input[name=montantEnt]').val(),
                            garageEnt: $('input[name=garageEnt]').val(),
                            id_voiture: id_voiture
                        },
                        dataType: "json",
                        success: function (row) {
                            myModal1.hide();
                            row.forEach(datas => {
                                $('#DataTable_entretiens tbody').prepend(`
                                <tr data-voiture="${datas.id}">
                                    <td>${datas.garageEnt}</td>
                                    <td>${datas.typeEnt}</td>
                                    <td>${datas.montantEnt}€</td>
                                    <td>${datas.dateEnt}</td>
                                    <td>${datas.noteEnt}
                                    <button class="btn btn-info editButon">modifier</button>
                                    <button class="btn btn-danger delButton">supprimer</button></td>
                                </tr>
                            `)
                            })
                        }
                    })
                }
                if (name === 'reparations') {
                    let note = ($('input[name=noteRep]').val() !== '' && $('input[name=noteRep]').val() !== undefined) ? $('input[name=noteRep]').val() : 'aucune note';
                    $.ajax({
                        type: "POST",
                        url: "/voiture/addReparation",
                        data: {
                            noteRep: note,
                            typeRep: $('input[name=typeRep]').val(),
                            dateRep: $('input[name=dateRep]').val(),
                            montantRep: $('input[name=montantRep]').val(),
                            garageRep: $('input[name=garageRep]').val(),
                            id_voiture: id_voiture
                        },
                        dataType: "json",
                        success: function (row) {
                            myModal1.hide();
                            row.forEach(datas => {
                                $('#DataTable_reparations tbody').prepend(`
                                <tr data-voiture="${datas.id}">
                                    <td>${datas.garageRep}</td>
                                    <td>${datas.typeRep}</td>
                                    <td>${datas.montantRep}€</td>
                                    <td>${datas.dateRep}</td>
                                    <td>${datas.noteRep}
                                    <button class="btn btn-info editButon">modifier</button>
                                    <button class="btn btn-danger delButton">supprimer</button></td>
                                </tr>
                            `)
                            })
                        }
                    })
                }
                if (name === 'consommation') {
                    $.ajax({
                        type: "POST",
                        url: "/voiture/addConsommation",
                        data: {
                            montantCons: $('input[name=montantCons]').val(),
                            litre: $('input[name=litre]').val(),
                            id_voiture: id_voiture
                        },
                        dataType: "json",
                        success: function (row) {
                            myModal1.hide();
                            row.forEach(datas => {
                                $('#DataTable_carburants tbody').prepend(`
                                <tr data-voiture="${datas.id}">
                                    <td>${datas.litre}</td>
                                    <td>${datas.montantCons}€</td>
                                    <td>${Math.round(datas.montantCons / datas.litre)}€
                                    <button class="btn btn-info editButon">modifier</button>
                                    <button class="btn btn-danger delButton">supprimer</button></td>
                                </tr>
                            `)
                            })

                        }
                    })
                }
            }
        })
    }
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

function verifDatas(datas,type){
    let tab = {};
    if (type === "voiture"){
        if($('.modal.fade.show input[name=marque]').val() !=="" && $('.modal.fade.show input[name=model]').val() !== "" && $('.modal.fade.show input[name=puissance]').val() !== "" && $('.modal.fade.show input[name=carburant]').val()!=="" && $('.modal.fade.show input[name=immatriculation]').val()!=="" && $('.modal.fade.show input[name=circulation]').val()!==""){
            tab['id'] = datas;
            tab['marque'] = $('.modal.fade.show input[name=marque]').val();
            tab['model'] = $('.modal.fade.show input[name=model]').val();
            tab['puissance'] = $('.modal.fade.show input[name=puissance]').val();
            tab['carburant'] = $('.modal.fade.show input[name=carburant]').val();
            tab['immatriculation'] = $('.modal.fade.show input[name=immatriculation]').val();
            tab['circulation'] = $('.modal.fade.show input[name=circulation]').val();
            tab['status'] = $('.modal.fade.show select[name=status]').val();
        }else{
            if ($('.modal.fade.show input[name=marque]').val() === ""){
                $('.modal.fade.show input[name=marque]').css('border','2px solid red')
                $('.modal.fade.show input[name=marque]').parent().append(`
                    <p>Champ requis</p>
                `)
            }
            if ($('.modal.fade.show input[name=circulation]').val() === ""){
                $('.modal.fade.show input[name=circulation]').css('border','2px solid red')
                $('.modal.fade.show input[name=circulation]').parent().append(`
                    <p>Champ requis</p>
                `)
            }
            if ($('.modal.fade.show input[name=model]').val() === ""){
                $('.modal.fade.show input[name=model]').css('border','2px solid red')
                $('.modal.fade.show input[name=model]').parent().append(`
                    <p>Champ requis</p>
                `)
            }
            if ($('.modal.fade.show input[name=puissance]').val() === ""){
                $('.modal.fade.show input[name=puissance]').css('border','2px solid red')
                $('.modal.fade.show input[name=puissance]').parent().append(`
                    <p>Champ requis</p>
                `)
            }
            if ($('.modal.fade.show input[name=carburant]').val() === ""){
                $('.modal.fade.show input[name=carburant]').css('border','2px solid red')
                $('.modal.fade.show input[name=Carburant]').parent().append(`
                    <p>Champ requis</p>
                `)
            }
            if ($('.modal.fade.show input[name=immatriculation]').val() === ""){
                $('.modal.fade.show input[name=immatriculation]').css('border','2px solid red')
                $('.modal.fade.show input[name=immatriculation]').parent().append(`
                    <p>Champ requis</p>
                `)
            }
        }
    }
    if (type === "assurance"){
        if($('.modal.fade.show input[name=nomAssu]').val() !=="" && $('.modal.fade.show input[name=debutAssu]').val() !== "" && $('.modal.fade.show input[name=finAssu]').val() !== "" && $('.modal.fade.show input[name=frais]').val()!==""){
            tab['id'] = datas;
            tab['nomAssu'] = $('.modal.fade.show input[name=nomAssu]').val();
            tab['debutAssu'] = $('.modal.fade.show input[name=debutAssu]').val()
            tab['finAssu'] = $('.modal.fade.show input[name=finAssu]').val()
            tab['frais'] = $('.modal.fade.show input[name=frais]').val()
        }else{
            if ($('.modal.fade.show input[name=nomAssu]').val() === ""){
                $('.modal.fade.show input[name=nomAssu]').css('border','2px solid red')
                $('.modal.fade.show input[name=nomAssu]').parent().append(`
                    <p>Champ requis</p>
                `)
            }
            if ($('.modal.fade.show input[name=debutAssu]').val() === ""){
                $('.modal.fade.show input[name=debutAssu]').css('border','2px solid red')
                $('.modal.fade.show input[name=debutAssu]').parent().append(`
                    <p>Champ requis</p>
                `)
            }
            if ($('.modal.fade.show input[name=finAssu]').val() === ""){
                $('.modal.fade.show input[name=finAssu]').css('border','2px solid red')
                $('.modal.fade.show input[name=finAssu]').parent().append(`
                    <p>Champ requis</p>
                `)
            }
            if ($('.modal.fade.show input[name=frais]').val() === ""){
                $('.modal.fade.show input[name=frais]').css('border','2px solid red')
                $('.modal.fade.show input[name=frais]').parent().append(`
                    <p>Champ requis</p>
                `)
            }
        }
    }
    if (type === "entretiens"){
        if($('.modal.fade.show input[name=typeEnt]').val() !=="" && $('.modal.fade.show input[name=dateEnt]').val() !== "" && $('.modal.fade.show input[name=montantEnt]').val() !== "" && $('.modal.fade.show input[name=garageEnt]').val() !== ""){
            tab['id'] = datas;
            tab['typeEnt'] = $('.modal.fade.show input[name=typeEnt]').val();
            tab['dateEnt'] = $('.modal.fade.show input[name=dateEnt]').val();
            tab['montantEnt'] = $('.modal.fade.show input[name=montantEnt]').val();
            tab['garageEnt'] = $('.modal.fade.show input[name=garageEnt]').val();
            tab['noteEnt'] = ($('.modal.fade.show textarea[name=noteEnt]').val() !=="") ? $('.modal.fade.show textarea[name=noteEnt]').val() : 'aucune note';
        }else{
            if ($('.modal.fade.show input[name=typeEnt]').val() === ""){
                $('.modal.fade.show input[name=typeEnt]').css('border','2px solid red')
                $('.modal.fade.show input[name=typeEnt]').parent().append(`
                    <p>Champ requis</p>
                `)
            }
            if ($('.modal.fade.show input[name=dateEnt]').val() === ""){
                $('.modal.fade.show input[name=dateEnt]').css('border','2px solid red')
                $('.modal.fade.show input[name=dateEnt]').parent().append(`
                    <p>Champ requis</p>
              `)
            }
            if ($('.modal.fade.show input[name=montantEnt]').val() === ""){
                $('.modal.fade.show input[name=montantEnt]').css('border','2px solid red')
                $('.modal.fade.show input[name=montantEnt]').parent().append(`
                    <p>Champ requis</p>
                `)
            }
            if ($('.modal.fade.show input[name=garageEnt]').val() === ""){
                $('.modal.fade.show input[name=garageEnt]').css('border','2px solid red')
                $('.modal.fade.show input[name=garageEnt]').parent().append(`
                    <p>Champ requis</p>
                `)
            }
        }
    }
    if (type === "reparations"){
        if($('.modal.fade.show input[name=typeRep]').val() !=="" && $('.modal.fade.show input[name=dateRep]').val() !== "" && $('.modal.fade.show input[name=montantRep]').val() !== "" && $('.modal.fade.show input[name=garageRep]').val() !== ""){
            tab['id'] = datas;
            tab['typeRep'] = $('.modal.fade.show input[name=typeRep]').val();
            tab['dateRep'] = $('.modal.fade.show input[name=dateRep]').val();
            tab['montantRep'] = $('.modal.fade.show input[name=montantRep]').val();
            tab['garageRep'] = $('.modal.fade.show input[name=garageRep]').val();
            tab['noteRep'] = ($('.modal.fade.show textarea[name=noteRep]').val() !=="") ? $('.modal.fade.show textarea[name=noteRep]').val() : 'aucune note';
        }else{
            if ($('.modal.fade.show input[name=typeRep]').val() === ""){
                $('.modal.fade.show input[name=typeRep]').css('border','2px solid red')
                $('.modal.fade.show input[name=typeRep]').parent().append(`
                    <p>Champ requis</p>
                `)
            }
            if ($('.modal.fade.show input[name=dateRep]').val() === ""){
                $('.modal.fade.show input[name=dateRep]').css('border','2px solid red')
                $('.modal.fade.show input[name=dateRep]').parent().append(`
                    <p>Champ requis</p>
              `)
            }
            if ($('.modal.fade.show input[name=montantRep]').val() === ""){
                $('.modal.fade.show input[name=montantRep]').css('border','2px solid red')
                $('.modal.fade.show input[name=montantRep]').parent().append(`
                    <p>Champ requis</p>
                `)
            }
            if ($('.modal.fade.show input[name=garageRep]').val() === ""){
                $('.modal.fade.show input[name=garageRep]').css('border','2px solid red')
                $('.modal.fade.show input[name=garageRep]').parent().append(`
                    <p>Champ requis</p>
                `)
            }
        }
    }
    if (type === "consommation"){
        if($('.modal.fade.show input[name=montantCons]').val() !=="" && $('.modal.fade.show input[name=litre]').val() !== ""){
            tab['montantCons'] = $('.modal.fade.show input[name=montantCons]').val();
            tab['litre'] = $('.modal.fade.show input[name=litre]').val();
            tab['id'] = datas;
        }else{
            if($('.modal.fade.show input[name=montantCons]').val() ===""){
                $('.modal.fade.show input[name=montantCons]').css('border','2px solid red')
                $('.modal.fade.show input[name=montantCons]').parent().append(`
                    <p>Champ requis</p>
                `)
            }
            if($('.modal.fade.show input[name=litre]').val() === ""){
                $('.modal.fade.show input[name=litre]').css('border','2px solid red')
                $('.modal.fade.show input[name=litre]').parent().append(`
                    <p>Champ requis</p>
                `)
            }
        }
    }
    return tab;
}
function updateDatas(datas,type){
    let dataVerif =verifDatas(datas,type);
    console.log(dataVerif)
    if (dataVerif['id'] !== undefined){

        if (type === 'consommation'){
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });
            $.ajax({
                type:'POST',
                data:dataVerif,
                url:'/updateConsommation',
                dataType:'json',
                success:function (datas) {
                    myModal1.hide();
                    $("tr[data-voiture="+datas.id+"] td").eq(0).html(datas.litre);
                    $("tr[data-voiture="+datas.id+"] td").eq(1).html(datas.montantCons);
                    $("tr[data-voiture="+datas.id+"] td").eq(2).html(Math.round(datas.montantCons / datas.litre)+'€');

                }
            })
        }
        if (type === 'assurance'){
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });
            $.ajax({
                type:'POST',
                data:dataVerif,
                url:'/updateAssurance',
                dataType:'json',
                success:function (datas) {
                    myModal1.hide();
                    $("tr[data-voiture="+datas.id+"] td").eq(0).html(datas.nomAssu);
                    $("tr[data-voiture="+datas.id+"] td").eq(1).html(datas.debutAssu);
                    $("tr[data-voiture="+datas.id+"] td").eq(2).html(datas.finAssu);
                    $("tr[data-voiture="+datas.id+"] td").eq(3).html(datas.frais);

                }
            })
        }
        if (type === 'entretiens'){
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });
            $.ajax({
                type:'POST',
                data:dataVerif,
                url:'/updateEntretiens',
                dataType:'json',
                success:function (datas) {
                    myModal1.hide();
                    $("tr[data-voiture="+datas.id+"] td").eq(0).html(datas.garageEnt);
                    $("tr[data-voiture="+datas.id+"] td").eq(1).html(datas.typeEnt);
                    $("tr[data-voiture="+datas.id+"] td").eq(2).html(datas.montantEnt);
                    $("tr[data-voiture="+datas.id+"] td").eq(3).html(datas.dateEnt);
                    $("tr[data-voiture="+datas.id+"] td").eq(4).html((datas.noteEnt !== "") ? datas.noteEnt : 'aucune note');

                }
            })
        }
        if (type === 'reparations'){
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });
            $.ajax({
                type:'POST',
                data:dataVerif,
                url:'/updateReparations',
                dataType:'json',
                success:function (datas) {
                    myModal1.hide();
                    $("tr[data-voiture="+datas.id+"] td").eq(0).html(datas.garageRep);
                    $("tr[data-voiture="+datas.id+"] td").eq(1).html(datas.typeRep);
                    $("tr[data-voiture="+datas.id+"] td").eq(2).html(datas.montantRep);
                    $("tr[data-voiture="+datas.id+"] td").eq(3).html(datas.dateRep);
                    $("tr[data-voiture="+datas.id+"] td").eq(4).html((datas.noteRep !== "") ? datas.noteRep : 'aucune note');

                }
            })
        }
        if (type === 'voiture'){
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });
            $.ajax({
                type:'POST',
                data:dataVerif,
                url:'/updateVoiture',
                dataType:'json',
                success:function (datas) {
                    myModal1.hide();
                    $("div[data-voiture="+datas.id+"] h2 span").eq(0).html(datas.immatriculation);
                    $("div[data-voiture="+datas.id+"] div.col-6 div.col-auto:nth-child(2) h2").eq(0).html(datas.marque);
                    $("div[data-voiture="+datas.id+"] div.col-6 div.col-auto:nth-child(2) h2").eq(1).html(datas.model);
                    $("div[data-voiture="+datas.id+"] div.col-6 div.col-auto:nth-child(2) h2").eq(2).html(datas.circulation);
                    $("div[data-voiture="+datas.id+"] div.col-6 div.col-auto:nth-child(2) h2").eq(3).html(datas.status);
                    $("div[data-voiture="+datas.id+"] div.col-6 div.col-auto:nth-child(2) h2").eq(4).html(datas.puissance);

                }
            })
            let files =  $('.modal.fade.show input[name=file]')[0].files;
            if (files.length > 0){
                let fd = new FormData();
                fd.append('file',files[0]);
                fd.append('id',dataVerif['id']);
                fd.append('_token',$('meta[name="csrf-token"]').attr('content'));
                $.ajax({
                    type:'POST',
                    data: fd,
                    contentType:false,
                    processData:false,
                    url:'/uploadImage',
                    dataType:'json',
                    success:function (datas) {
                        myModal1.hide();
                        $("div[data-voiture="+datas.id+"]").parent().children().first().children().attr('src','http://127.0.0.1:8000/storage/'+datas.image);
                    }
                })
            }

        }
    }
}
