/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

function myFunction() {
    $(".number-grid").empty();
    var box_num = document.querySelector('.add-limit').value;
    for (var i = 1; i <= box_num; i++) {
        $(".number-grid").append("<input type='checkbox' name='rGroup' value='1'" + "id=" + "r" + i + " />" +
                "<label class='c-label'" + "for=" + "r" + i + ">" + "<span>" + i + "</span>" + "</label>");
    }


}
//function myFunction_type4() {
//    $(".qstn-type4Boxes").empty();
//    var type4_box_num = document.querySelector('#qstn4-limit').value;
//    var qb_w = $('.qstn-type4Boxes').innerWidth();
//    var bb_w = (qb_w / type4_box_num);
//    for (var i = 1; i <= type4_box_num; i++) {
//        $(".qstn-type4Boxes").append("<div class='qstn-type4Box'>" + i + "</div>");
//        $(".qstn-type4Box").css({'width': bb_w});
//    }
//
//}


function gridLock(obj) {
    obj.set({
        left: Math.round(obj.left / grid) * grid,
        top: Math.round(obj.top / grid) * grid
    });
}
function gridShow() {
    var x, y;
    for (x = 0; x <= canWidth; x += grid) {
        canvas.add(new fabric.Line([x, 0, x, canHeight], {stroke: strokeColor, selectable: false}));
    }
    for (y = 0; y <= canHeight; y += grid) {
        canvas.add(new fabric.Line([0, y, canWidth, y], {stroke: strokeColor, selectable: false}))
    }

}

function intersectingCheck(activeObject) {
    activeObject.setCoords();
    if (typeof activeObject.refreshLast != 'boolean') {
        activeObject.refreshLast = true
    }
    ;

    //loop canvas objects
    activeObject.canvas.forEachObject(function (targ) {
        if (targ === activeObject)
            return; //bypass self

        //check intersections with every object in canvas
        if (activeObject.intersectsWithObject(targ)
                || activeObject.isContainedWithinObject(targ)
                || targ.isContainedWithinObject(activeObject)) {
            //objects are intersecting - deny saving last non-intersection position and break loop
            if (typeof activeObject.lastLeft == 'number') {
                activeObject.left = activeObject.lastLeft;
                activeObject.top = activeObject.lastTop;
                activeObject.refreshLast = false;
                return;
            }
        } else {
            activeObject.refreshLast = true;
        }
    });

    if (activeObject.refreshLast) {
        //save last non-intersecting position if possible
        activeObject.lastLeft = activeObject.left
        activeObject.lastTop = activeObject.top;
    }
}


$(".img-wrapper").each(function () {
    var imageUrl = $(this).find('img').attr("src");
    var imageUrl = imageUrl.replace(/ /g, '%20');
    var imageUrl = imageUrl.replace("(", '%28');
    var imageUrl = imageUrl.replace(")", '%29');
    $(this).find('img').css("visibility", "hidden");
    $(this).css('background-image', 'url(' + imageUrl + ')').css("background-repeat", "no-repeat").css("background-size", "contain").css("background-position", "50% 50%");
});
$(".img-wrapper-contain").each(function () {
    var imageUrl = $(this).find('img').attr("src");
    var imageUrl = imageUrl.replace(/ /g, '%20');
    var imageUrl = imageUrl.replace("(", '%28');
    var imageUrl = imageUrl.replace(")", '%29');
    $(this).find('img').css("visibility", "hidden");
    $(this).css('background-image', 'url(' + imageUrl + ')').css("background-repeat", "no-repeat").css("background-size", "contain").css("background-position", "50% 50%");
});
