require('datatables.net-bs5');
window.bootstrap = require('bootstrap/dist/js/bootstrap.bundle.js');
require('jquery-mask-plugin/dist/jquery.mask.js')
let myModal3;
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
    //todo faire  insertion en ajax

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
        let urlName = window.location.pathname.replace('/','');
        modal(urlName,'add')
        myModal3 = new bootstrap.Modal(document.getElementById( urlName.replace(urlName[0],urlName[0].toUpperCase())+'Modal'));
        myModal3.show();
    })

})
function eventModif(){
    $('.delButton').off().on('click',function () {
        supModal(this)
    })
    $('.editButton').off().on('click',function () {
        let db = $(this).parent().parent().attr('data-db');
        let dataid = $(this).parent().parent().attr('data-voiture');
        let url  = (db === 'voiture') ? '/getVoiture': (db === 'consommation') ? '/getConsommation' : (db === 'entretiens') ? '/getEntretiens' :(db === 'reparations') ? '/getReparations' :(db === 'assurance') ? '/getAssurance' :'';
        modal(db,'edit',url,dataid);
    })
}
$(window).on('load',function () {
    eventModif()
})

let myModal1 = new bootstrap.Modal(document.getElementById('AddModal'));

function modal(name,type,url,dataid) {

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

    if(window.location.pathname.match('voiture') && type === "add" || window.location.pathname.match('home') && type === "add" || type !== 'add'){
        myModal1.show();
        $('#AddModal').find('.modal-body').html(htmlModal)
        $('#AddModal .modal-header h5').html("Modal " + name)
        $('#AddModal').ready(function () {
            $('input[name=puissance]').mask('00000');
            $('input[name=immatriculation]').mask('SS-000-SS');
        })
    }
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
                $('.btnModal').off().on('click',function () {
                    $(this).prop('disabled',true);
                    updateDatas(dataid,name);
                })

            }
        })
    }
    if (type !== "edit"){
        $('.btnModal').off().on('click', function () {
            $(this).prop('disabled',true);
            updateDatas('',name,'add');
            if(!window.location.pathname.match('voiture') && !window.location.pathname.match('home')){
                document.getElementById(name.replace(name[0],name[0].toUpperCase())+'Modal').addEventListener('hide.bs.modal', function () {
                    $('.modal input').val('');
                    $('.btnModal').prop('disabled',false);
                })
            }
        })
    }
    document.getElementById('AddModal').addEventListener('hide.bs.modal', function () {
        $('.modal input').val('');
        $('.btnModal').prop('disabled',false);
    })
}
var myModal = new bootstrap.Modal(document.getElementById('delModal'));
function supModal(row){
    let data = (window.location.pathname !== '/home') ? $(row).parent().parent().attr('data-voiture') : $(row).parent().attr('data-voiture');
    let db = (window.location.pathname !== '/home') ? $(row).parent().parent().attr('data-db') : $(row).parent().attr('data-db');
    myModal.show();
    $('#btnDelModal').on('click',function () {

        let url  = (db === 'voiture') ? '/delVoiture': (db === 'consommation') ? '/delConsommation' : (db === 'entretiens') ? '/delEntretiens' :(db === 'reparations') ? '/delReparations' :(db === 'assurance') ? '/delAssurance' :'';
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

function verifDatas(datas,page,type){
    let tab = {};
    if (page === "voiture"){
        if($('.modal.fade.show input[name=marque]').val() !=="" && $('.modal.fade.show input[name=model]').val() !== "" && $('.modal.fade.show input[name=puissance]').val() !== "" && $('.modal.fade.show input[name=carburant]').val()!=="" && $('.modal.fade.show input[name=immatriculation]').val()!=="" && $('.modal.fade.show input[name=circulation]').val()!==""){
            if (type === 'add' && $('.modal.fade.show input[name=file]')[0].files.length < 1){
                if ($('.modal.fade.show input[name=file]').val() === ""){
                    $('.modal.fade.show input[name=file]').css('border','2px solid red')
                    $('.modal.fade.show input[name=file]').parent().append(`
                        <p>Champ requis</p>
                    `)
                }
            }else{
                tab['id'] = (type === 'add') ? '' : datas;
                tab['marque'] = $('.modal.fade.show input[name=marque]').val();
                tab['model'] = $('.modal.fade.show input[name=model]').val();
                tab['puissance'] = $('.modal.fade.show input[name=puissance]').val();
                tab['carburant'] = $('.modal.fade.show input[name=carburant]').val();
                tab['immatriculation'] = $('.modal.fade.show input[name=immatriculation]').val();
                tab['circulation'] = $('.modal.fade.show input[name=circulation]').val();
                tab['status'] = $('.modal.fade.show select[name=status]').val();
            }

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
    if (page === "assurance"){
        if($('.modal.fade.show input[name=nomAssu]').val() !=="" && $('.modal.fade.show input[name=debutAssu]').val() !== "" && $('.modal.fade.show input[name=finAssu]').val() !== "" && $('.modal.fade.show input[name=frais]').val()!==""){

            if (type === 'add'){
                tab['id_voiture'] = (window.location.pathname.match('voiture')) ? window.location.pathname.replace('/voiture/' ,'') : $('.modal.fade.show select[name=id_voiture]').val();
            }else{
                tab['id'] = datas;
            }
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
    if (page === "entretiens"){
        if($('.modal.fade.show input[name=typeEnt]').val() !=="" && $('.modal.fade.show input[name=dateEnt]').val() !== "" && $('.modal.fade.show input[name=montantEnt]').val() !== "" && $('.modal.fade.show input[name=garageEnt]').val() !== ""){
            if (type === 'add'){
                tab['id_voiture'] = (window.location.pathname.match('voiture')) ? window.location.pathname.replace('/voiture/' ,'') : $('.modal.fade.show select[name=id_voiture]').val();
            }else{
                tab['id'] = datas;
            }
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
    if (page === "reparations"){
        if($('.modal.fade.show input[name=typeRep]').val() !=="" && $('.modal.fade.show input[name=dateRep]').val() !== "" && $('.modal.fade.show input[name=montantRep]').val() !== "" && $('.modal.fade.show input[name=garageRep]').val() !== ""){
            if (type === 'add'){
                tab['id_voiture'] = (window.location.pathname.match('voiture')) ? window.location.pathname.replace('/voiture/' ,'') : $('.modal.fade.show select[name=id_voiture]').val();
            }else{
                tab['id'] = datas;
            }
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
    if (page === "consommation"){
        if($('.modal.fade.show input[name=montantCons]').val() !=="" && $('.modal.fade.show input[name=litre]').val() !== ""){
            tab['montantCons'] = $('.modal.fade.show input[name=montantCons]').val();
            tab['litre'] = $('.modal.fade.show input[name=litre]').val();
            if (type === 'add'){
                tab['id_voiture'] = (window.location.pathname.match('voiture')) ? window.location.pathname.replace('/voiture/' ,'') : $('.modal.fade.show select[name=id_voiture]').val();
            }else{
                tab['id'] = datas;
            }
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
function updateDatas(datas,page,type){
    let dataVerif =verifDatas(datas,page,type);
    let urlAjax = (type === 'add' && page === 'consommation') ? '/addConsommation': (type !== 'add' && page === 'consommation') ? '/updateConsommation' :
        (type === 'add' && page === 'entretiens') ? '/addEntretiens' : (type !== 'add' && page === 'entretiens') ? '/updateEntretiens' :
        (type === 'add' && page === 'assurance') ? '/addAssurance' : (type !== 'add' && page === 'assurance') ? '/updateAssurance' :
        (type === 'add' && page === 'reparations') ? '/addReparations' : (type !== 'add' && page === 'reparations') ? '/updateReparations' :
        (type === 'add' && page === 'voiture') ? '/addVoiture' : (type !== 'add' && page ==='voiture') ? '/updateVoiture' : '';
    if (dataVerif['id'] !== undefined || dataVerif['id_voiture'] !== undefined){
        if (page === 'consommation'){
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });
            $.ajax({
                type:'POST',
                data:dataVerif,
                url: urlAjax,
                dataType:'json',
                success:function (datas) {
                    myModal1.hide();
                    myModal3.hide();
                    $("tr[data-voiture="+datas.id+"] td").eq(0).html(datas.litre);
                    $("tr[data-voiture="+datas.id+"] td").eq(1).html(datas.montantCons);
                    $("tr[data-voiture="+datas.id+"] td").eq(2).html(Math.round(datas.montantCons / datas.litre)+'€');
                    eventModif()
                }
            })
        }
        if (page === 'assurance'){
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });
            $.ajax({
                type:'POST',
                data:dataVerif,
                url:urlAjax,
                dataType:'json',
                success:function (datas) {
                    myModal1.hide();
                    myModal3.hide();
                    $("tr[data-voiture="+datas.id+"] td").eq(0).html(datas.nomAssu);
                    $("tr[data-voiture="+datas.id+"] td").eq(1).html(datas.debutAssu);
                    $("tr[data-voiture="+datas.id+"] td").eq(2).html(datas.finAssu);
                    $("tr[data-voiture="+datas.id+"] td").eq(3).html(datas.frais);
                    eventModif();
                }
            })
        }
        if (page === 'entretiens'){
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });
            $.ajax({
                type:'POST',
                data:dataVerif,
                url:urlAjax,
                dataType:'json',
                success:function (rowData) {
                    myModal1.hide();
                    myModal3.hide();
                    rowData.forEach(datas=>{
                        let table = $('#DataTable_entretiens').DataTable();
                        if(type !== 'add'){
                            table.row($("tr[data-voiture='"+datas.id+"']"))
                                .remove()
                                .draw();
                        }
                        let tab = [datas.garageEnt,datas.typeEnt,datas.montantEnt+'€',datas.dateEnt];
                        if(!window.location.pathname.match('voiture')){
                            tab.push(datas.immatriculation);
                        }
                        tab.push(datas.noteEnt+`<button class="btn btn-info editButton">modifier</button>
                        <button class="btn btn-danger delButton">supprimer</button>`)
                        let row = table.row.add(tab).node();
                        $(row).attr({"data-voiture":datas.id,"data-db":page})
                        table.draw();
                        eventModif();
                    })
                }
            })
        }
        if (page === 'reparations'){
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });
            $.ajax({
                type:'POST',
                data:dataVerif,
                url:urlAjax,
                dataType:'json',
                success:function (datas) {
                    myModal1.hide();
                    myModal3.hide();
                    $("tr[data-voiture="+datas.id+"] td").eq(0).html(datas.garageRep);
                    $("tr[data-voiture="+datas.id+"] td").eq(1).html(datas.typeRep);
                    $("tr[data-voiture="+datas.id+"] td").eq(2).html(datas.montantRep);
                    $("tr[data-voiture="+datas.id+"] td").eq(3).html(datas.dateRep);
                    $("tr[data-voiture="+datas.id+"] td").eq(4).html((datas.noteRep !== "") ? datas.noteRep : 'aucune note');
                    eventModif();

                }
            })
        }
        if (page === 'voiture'){
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });
            let files = ($(".modal.fade.show input[name=file]").get(0).files.length !== 0) ? $('.modal.fade.show input[name=file]')[0].files[0] : 0;
            let fd = new FormData();
            if (files !== 0){
                fd.append('file',files);
            }
            Object.keys(dataVerif).forEach(function(key) {
                fd.append(key,dataVerif[key]);
            });
            $.ajax({
                type:'POST',
                data: fd,
                contentType:false,
                processData:false,
                url:urlAjax,
                dataType:'json',
                success:function (rowData) {
                    if(type !== 'add'){
                        rowData.forEach(datas =>{
                            $("div[data-voiture="+datas.id+"]").parent().children().first().children().attr('src','http://127.0.0.1:8000/storage/'+datas.image);
                            $("div[data-voiture="+datas.id+"] h2 span").eq(0).html(datas.immatriculation);
                            $("div[data-voiture="+datas.id+"] div.col-6 div.col-auto:nth-child(2) h2").eq(0).html(datas.marque);
                            $("div[data-voiture="+datas.id+"] div.col-6 div.col-auto:nth-child(2) h2").eq(1).html(datas.model);
                            $("div[data-voiture="+datas.id+"] div.col-6 div.col-auto:nth-child(2) h2").eq(2).html(datas.circulation);
                            $("div[data-voiture="+datas.id+"] div.col-6 div.col-auto:nth-child(2) h2").eq(3).html(datas.status);
                            $("div[data-voiture="+datas.id+"] div.col-6 div.col-auto:nth-child(2) h2").eq(4).html(datas.puissance);
                            $("div[data-voiture="+datas.id+"] div.col-6 div.col-auto:nth-child(2) h2").eq(5).html(datas.carburant);
                        })
                    }
                    if(type === 'add'){
                        rowData.forEach(datas=>{
                            $('.container.d-flex').append(`
                         <div class="col-2 d-flex flex-column  p-2 rounded m-2 blockVoiture" style="background: #e4e4e4" data-voiture="${datas.id}">
                            <img src="http://127.0.0.1:8000/storage/${datas.image}" alt="" class="rounded">
                            <p class="text-center">${datas.model}</p>
                            <a  class="btn btn-primary w-75 align-self-center mt-3 btn-info-car" href="http://127.0.0.1:8000/voiture/${datas.id}">
                                En savoir plus
                            </a>
                            <button class="btn btn-danger delButton w-75 mt-2 align-self-center">Supprimer</button>
                        </div>
                        `)
                        })

                    }
                    myModal1.hide();
                    eventModif();
                }
            })




        }
    }else{
        console.log(dataVerif)
    }
}
