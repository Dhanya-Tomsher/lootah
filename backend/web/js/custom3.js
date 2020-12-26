

$('#imageUploadForm').on('beforeSubmit', (function (e) {

    e.preventDefault();
    var formData = new FormData(this);
    $.ajax({
        type: 'POST',
        url: baseurl + '/question/upload',
        data: formData,
        cache: false,
        contentType: false,
        processData: false,
        success: function (data) {
            $('.upld_success').html('Uploaded Successfully !!!');
            $('.image_content').prepend('<img class="canvas-img" draggable="true" src="' + data + '">');

            [].slice.call(document.querySelectorAll('[draggable = "true"]')).forEach(function (imageData) {
                imageData.addEventListener('mousedown', module.imageList);
            });


//                $.pjax({container: '#pjax-grid-view',timeout: false, async:false});

//                $.pjax({container: '#canvas-container',timeout: false, async:false});


        },
        error: function (data) {
            console.log("error");
            console.log(data);
        }

    });

    return false;

}));
