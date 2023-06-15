$(document).ready(function(){
	$("#hide_10").click(function() {
		var rowCount = $('#my_table tr').length - 1;
		
		for (i = 11; i <= rowCount; i++) {
			$('#my_table tr:nth-child(' + i + ')').hide();
		}
		
	});
});

$(document).ready(function(){
	$("#show_10").click(function() {
		$("#my_table tr").show();
	});
});

$(document).ready(function(){
	$("#prikazi").click(function() {
		var id = $('#number1').val();
		if (id == "") {
			alert("ID uporabnika ni bil vnešen!");
		}
		else {
			$('#my_table td').parent().hide();
			$('#my_table td.userID:contains(' + id + ')').parent().show();
		}
		
	});
});

$(document).ready(function(){
	$("#prikazi_vse").click(function() {
		
		$('#my_table td.userID').parent().show();

	});
});