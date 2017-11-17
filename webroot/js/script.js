$( document ).ready(function() {
    $("#usersTable").DataTable();

    $('#file').change(function(){
		$(this).parent().parent().find('label.label-file').html($(this).val());
	})

    $('#inputFile').change(function(){
    	var tmppath = URL.createObjectURL(event.target.files[0]);
		$("#thumbnailImg").attr('src',tmppath);
    })
});