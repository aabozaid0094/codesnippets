jQuery(document).ready(function ($) {
  "use strict";
	function convertToSlug(Text){
    return Text.toLowerCase().replace(/[^\w ]+/g,'').replace(/ +/g,'-');
	}
	var code = Math.floor((Math.random() * 100000) + 1);
	var patientName = $('div.wpcf7 #contactFormName').val();
	$('div.wpcf7 #contactFormName').change(function(){
		code = Math.floor((Math.random() * 100000) + 1);
		patientName = $(this).val();
		var discountCode = convertToSlug(patientName) + code;
		$('div.wpcf7 #contactFormCode').val(discountCode);
	});
});
