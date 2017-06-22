
/**
 * First we will load all of this project's JavaScript dependencies which
 * includes Vue and other libraries. It is a great starting point when
 * building robust, powerful web applications using Vue and Laravel.
 */

require('./bootstrap');

window.Vue = require('vue');


$( document ).ready(function() {

    if ($('#home').length) {
        $('.navbar').find('.container').removeClass('container').addClass('container-fluid');
        $('body').attr('id', 'particles-js');
    }

    if ($('#tracks').length) {
        $('.navbar').find('.container').removeClass('container').addClass('container-fluid');
        $('body').attr('id', 'particles-js');
    }

    particlesJS.load('particles-js', './particles.json', function() {
        console.log('callback - particles.js config loaded');
    });

    $('[data-toggle="tooltip"]').tooltip()

});

$('.play').click(function() {
    $(this).closest(".playlist-group").find("audio")[0].play();
    $(this).hide();
    $(this).closest(".playlist-group").find(".pause").show();
});

$('.pause').click(function() {
    $(this).closest(".playlist-group").find("audio")[0].pause();
    $(this).hide();
    $(this).closest(".playlist-group").find(".play").show();
});
