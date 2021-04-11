//Modal
let modal = document.getElementById('modal');
window.onclick = function(event) {
    if (event.target == modal) {
        modal.style.display = "none";
    }
}
function openModal() {
        document.getElementById('modal').style.display='block';
}
function closeModal(){
    document.getElementById('modal').style.display='none';
}
//show/hide animal rows
$(function() {
    $('.click').click(function() {
        $('#animalTable tr:nth-child(n+5)').toggle();
        if ($(this).text() == "Show More") { 
            $(this).text("Show Less"); 
        } else { 
            $(this).text("Show More"); 
        }; 
    });
});

/*Link to Animal record from Adoptable page*/
/*Cite: 
Kazi, Sameer. (2016-03-09) Get url parameter jquery Or How to Get Query String Values In js [Computer program].
Available at https://stackoverflow.com/questions/19491336/get-url-parameter-jquery-or-how-to-get-query-string-values-in-js?page=1&tab=votes#tab-top 
(Accessed 15 November 2017)
*/
var getUrlParameter = function getUrlParameter(sParam) {
    var sPageURL = decodeURIComponent(window.location.search.substring(1)),
        sURLVariables = sPageURL.split('&'),
        sParameterName,
        i;

    for (i = 0; i < sURLVariables.length; i++) {
        sParameterName = sURLVariables[i].split('=');

        if (sParameterName[0] === sParam) {
            return sParameterName[1] === undefined ? true : sParameterName[1];
        }
    }
};
var id = getUrlParameter('id');
$(document).ready(function() {  
    $('#' + id).show()  
}); 
/*Success page animation*/
$(document).ready(function(){
    $(".successBox").click(function(){
        $(".successBox").animate({
            opacity: '0.8',
        });
        $(".successBox").css(
            'order', '-5'
        );
        $(".succInfo").css(
            'display', 'inline'
        );
        $("#succTitle").css(
            'display', 'none'
        );
    });
});