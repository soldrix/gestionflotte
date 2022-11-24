window.bootstrap = require('bootstrap/dist/js/bootstrap.bundle.js');
require('jquery-mask-plugin/dist/jquery.mask.js');
import flatpickr from "flatpickr";


let prixPJ;//prix par jours



$(document).ready(function () {
    function reverseDate(data){
        if(data !== undefined){
            let d = data.split('-');
            return d[2]+'/'+d[1]+'/'+d[0];
        }
    }
    function reverseDateEng(data){
        if(data !== undefined){
            let d = data.split('/');
            let date = d[2]+'-'+d[1]+'-'+d[0];
            let verifDate  = new Date().getFullYear() - 122;
            return (  new Date(date) instanceof Date && !isNaN(new Date(date)) && d[2] >= verifDate ) ? date : false;
        }
    }
    function verifPrix(pj,Days){
        //pj prix par jours

        let p1 = (((pj*5)/100)*Days) * 1.5;
        let p2 = (((pj*10)/100)*Days) * 1.5;
        let p3 = (((pj*15)/100)*Days) * 1.5;
        $('#pPrice1').html(p1)
        $('#pPrice2').html(p2)
        $('#pPrice3').html(p3)

        let valP = ($('.franchiseP').length >= 1) ? parseInt($('.franchiseP:checked').attr('id').replace('fp','')) : '';
        let protection = (valP === 2) ? p1 : (valP === 3) ? p2 : (valP === 4) ? p3 : 0;
        let protecPneu = ($('#protecPneu').prop('checked')) ? (10*Days) : 0;
        let driver = (parseInt($('#addDriver').val()) > 0) ?  (parseInt($('#addDriver').val()) * 10 ) * Days : 0;
        let hiver = ($('#chainesV').prop('checked')) ? (10*Days) : 0;
        let gps = ($('#gps').prop('checked')) ? (10*Days) : 0;
        let location = pj * Days;
        let prix = protection + protecPneu + driver + hiver + gps + 40 + location;
        $('#priceVoiture').html(prix+'€');
    }
    var locaToastEl = document.getElementById('toastLocation');
    var locationToast = bootstrap.Toast.getOrCreateInstance(locaToastEl);
    let nbClick = 0;

    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    })
    if(window.location.pathname.match('voiture')){
        $.ajax({
            type:'post',
            url:'/getLocationDate',
            data:{"id_voiture":window.location.pathname.split('/')[2]},
            dataType: 'json',
            success:function (rowdata) {
                var disableDate=[];
                rowdata.forEach(datas =>{
                    disableDate.push({
                        "from" : reverseDate(datas.dateDebut),
                        "to" : reverseDate(datas.dateFin)
                    })
                })
                prixPJ  = parseInt(rowdata[0].prix);
                function changePrix(dateDebut,dateFin){
                    var Days = '';
                    if(dateDebut !== "" && dateFin !== ""){
                        let date1 = new Date(reverseDateEng(dateDebut));
                        let date2 = new Date(reverseDateEng(dateFin));
                        let Time = date2.getTime() - date1.getTime();
                        Days = (Time / (1000 * 3600 * 24)) + 1;//nombre de jour entre date 1 et 2
                        $('#prixTimeLocation').html((Days > 1) ? Days+' Jour/s' : Days+' jour')
                    }
                    return (Days !== '') ? Days : 1;
                }

                if($('#dateD').val() !== '' && $('#dateF').val() !== ''){
                    verifPrix(prixPJ,changePrix($('#dateD').val(),$('#dateF').val()))
                }
                const datePicker = flatpickr('#dateD',{
                    mode: "range",
                    minDate: "today",
                    dateFormat: "d/m/Y",
                    disable: disableDate,
                    onOpen:function () {
                        $('#dateD').val('')
                        $('#dateF').val('')
                    },
                    onChange:function (selectedDates,dateStr) {
                        if (nbClick === 2){
                            let allDate = dateStr.replace(' to ', ',').split(',');
                            if(dateStr.match('to')){
                                $('#dateD').val(allDate[0])
                                $('#dateF').val(allDate[1])
                                verifPrix(prixPJ,changePrix(allDate[0],allDate[1]))
                            }
                        }
                        nbClick++;
                    },onClose:function(selectedDates,dateStr){
                        nbClick++;
                        if(nbClick >= 2){
                            setTimeout(()=>{
                                nbClick = 0;
                                if($('#dateD').val() !== '' && !dateStr.match('to')){
                                    $('#dateF').val($('#dateD').val())
                                    verifPrix(prixPJ,changePrix($('#dateD').val(),$('#dateF').val()))
                                }else if($('#dateD').val() === ''){
                                    $('#dateF').val('')
                                }
                            },100)
                        }
                    }
                });
                $('#LocationDate').on('click',function () {
                    datePicker.open();
                })
                $('.franchiseP,#protecPneu,#gps,#chainesV').on('click',function () {
                    verifPrix(prixPJ,changePrix($('#dateD').val(),$('#dateF').val()))
                })
                $('#addDriver').on('change',function () {
                    verifPrix(prixPJ,changePrix($('#dateD').val(),$('#dateF').val()))
                })
            }
        })
    }
    $('#validationBtn').on('click',function () {
        let dateDebut = $('#dateD');
        let dateFin = $('#dateF');
        dateDebut.removeClass('active');
        dateFin.removeClass('active');
        $('.errorDate').remove()
        if(dateDebut.val() !== '' && dateFin.val() !== ''){
            $.ajax({
                type:'post',
                url:'/addLocation',
                data:{
                    "id_voiture":window.location.pathname.split('/')[2],
                    "dateDebut":reverseDateEng(dateDebut.val()),"dateFin":reverseDateEng(dateFin.val())
                },
                dataType: 'json',
                success:function () {
                    locationToast.show()
                    dateDebut.val('')
                    dateFin.val('')
                    locaToastEl.addEventListener('hidden.bs.toast', function () {
                        window.location.href = '/home';
                    })
                }
            })
        }else{
            dateDebut.addClass('active');
            dateFin.addClass('active');
            if($('.errorDate').length < 1 ){
                dateDebut.parent().append(`
               <p class="errorDate">Champ requis</p>
            `);
            }
        }
    })
    $('#dropdownfilter').on('click',function(){
        $(this).find('i').toggleClass('fa-chevron-up fa-chevron-down')
    })
}).on('click','#searchBar',function () {
    $(this).focus().prop('readonly',true)
    $('#divSearch').show()
}).on('focusout','#searchBar',function () {
    $('#divSearch').hide()
})
