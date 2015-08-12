/* 
 * Proyecto : Euroandino.net
 * Autor    : Tsyacom Ltda.
 * Fecha    : Miercoles, 10 de octubre de 2014
 */

//<![CDATA[
$(function() {
    $('#HomePageSlider').cycle({
        timeout: 4000,
        speed: 500,
        manualSpeed: 300,
        fx: 'fade',
        manualFx: 'scrollHorz',
        manualTrump: true,
        pauseOnHover: true,
        slides: '> .HomePageSlider_SlideBox',
        log: false,
        pager: '> .cycle-pager'
    });
});
//]]>