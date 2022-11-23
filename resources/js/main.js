window.bootstrap = require('bootstrap/dist/js/bootstrap.bundle.js');
require('jquery-mask-plugin/dist/jquery.mask.js');
import flatpickr from "flatpickr";
function reverseDate(d,t){
    d = d.split('-');
    let date_time = d[2].split(' ');
    return (t !== 'time')? d[2]+'/'+d[1]+'/'+d[0] : date_time[0]+'/'+d[1]+'/'+d[0]+' '+date_time[1];
}
$(document).ready(function () {
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    })
    $.ajax({
        type:'post',
        url:'/getLocation',
        dataType: 'json',
        success:function (rowdata) {
            var disableDate=[];
            rowdata.forEach(datas =>{
                disableDate.push({
                    "from" : reverseDate(datas.dateDebut),
                    "to" : reverseDate(datas.dateFin)
                })
            })
            flatpickr('#dateD',{
                mode: "range",
                minDate: "today",
                dateFormat: "d/m/Y",
                disable: disableDate,
                onClose: function(selectedDates, dateStr){
                    let allDate = dateStr.replace(' to ', ',').split(',');
                    $('#dateD').val(allDate[0])
                    $('#dateF').val(allDate[1])
                }
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
