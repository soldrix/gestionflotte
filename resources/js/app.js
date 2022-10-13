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
        let db = $(this).parent().parent().parent().attr('data-db');
        let dataid = $(this).parent().parent().parent().attr('data-voiture');
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
        `

                    <div class="d-flex flex-wrap align-items-baseline">
                        <label class="me-2" for="marque">Marque :</label>
                        <input type="text" name="marque" placeholder="Marque" class="mb-2 me-2 inputForm inputText"  required>
                    </div>
                    <div class="d-flex flex-wrap align-items-baseline">
                        <label class="me-2" for="model">Model :</label>
                        <input type="text" name="model" placeholder="Model" class="mb-2 inputForm inputText" required>
                    </div>
                    <div class="d-flex flex-wrap align-items-baseline">
                        <label class="me-2" for="carburant">Type de carburant :</label>
                        <input type="text" name="carburant" placeholder="Carburant ex:(diesel)" class="mb-2 me-2 inputText inputForm" required>
                    </div>
                    <div class="d-flex flex-wrap align-items-baseline">
                        <label class="me-2" for="cicrculation">Mise en circulation :</label>
                        <input type="text" name="circulation" placeholder="Date circulation" class="mb-2 inputCirc inputDate inputForm" required>
                    </div>
                    <div class="d-flex flex-wrap align-items-baseline">
                        <label class="me-2" for="immatriculation">Immatriculation du véhicule :</label>
                        <input type="text" name="immatriculation" placeholder="Immatriculation" class="mb-2 me-2 inputIm inputForm" required>
                    </div>
                    <div class="d-flex flex-wrap align-items-baseline">
                        <label class="me-2" for="puissance">Nombre de chevaux :</label>
                        <input type="text" name="puissance" placeholder="Puissance ex:(100cc)" class="mb-2 inputPuissance inputForm" required>
                    </div>
                    <div class="d-flex flex-wrap align-items-baseline">
                        <label class="me-2" for="status">Status du véhicule :</label>
                        <select name="status" id="voitureSatut" class="mb-2 me-2">
                            <option value="disponible">Disponible</option>
                            <option value="indisponible">Indisponible</option>
                        </select>
                    </div>
                    <div class="d-flex flex-wrap align-items-baseline">
                        <label class="me-2" for="file">Image du véhicule :</label>
                        <input type="file" name="file" accept="image/png, image/jpeg, image/jpg" class="mb-2 inputFile inputForm" required>
                    </div>
                   `
        : (name === "assurance") ?
            `
                    <div class="d-flex flex-wrap align-items-baseline">
                        <label class="me-2" for="nomAssu">Nom de l'assurance :</label>
                        <input type="text" name="nomAssu" placeholder="Nom assurance" class="inputForm inputText mb-2" required>
                    </div>
                    <div class="d-flex flex-wrap align-items-baseline">
                        <label class="me-2" for="debutAssu">Date de début :</label>
                        <input type="text" name="debutAssu" placeholder="Debut assurance" class="inputForm inputDate assuDateD mb-2" required>
                    </div>
                    <div class="d-flex flex-wrap align-items-baseline">
                        <label class="me-2" for="finAssu">Date de fin :</label>
                        <input type="text" name="finAssu" placeholder="Fin assurance"  class="inputForm inputDate assuDateF mb-2" required>
                    </div>
                    <div class="d-flex">
                        <label class="me-2" for="frais">Frais de l'assurance :</label>
                        <input type="text" name="frais" placeholder="Frais assurance" class="inputForm  inputNumber mb-2" required>
                    </div>`
            : (name === "entretiens") ?
                `
                    <div class="d-flex flex-wrap align-items-baseline">
                        <label class="me-2" for="typeEnt">Type d'entretien :</label>
                        <input type="text" name="typeEnt" placeholder="Type ex:(vidange)" class="inputForm inputText mb-2" required>
                    </div>
                    <div class="d-flex flex-wrap align-items-baseline">
                        <label class="me-2" for="dateEnt">Date de l'entretien :</label>
                        <input type="text" name="dateEnt" placeholder="Date Entretiens" class="inputForm inputDate mb-2" required>
                    </div>
                    <div class="d-flex flex-wrap align-items-baseline">
                        <label class="me-2" for="montantEnt">Montant de l'entretien :</label>
                        <input type="text" name="montantEnt" placeholder="Montant total" class="inputForm inputNumber mb-2" required>
                    </div>
                    <div class="d-flex flex-wrap align-items-baseline">
                        <label class="me-2" for="garageEnt">Nom du garage :</label>
                        <input type="text" name="garageEnt" placeholder="Garage" class="inputForm inputText  mb-2" required>
                    </div>
                    <div class="d-flex flex-column">
                        <label class="me-2" for="noteEnt">Note supplémentaire :</label>
                        <textarea name="noteEnt" id="noteEnt" cols="30" rows="4" class="inputForm inputText mb-2"></textarea>
                    </div>`
                : (name === "reparations") ?
                    `
                    <div class="d-flex flex-wrap align-items-baseline">
                        <label class="me-2" for="typeRep">Type de réparation :</label>
                        <input type="text" name="typeRep" placeholder="Type ex:(vidange)" class="inputForm inputText mb-2" required>
                    </div>
                    <div class="d-flex flex-wrap align-items-baseline">
                        <label class="me-2" for="dateRep">Date de la réparation :</label>
                        <input type="text" name="dateRep" placeholder="Date Reparations" class="inputForm inputDate mb-2" required>
                    </div>
                    <div class="d-flex flex-wrap align-items-baseline">
                        <label class="me-2" for="montantRep">Montant de la réparation :</label>
                        <input type="text" name="montantRep" placeholder="Montant total" class="inputForm inputNumber mb-2" required>
                    </div>
                    <div class="d-flex flex-wrap align-items-baseline">
                        <label class="me-2" for="garageRep">Nom du garage :</label>
                        <input type="text" name="garageRep" placeholder="Garage" class="inputForm inputText mb-2" required>
                    </div>
                    <div class="d-flex flex-column">
                        <label class="me-2" for="noteRep">Note supplémentaire :</label>
                        <textarea name="noteRep" id="noteRep" cols="30" rows="4" class="inputForm inputText mb-2"></textarea>
                    </div>
                    `
                    : (name === "consommation") ?
                        `
                    <div class="d-flex flex-wrap align-items-baseline">
                        <label class="me-2" for="montantCons">Montant :</label>
                        <input type="text" name="montantCons" placeholder="Montant total" class="inputForm inputNumber mb-2" required>
                    </div>
                    <div class="d-flex flex-wrap align-items-baseline">
                        <label class="me-2" for="litre">nombre de litres :</label>
                        <input type="text" name="litre" placeholder="Nombre de litre" class="inputForm inputNumber mb-2" required>
                    </div>` : "";

    if(window.location.pathname.match('voiture') && type === "add" || window.location.pathname.match('home') && type === "add" || type !== 'add'){
        myModal1.show();
        $('#AddModal').find('.modal-body').html(htmlModal)
        $('#AddModal').ready(function () {
            $('input[name=puissance]').mask('00000');
            $('input[name=immatriculation]').mask('SS-000-SS');
        })
    }
    $('#AddModal').ready(function () {
        $('.inputDate').mask('00/00/0000', {placeholder: "__/__/____"});
        let bigregex = "A";
        for (let i = 0; i < 99; i++) {
            bigregex = bigregex + "A";
        }
        $('.inputText').mask(bigregex)
        bigregex = '0';
        for (let i = 0; i < 99 ; i++) {
            bigregex += "0";
        }
        $('input[name=litre]').mask(bigregex)

    })
    if (type=== "edit"){
        $('#AddModal .modal-header h3').html((name === 'entretiens' || name === 'assurance') ? "Modifier l' " + name : "Modifier la " + name)
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
                        $('input[name=debutAssu]').val(reverseDate(datas.debutAssu));
                        $('input[name=finAssu]').val(reverseDate(datas.finAssu));
                    }
                    if(url === '/getReparations'){
                        $('input[name=typeRep]').val(datas.typeRep);
                        $('input[name=dateRep]').val(reverseDate(datas.dateRep));
                        $('input[name=montantRep]').val(datas.montantRep);
                        $('input[name=garageRep]').val(datas.garageRep);
                        $('input[name=noteRep]').val(datas.noteRep);
                    }
                    if(url === '/getEntretiens'){
                        $('input[name=typeEnt]').val(datas.typeEnt);
                        $('input[name=dateEnt]').val(reverseDate(datas.dateEnt));
                        $('input[name=montantEnt]').val(datas.montantEnt);
                        $('input[name=garageEnt]').val(datas.garageEnt);
                        $('input[name=noteEnt]').val(datas.noteEnt);
                    }
                    if(url === '/getVoiture'){
                        $('input[name=marque]').val(datas.marque);
                        $('input[name=model]').val(datas.model);
                        $('input[name=puissance]').val(datas.puissance);
                        $('input[name=circulation]').val(reverseDate(datas.circulation));
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
                    setTimeout(()=>{
                        $('.btnModal').prop('disabled',false);
                    },2000)
                })

            }
        })
    }
    if (type !== "edit"){
        $('#AddModal .modal-header h3').html((name === 'entretiens') ? "Ajouter un " + name : "Ajouter une " + name)
        $('.btnModal').off().on('click', function () {
            $(this).prop('disabled',true);
            setTimeout(()=>{
                $('.btnModal').prop('disabled',false);
            },2000)
            updateDatas('',name,'add');
            if(!window.location.pathname.match('voiture') && !window.location.pathname.match('home')){
                document.getElementById(name.replace(name[0],name[0].toUpperCase())+'Modal').addEventListener('hide.bs.modal', function () {
                    $('.modal input').val('');
                    $('.modal input').removeClass('active');
                    $('.text-danger').remove();
                })
            }
        })
    }
    document.getElementById('AddModal').addEventListener('hide.bs.modal', function () {
        $('.modal input').val('');
        $('.modal input').removeClass('active');
        $('.text-danger').remove();
    })
}
var myModal = new bootstrap.Modal(document.getElementById('delModal'));
var delToastEl = document.getElementById('toastSupp');
var delToast = bootstrap.Toast.getOrCreateInstance(delToastEl);
function supModal(row){
    let data = (window.location.pathname !== '/home') ? $(row).parent().parent().parent().attr('data-voiture') : $(row).parent().attr('data-voiture');
    let db = (window.location.pathname !== '/home') ? $(row).parent().parent().parent().attr('data-db') : $(row).parent().attr('data-db');
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
                    delToast.show();
                }
            })
        }

    })

}

function verifDatas(datas,page,type){
     //pour inverser une date
    function reverseDate(d){
        d = d.val().split('/');
        let date =d[2]+'-'+d[1]+'-'+d[0];
        return (new Date(date) instanceof Date && !isNaN(new Date(date)) && d[2] >= new Date().getFullYear() - 122) ? date : false;
    }
    //function pour ajouter message erreur
    function draw_error(s,i,t,o){
        //s = selector
        //i = id error
        //t = type
        //o = other
        if(t === undefined || t === ''){
            if($('#'+i).length <= 0 && s.val() ===''){
                s.addClass('active');
                s.parent().append(`
                <p id='${i}' class='text-danger'>Champ requis</p>
            `);
            }
        }
        if(t === 'nb'){
            if($('#'+i).length <= 0 && isNaN(s.val().replaceAll(',','.')) || s.val() ===''){
                s.addClass('active')
                s.parent().append(`
                    <p id='${i}' class='text-danger'>Champ requis et doit correspondre à exemple:(151,15 ou 151)</p>
                `)
            }
        }
        if(t === 'dateDebut' || t === 'dateFin'){
            if($('#'+i).length <= 0 && reverseDate(o) >= reverseDate(s) || reverseDate(s) === false ) {
                s.addClass('active')
                let html = (t === 'dateDebut') ? 'Champ requis ,doit être plus petite que la date de fin et doit être une date valide' : 'Champ requis ,doit être plus grand que la date de début et doit être une date valide';
                s.parent().append(`
                    <p id='${i}' class='text-danger'> ${html}</p>
                `)
            }
        }
        if(t === 'date'){
            if($('#'+i).length <= 0 && reverseDate(s) === false || s.val() === ""){
                s.addClass('active')
                s.parent().append(`
                    <p id='${i}' class='text-danger'>Champ requis et doit être une date valide</p>
                `)
            }
        }
    }

    let tab = {};
    let idVoiture = (window.location.pathname.match('voiture')) ? window.location.pathname.replace('/voiture/' ,'') : $('.modal.fade.show select[name=id_voiture]').val();
    if (page === "voiture"){
        let marque = $('.modal.fade.show input[name=marque]');
        let model = $('.modal.fade.show input[name=model]');
        let puissance = $('.modal.fade.show input[name=puissance]');
        let carburant = $('.modal.fade.show input[name=carburant]');
        let immatriculation = $('.modal.fade.show input[name=immatriculation]');
        let circulation = $('.modal.fade.show input[name=circulation]');
        let imageFile = $('.modal.fade.show input[name=file]');
        if(marque.val() !=="" && model.val() !== "" && puissance.val() !== "" && carburant.val()!=="" && immatriculation.val()!=="" && circulation.val()!=="" && reverseDate(circulation) !== false){
            if (type === 'add' && imageFile[0].files.length <= 0){
                if($('#error_image').length <= 0){
                    imageFile.addClass('active');
                    imageFile.parent().append(`
                    <p id='error_image' class='text-danger'>Champ requis</p>
                `);
                }
            }else{

                tab['id'] = (type === 'add') ? '' : datas;
                tab['marque'] = marque.val();
                tab['model'] = model.val();
                tab['puissance'] = puissance.val();
                tab['carburant'] = carburant.val();
                tab['immatriculation'] = immatriculation.val();
                tab['circulation'] = reverseDate(circulation);
                tab['status'] = $('.modal.fade.show select[name=status]').val();
            }

        }else{
            if (type === 'add' && imageFile[0].files.length <= 0){
                if($('#error_image').length <= 0){
                    imageFile.addClass('active');
                    imageFile.parent().append(`
                    <p id='error_image' class='text-danger'>Champ requis</p>
                `);
                }
            }
            draw_error(marque,'error_marque')
            draw_error(circulation,'error_circulation','date')
            draw_error(model,'error_model')
            draw_error(puissance,'error_puissance')
            draw_error(carburant,'error_carburant')
            draw_error(immatriculation,'error_immatricualtion')
        }
    }
    if (page === "assurance"){
        let nomAssu = $('.modal.fade.show input[name=nomAssu]');
        let debutAssu = $('.modal.fade.show input[name=debutAssu]');
        let finAssu = $('.modal.fade.show input[name=finAssu]');
        let frais = $('.modal.fade.show input[name=frais]');
        let debutAssuVal = reverseDate(debutAssu);
        let finAssuVal = reverseDate(finAssu);
        if(nomAssu.val() !=="" && debutAssu.val() !== "" && finAssu.val() !== "" && frais.val()!=="" && !isNaN(frais.val().replaceAll(',','.')) && frais.val().replaceAll(',','.') > 0 && debutAssuVal < finAssuVal && reverseDate(debutAssu) !== false && reverseDate(finAssu) !== false){
            if (type === 'add'){
                tab['id_voiture'] = idVoiture;
            }else{
                tab['id'] = datas;
            }
            tab['nomAssu'] = nomAssu.val();
            tab['debutAssu'] = debutAssuVal;
            tab['finAssu'] = finAssuVal;
            tab['frais'] = frais.val().replaceAll(',',".");
        }else{
            draw_error(nomAssu,'error_nomAssu');
            draw_error(debutAssu,'error_debutAssu','dateDebut',finAssu);
            draw_error(finAssu,'error_finAssu','dateFin',debutAssu);
            draw_error(frais,'error_frais','nb');
        }
    }
    if (page === "entretiens"){
        let typeEnt = $('.modal.fade.show input[name=typeEnt]');
        let dateEnt = $('.modal.fade.show input[name=dateEnt]');
        let montantEnt = $('.modal.fade.show input[name=montantEnt]');
        let garageEnt = $('.modal.fade.show input[name=garageEnt]');
        let noteEnt = $('.modal.fade.show textarea[name=noteEnt]');
        if(typeEnt.val() !=="" && dateEnt.val() !== "" && reverseDate(dateEnt) !== false && montantEnt.val() !== "" && garageEnt.val() !== "" && !isNaN(montantEnt.val().replaceAll(',','.')) && montantEnt.val().replaceAll(',','.') > 0){
            if (type === 'add'){
                tab['id_voiture'] = idVoiture;
            }else{
                tab['id'] = datas;
            }
            tab['typeEnt'] = typeEnt.val();
            tab['dateEnt'] = reverseDate(dateEnt);
            tab['montantEnt'] = montantEnt.val().replaceAll(',','.');
            tab['garageEnt'] = garageEnt.val();
            tab['noteEnt'] = (noteEnt.val() !=="") ? noteEnt.val() : 'aucune note';
        }else{
            draw_error(typeEnt,'error_typeEnt')
            draw_error(dateEnt,'error_dateEnt','date')
            draw_error(montantEnt,'error_montantEnt','nb')
            draw_error(garageEnt,'error_garageEnt')
        }
    }
    if (page === "reparations"){
        let typeRep = $('.modal.fade.show input[name=typeRep]');
        let dateRep = $('.modal.fade.show input[name=dateRep]');
        let montantRep = $('.modal.fade.show input[name=montantRep]');
        let garageRep = $('.modal.fade.show input[name=garageRep]');
        let noteRep = $('.modal.fade.show textarea[name=noteRep]');
        if(typeRep.val() !=="" && dateRep.val() !== ""  && montantRep.val() !== "" && reverseDate(dateRep) !== false && garageRep.val() !== "" && !isNaN(montantRep.val().replaceAll(',','.')) && montantRep.val().replaceAll(',','.') > 0){
            if (type === 'add'){
                tab['id_voiture'] = idVoiture;
            }else{
                tab['id'] = datas;
            }
            tab['typeRep'] = typeRep.val();
            tab['dateRep'] = reverseDate(dateRep);
            tab['montantRep'] = montantRep.val();
            tab['garageRep'] = garageRep.val();
            tab['noteRep'] = (noteRep.val() !=="") ? noteRep.val() : 'aucune note';
        }else{
            draw_error(typeRep,'error_typeRep');
            draw_error(dateRep,'error_dateRep','date');
            draw_error(montantRep,'error_montantRep','nb');
            draw_error(garageRep,'error_garageRep');
        }
    }
    if (page === "consommation"){
        let montantConso = $('.modal.fade.show input[name=montantCons]');
        let litre = $('.modal.fade.show input[name=litre]');
        if(montantConso.val() !=="" && litre.val() !== "" && montantConso.val().replaceAll(',','.') > 0 && !isNaN(montantConso.val().replaceAll(',','.'))){
            tab['montantCons'] = montantConso.val().replaceAll(',','.');
            tab['litre'] = litre.val();
            if (type === 'add'){
                tab['id_voiture'] = idVoiture;
            }else{
                tab['id'] = datas;
            }
        }else{
            draw_error(montantConso,'error_montantCons','nb')
            draw_error(litre,'error_litre')
        }
    }
    return tab;
}
var saveToastEl = document.getElementById('saveToast');
var saveToast = bootstrap.Toast.getOrCreateInstance(saveToastEl);
function reverseDate(d){
    //d = date
    d = d.split('-');
    return d[2]+'/'+d[1]+'/'+d[0];
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
                success:function (rowData) {
                    if(window.location.pathname.match('voiture') || type !== 'add' ){
                        myModal1.hide();
                    }
                    rowData.forEach(datas=>{
                        let table = $('#DataTable_carburants').DataTable();
                        if(type !== 'add'){
                            table.row($("tr[data-voiture='"+datas.id+"']"))
                                .remove()
                                .draw();
                        }
                        let tab = [datas.litre,datas.montantCons+'€'];
                        if(!window.location.pathname.match('voiture')){
                            if(type==='add'){
                                myModal3.hide();
                            }
                            tab.push(datas.immatriculation);
                        }
                        tab.push(Math.round(datas.montantCons / datas.litre)+'€'+`<div class="divBtnTab">
                                <button class="btn btn-info editButton text-white"><i class="fa-solid fa-pencil "></i></button>
                                <button class="btn btn-danger delButton"><i class="fa-solid fa-trash-can"></i></button>
                            </div>`)
                        let row = table.row.add(tab).node();
                        $(row).attr({"data-voiture":datas.id,"data-db":page})
                        $(row).children().last().addClass('tdBtn');
                        table.draw();
                        eventModif();
                    })
                    saveToast.show();
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
                success:function (rowData) {
                    if(window.location.pathname.match('voiture') || type !== 'add' ){
                        myModal1.hide();
                    }
                    rowData.forEach(datas=>{
                        let table = $('#DataTable_assurances').DataTable();
                        if(type !== 'add'){
                            table.row($("tr[data-voiture='"+datas.id+"']"))
                                .remove()
                                .draw();
                        }
                        let tab = [datas.nomAssu,reverseDate(datas.debutAssu),reverseDate(datas.finAssu)];
                        if(!window.location.pathname.match('voiture')){
                            if(type==='add'){
                                myModal3.hide();
                            }
                            tab.push(datas.immatriculation);
                        }
                        tab.push(datas.frais+'€'+`<div class="divBtnTab">
                                <button class="btn btn-info editButton text-white"><i class="fa-solid fa-pencil "></i></button>
                                <button class="btn btn-danger delButton"><i class="fa-solid fa-trash-can"></i></button>
                            </div>`)
                        let row = table.row.add(tab).node();
                        $(row).attr({"data-voiture":datas.id,"data-db":page})
                        $(row).children().last().addClass('tdBtn');
                        table.draw();
                        eventModif();
                    })
                    saveToast.show();
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
                    if(window.location.pathname.match('voiture') || type !== 'add' ){
                        myModal1.hide();
                    }
                    rowData.forEach(datas=>{
                        let table = $('#DataTable_entretiens').DataTable();
                        if(type !== 'add'){
                            table.row($("tr[data-voiture='"+datas.id+"']"))
                                .remove()
                                .draw();
                        }
                        let tab = [datas.garageEnt,datas.typeEnt,datas.montantEnt+'€',reverseDate(datas.dateEnt)];
                        if(!window.location.pathname.match('voiture')){
                            if(type==='add'){
                                myModal3.hide();
                            }
                            tab.push(datas.immatriculation);
                        }
                        tab.push(datas.noteEnt+`<div class="divBtnTab">
                                <button class="btn btn-info editButton text-white"><i class="fa-solid fa-pencil "></i></button>
                                <button class="btn btn-danger delButton"><i class="fa-solid fa-trash-can"></i></button>
                            </div>`)
                        let row = table.row.add(tab).node();
                        $(row).attr({"data-voiture":datas.id,"data-db":page})
                        $(row).children().last().addClass('tdBtn');
                        table.draw();
                        eventModif();
                    })
                    saveToast.show();
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
                success:function (rowData) {
                    if(window.location.pathname.match('voiture') || type !== 'add' ){
                        myModal1.hide();
                    }
                    rowData.forEach(datas=>{
                        let table = $('#DataTable_reparations').DataTable();
                        if(type !== 'add'){
                            table.row($("tr[data-voiture='"+datas.id+"']"))
                                .remove()
                                .draw();
                        }
                        let tab = [datas.garageRep,datas.typeRep,datas.montantRep+'€',reverseDate(datas.dateRep)];
                        if(!window.location.pathname.match('voiture')){
                            if(type==='add'){
                                myModal3.hide();
                            }
                            tab.push(datas.immatriculation);
                        }
                        tab.push(datas.noteRep+`<div class="divBtnTab">
                                <button class="btn btn-info editButton text-white"><i class="fa-solid fa-pencil "></i></button>
                                <button class="btn btn-danger delButton"><i class="fa-solid fa-trash-can"></i></button>
                            </div>`)
                        let row = table.row.add(tab).node();
                        $(row).attr({"data-voiture":datas.id,"data-db":page})
                        $(row).children().last().addClass('tdBtn');
                        table.draw();
                        eventModif();
                    })
                    saveToast.show();
                }
            })
        }
        if (page === 'voiture'){
            let image = $('.modal.fade.show input[name=file]');
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });
            let files = (image.get(0).files.length !== 0) ? image[0].files[0] : 0;
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
                            $("div[data-voiture="+datas.id+"] div.col-6 div.col-auto:nth-child(2) h2").eq(2).html(reverseDate(datas.circulation));
                            $("div[data-voiture="+datas.id+"] div.col-6 div.col-auto:nth-child(2) h2").eq(3).html(datas.status);
                            $("div[data-voiture="+datas.id+"] div.col-6 div.col-auto:nth-child(2) h2").eq(4).html(datas.puissance);
                            $("div[data-voiture="+datas.id+"] div.col-6 div.col-auto:nth-child(2) h2").eq(5).html(datas.carburant);
                        })
                    }
                    if(type === 'add'){
                        rowData.forEach(datas=>{
                            $('.container.d-flex').append(`
                         <div class="col-2 d-flex flex-column  p-2 rounded m-2 blockVoiture" style="background: #e4e4e4" data-voiture="${datas.id}" data-db="${page}">
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
                    saveToast.show();
                }
            })




        }
    }
}
