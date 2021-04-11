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
//show/hide medical history
$(function() {
    $('.showMore').click(function() {
        $(this).next('.med').toggle();
        if ($(this).text() == "Medical") { 
            $(this).text("Hide"); 
        } else { 
            $(this).text("Medical"); 
        }; 
    });
});
/*Show Hide Animal data for editing*/
$(document).ready(function() {  
    $(".animalClick").click(function() {
      $(this).next(".editAnimal").toggle()
    });  
});

/*Link to Animal record from Adoptable page*/
/*Cite: /*Cite: 
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

/*Show Hide Animal data for editing*/
$(document).ready(function() {  
    $(".appClick").click(function() {
      $(this).next(".editApp").toggle()
    });  
});

//Show hide employees 
$(function() {
    $('.empTitle').click(function() {
        $('.empDisplay').toggle();
    });
});
//Show hide vets 
$(function() {
    $('.vetTitle').click(function() {
        $('.vetDisplay').toggle(); 
    });
});