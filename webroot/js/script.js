$( document ).ready(function() {

    $('#file').change(function(){
		$(this).parent().parent().find('label.label-file').html($(this).val());
	})

	$('#featured_image').change(function(){
		$(this).parent().parent().find('label.label-file').html($(this).val());
	})

    $('.inputFile').change(function(){
    	var tmppath = URL.createObjectURL(event.target.files[0]);
		$(this).parent().find(".thumbnailImg").attr('src',tmppath);
    });

    $('.inputFiles').change(function(){
    	var tmppath = URL.createObjectURL(event.target.files[0]);
		$("#uploadedFile").append("<span>"+tmppath+"</span>");
    });

});