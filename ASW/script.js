//"use strict";

$(document).ready(function () {
    /* função para mostrar o distrito e concelho*/


    $('#pais').on('change', function () {
        if ($(this).val() == "Portugal") {
            $('.distrito').show();
            $('.distrito').attr("required", true);
            $('.concelho').show();
            $('.concelho').attr("required", true);
        } else {
            $('.distrito').hide();
            $('.distrito').attr("required", false);
            $('.concelho').hide();
            $('.concelho').attr("required", false);

        }
    });
});



$(function () {
    $(":file").change(function () {
        if (this.files && this.files[0]) {
            var reader = new FileReader();
            reader.onload = imageIsLoaded;
            reader.readAsDataURL(this.files[0]);
        }
    });
});

function imageIsLoaded(e) {
    $('#avatar').attr('src', e.target.result);
}
;


/*
 botao_login.onclick = function() {
 //clica para aparecer o pop up
 document.getElementById('id01').style.display='block';
 }
 */

close.onclick = function () {
    document.getElementById('id01').style.display = 'none';
};
//span.onclick = function () {
//    clica para fechar
//    document.getElementById('id01').style.display = 'none';
//}
/*window.onclick = function(event) {
 if(event.target == login) {
 login.style.display = "none";
 }
 }
 */




function main() {

}

window.onload = function () {
    main();
}


// Get the modal
var modal = document.getElementById('id01');

// When the user clicks anywhere outside of the modal, close it
window.onclick = function (event) {
    if (event.target == modal) {
        modal.style.display = "none";
    }
}