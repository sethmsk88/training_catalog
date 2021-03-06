/*
	Get URL params
	Example:
		www.website.com?page=homepage&urlVar=test
		$.urlParam('urlVar'); // Returns 'test'
*/
$.urlParam = function(name){
    var results = new RegExp('[\?&]' + name + '=([^&#]*)').exec(window.location.href);
    if (results==null){
       return null;
    }
    else{
       return results[1] || 0;
    }
}

$(document).ready(function() {
    $('.dropdown-toggle').dropdown();
});

// remove active class from nav bar links
$('.nav li').each(function() {
  $(this).removeClass('active');
});
