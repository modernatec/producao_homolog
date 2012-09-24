$(window).load(function() {
    $('#slider').nivoSlider();
});

//$(document).ready(function() {
	//$('#cadastroForm').validate({
	//	errorElement: 'span'
	//});
/*	
	$("#cadastroForm").validate({
		errorElement: 'span',
		rules: {
			name: "required",
			petGender: {
				required: true,
			},
			sexo: "required",
			password: {
				required: true,
				minlength: 5
			},
			confirm_password: {
				required: true,
				minlength: 5,
				equalTo: "#password"
			},
			email: {
				required: true,
				email: true
			},
			topic: {
				required: "#newsletter:checked",
				minlength: 2
			},
			petD: "required",
			petM: "required",
		}
	});
//});
*/