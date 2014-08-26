/*

My Custom JS
============

Author:  Brad Hussey
Updated: August 2013
Notes:	 Hand coded for Udemy.com

*/

$(function() {

    $('#btn-newQ').click(function() {
        $d = $('#loginAlert');
        $('#loginAlert').slideDown();
        console.log($d);
    });

    $('#loginCancel').click( function() {
        $('#loginModal').hide();
    });
    $('#loginClose').click( function() {
        $('#loginModal').hide();
    });

});