window.bootstrap = require('bootstrap/dist/js/bootstrap.bundle.js');
require('jquery-mask-plugin/dist/jquery.mask.js');
import flatpickr from "flatpickr";
function reverseDate(d){
    d = d.split('-');
    return d[2]+'/'+d[1]+'/'+d[0];
}
function reverseDateEng(d){
    d = d.split('/');
    let date = d[2]+'-'+d[1]+'-'+d[0];
    let verifDate  = new Date().getFullYear() - 122;
    return (  new Date(date) instanceof Date && !isNaN(new Date(date)) && d[2] >= verifDate ) ? date : false;
}

let prixPJ;//prix par jours

function verifPrix(pj,Days){
    //pj prix par jours
    let dateDebut = $('#dateD');
    let dateFin = $('#dateF');
    if(dateDebut.val() !== '' && dateFin.val() !== ''){
        let valP = $('.franchiseP:checked').attr('id').replace('fp','');
        let protection = (valP === 2) ? (5*Days) : (valP === 3) ? (10*Days) : (valP === 3) ? (15*Days) : 0;
        let protecPneu = ($('#protecPneu:checked') !== null) ? (10*Days) : 0;
        let driver = (parseInt($('#addDriver').val()) > 0) ?  (parseInt($('#addDriver').val()) * 10 ) * Days : 0;
        let hiver = ($('#chainesV:checked') !== null) ? (10*Days) : 0;
        let gps = ($('#gps:checked') !== null) ? (10*Days) : 0;
        let location = pj * Days;
        let prix = protection + protecPneu + driver + hiver + gps + 40 + location;
        $('#priceVoiture').html(prix+'€');
    }else{
        dateDebut.addClass('active')
        dateFin.css('border','2px solid red')
        dateFin.addClass('active')
        dateFin.css('border','2px solid red')
    }
}

$(document).ready(function () {
    $('#dateD').on('focusout',function () {
        console.log($(this).val())
        if($(this).val() === ''){
            $('#dateF').val('')
        }
    })
    let nbClick = 0;

    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    })
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
                let date1 = new Date(reverseDateEng(dateDebut));
                let date2 = new Date(reverseDateEng(dateFin));
                let Time = date2.getTime() - date1.getTime();
                var Days = (Time / (1000 * 3600 * 24)) + 1;//nombre de jour entre date 1 et 2
                $('#prixTimeLocation').html((Days > 1) ? Days+'Jour/s' : Days+'jour')
                return Days;
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
                    $('.flatpickr-day').on('click',function () {
                        $('.flatpickr-day').on('focusout',function () {
                            console.log('test')
                        })
                        $('#dateD').focus();
                        nbClick++;
                        console.log(nbClick)
                        nbClick = (nbClick === 3) ? 0 : nbClick;
                    })
                },
                onClose: function(selectedDates, dateStr){
                    $('dateD').val(' ')
                    let allDate = dateStr.replace(' to ', ',').split(',');
                    if(dateStr.match('to')){
                        $('#dateD').val(allDate[0])
                        $('#dateF').val(allDate[1])
                        verifPrix(prixPJ,changePrix(allDate[0],allDate[1]))
                    }
                }
            });
            $('#LocationDate').on('click',function () {
                datePicker.open();
            })
            $('.flatpickr-disabled').on('click',function () {
                nbClick--;
            })

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
