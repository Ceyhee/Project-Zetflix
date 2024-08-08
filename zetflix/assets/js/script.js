// assets/js/script.js
$(document).ready(function() {
    $('.movie-item').addClass('fade-in');

    // Contoh animasi klik pada elemen
    $('.navbar-brand').click(function() {
        $(this).animate({
            fontSize: "2rem"
        }, 500).animate({
            fontSize: "1.5rem"
        }, 500);
    });
});
