$(document).ready(function () {

    $('.zoo').change(function () {
        var property_type = $(this).val();
        if (property_type != '') {
            $.ajax({
                url: basepath + "/site/get-bedrooms",
                type: "POST",
                data: {property_type: property_type},
                success: function (data)
                {
                    var obj = JSON.parse(data);
                    $('#abcd').html(obj.data);
                    $("#abcd").selectpicker('refresh');
//                    $('.ceel').append("<div class='clearfix'></div>");
                },
                error: function (e) {
                    console.log(e);
                }
            });
        }
    });


    $('.ab-gallery').click(function (e) {
        e.preventDefault();
        $(this).ekkoLightbox();
    });
});

//jQuery("#billing_address_1_field").wrap("<div class='row'><div class='col-xs-12 col-sm-8 appending'></div></div>");
//jQuery(".appending").after("<div class='col-xs-12 col-sm-4 byoo'>" + jQuery('.zoneplate').html() + "</div>");
//jQuery(".appending").append(jQuery('#billing_zone_field')[0].outerHTML);
//jQuery(".appending").append(jQuery('#billing_address_2_field')[0].outerHTML);
//jQuery(".form-row-first").last().remove();
//jQuery(".form-row-last").last().remove();
//
//document.addEventListener("DOMContentLoaded",
//        function () {
//            var div, n,
//                    v = document.getElementsByClassName("youtube");
//            for (n = 0; n < v.length; n++) {
//                div = document.createElement("div");
//                div.setAttribute("data-id", v[n].dataset.id);
//                div.innerHTML = labnolThumb(v[n].dataset.id);
//                div.onclick = labnolIframe;
//                v[n].appendChild(div);
//            }
//        });
//function labnolThumb(id) {
//    var thumb = '<img src="https://i.ytimg.com/vi/ID/hqdefault.jpg">',
//            play = '<div class="play"></div>';
//    return thumb.replace("ID", id) + play;
//}
//
//function labnolIframe() {
//    var iframe = document.createElement("iframe");
//    iframe.setAttribute("src", "https://www.youtube.com/embed/" + this.dataset.id + "?autoplay=1");
//    iframe.setAttribute("frameborder", "0");
//    iframe.setAttribute("allowfullscreen", "1");
//    this.parentNode.replaceChild(iframe, this);
//}
