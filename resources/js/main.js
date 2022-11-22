window.bootstrap = require('bootstrap/dist/js/bootstrap.bundle.js');
require('jquery-mask-plugin/dist/jquery.mask.js');
import flatpickr from "flatpickr";
$(document).ready(function () {
    console.log('ok')
    $('#dropdownfilter').on('click',function(){
        $(this).find('i').toggleClass('fa-chevron-up fa-chevron-down')
    })
}).on('load','document',function () {

}).on('click','#searchBar',function () {
    $(this).focus().prop('readonly',true)
    $('#divSearch').show()
}).on('focusout','#searchBar',function () {
    $('#divSearch').hide()
})
