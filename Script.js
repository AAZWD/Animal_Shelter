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

/*Success page animation*/
$(document).ready(function(){
    $(".successBox").click(function(){
        $(".successBox").animate({
            opacity: '0.8',
        });
        $(".successBox").css(
            'order', '-5'
        );
    });
});

$(function() {
    $('.successBox').click(function() {
        $('.successTable').show(); 
    });
});
