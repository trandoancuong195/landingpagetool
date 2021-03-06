
$(document).ready(function () {
    $(".btn-modal-show").click(function () {
        $(this).hide();
    });
    // $('.create-landingpage-bt').click(function () {
    //     $(".btn-modal-show").hide();
    // });
    $(".canvas").css("width", "auto");
    $(".navbar-landingpage").removeClass("d-none");
    $(".navbar-landingpage").animate({
        right: '0'
    });
    $(".make-landingpage ").hide();
    $(".save-landingpage ").show();
    $(".close-landingpage ").show();
    if($(".parent-column").height() > 500){
        $(".parent-column").css('height','500px');
        $(".parent-column").css('overflow','scroll');
    }

    $(".add-element").draggable({
        //  use a helper-clone that is append to "body" so is not "contained" by a pane
        helper: function () {
            return $(this).clone().removeClass("add-element").appendTo(".canvas").css({
                "zIndex": 5
            }).show();
        },
        cursor: "move",
        containment: "document"
    });

    $(".canvas, .canvas *").droppable({
        accept: ".add-element",
        drop: function (event, ui) {
            if (!ui.draggable.hasClass("dropped")) {
                let child = $(`<div class="child"></div>`);
                let elementDrag = $(ui.draggable).clone()
                let componentType = $(elementDrag).data("componentType");
                switch (componentType) {
                    case "content":
                        excuseContent(child, this);
                        break;
                    case "product":
                        excuseProduct(child, this);
                        break;
                    case "banners":
                        excuseBanner(child, this);
                        break;
                    case "menu":
                        excuseMenu(child, this);
                        break;
                    default:
                        child.append(elementDrag.removeClass("ui-draggable").removeClass("dropped"))
                        $(this).append(child);
                        $(".canvas").css("width", "auto");
                }

            }
        }
    }).sortable({
        placeholder: "sort-placer",
        cursor: "move",
        helper: function (evt, ui) {
            return $(ui).clone().appendTo(".canvas").show();

        }
    });

    window.saveTemplate = function(){
        let objdata = [];
        let landingPageId = $("#LandingPageId").val();
        let floor = -1;
        console.log($("#LandingPageId").val());
        $( ".child" ).each(function( index, element ) {
            let obj = $(element).find('.block-data').val();
            if(obj){
                objdata.push(JSON.parse(obj));
            }else{
                floor = index;
                objdata = [];
                return false;
            }
        });
        if (objdata.length > 0){
            objdata = JSON.stringify(objdata);
            console.log(JSON.stringify(objdata));
            //call api update
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': jQuery('meta[name="csrf-token"]').attr('content')
                }
            });
            var type = "POST";
            var ajaxurl = 'insertComponent';
            $.ajax({
                type: type,
                url: ajaxurl,
                data: {
                    "component":objdata,
                    "landingPageId": landingPageId,
                },
                dataType: 'json',
                success: function (data) {
                    if(data.status == 'success'){
                        $(".close-landingpage").delay(2000).click();
                        alert('C???p nh???t landing page th??nh c??ng')
                        $(".btn-modal-show").delay(2000).click();
                    }else{
                        alert(data.erro);
                    }
                },
                error: function (data) {
                    console.log(data);
                }
            });
        }else alert(`T???ng ${floor} Ch??a nh???p d??? li???u. Vui l??ng nh???p ?????y ????? th??ng tin`);
    }
    window.makeLandingPage = function () {
        // call ajax create landingpage
        let slug = $("#slugLandingPage").val();
        let name = $("#nameLandingPage").val();
        let useForPage = $("#useforpage").val();
        let startTime = $("#start-lp>input").val() + ' ' + $(".start-hour-lp").val()+ ' ' + $(".start-minute-lp").val();
        let endTime = $("#end-lp>input").val()+ ' ' + $(".end-hour-lp").val()+ ' ' + $(".end-minute-lp").val();
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': jQuery('meta[name="csrf-token"]').attr('content')
            }
        });
        var type = "POST";
        var ajaxurl = 'insertLandingPage';
        $.ajax({
            type: type,
            url: ajaxurl,
            data: {
                "slug":slug,
                "name": name,
                "use_for_page": useForPage,
                "start_time": startTime,
                "end_time": endTime
            },
            dataType: 'json',
            success: function (data) {
                if(data.id){
                    $("#LandingPageId").val(data.id);
                    console.log($("#LandingPageId").val());
                    $(".navbar-landingpage").removeClass("d-none");
                    $(".navbar-landingpage").animate({
                        right: '0'
                    });
                    $(".make-landingpage ").hide();
                    $(".save-landingpage ").show();
                    $(".close-landingpage ").show();
                    $(".close-modal-landingpage").click();
                    $(".btn-modal-show").hide();
                }
            },
            error: function (data) {
                console.log(data);
            }
        });
        // end call ajax

    };
    $(".close-landingpage ").click(function () {
        $(".navbar-landingpage").animate({
            right: '-310px'
        });
        $(".close-landingpage ").hide();
        $(".make-landingpage ").show();
        $(".save-landingpage ").hide();
        $(".child").remove();
        $(".canvas").css("width","100%");
        $(".btn-modal-show").show();
    });

    window.removeVietnameseTones = function(str) {
        str = str.replace(/??|??|???|???|??|??|???|???|???|???|???|??|???|???|???|???|???/g,"a");
        str = str.replace(/??|??|???|???|???|??|???|???|???|???|???/g,"e");
        str = str.replace(/??|??|???|???|??/g,"i");
        str = str.replace(/??|??|???|???|??|??|???|???|???|???|???|??|???|???|???|???|???/g,"o");
        str = str.replace(/??|??|???|???|??|??|???|???|???|???|???/g,"u");
        str = str.replace(/???|??|???|???|???/g,"y");
        str = str.replace(/??/g,"d");
        str = str.replace(/??|??|???|???|??|??|???|???|???|???|???|??|???|???|???|???|???/g, "A");
        str = str.replace(/??|??|???|???|???|??|???|???|???|???|???/g, "E");
        str = str.replace(/??|??|???|???|??/g, "I");
        str = str.replace(/??|??|???|???|??|??|???|???|???|???|???|??|???|???|???|???|???/g, "O");
        str = str.replace(/??|??|???|???|??|??|???|???|???|???|???/g, "U");
        str = str.replace(/???|??|???|???|???/g, "Y");
        str = str.replace(/??/g, "D");
        // Some system encode vietnamese combining accent as individual utf-8 characters
        // M???t v??i b??? encode coi c??c d???u m??, d???u ch??? nh?? m???t k?? t??? ri??ng bi???t n??n th??m hai d??ng n??y
        str = str.replace(/\u0300|\u0301|\u0303|\u0309|\u0323/g, ""); // ?? ?? ?? ?? ??  huy???n, s???c, ng??, h???i, n???ng
        str = str.replace(/\u02C6|\u0306|\u031B/g, ""); // ?? ?? ??  ??, ??, ??, ??, ??
        // Remove extra spaces
        // B??? c??c kho???ng tr???ng li???n nhau
        str = str.replace(/ + /g," ");
        str = str.trim();
        // Remove punctuations
        // B??? d???u c??u, k?? t??? ?????c bi???t
        str = str.replace(/!|@|%|\^|\*|\(|\)|\+|\=|\<|\>|\?|\/|,|\.|\:|\;|\'|\"|\&|\#|\[|\]|~|\$|_|`|-|{|}|\||\\/g," ");
        str = convertToSlug(str);
        return str;
    }

    window.convertToSlug = function(str)
    {
        var $slug = '';
        var trimmed = $.trim(str);
        $slug = trimmed.replace(/[^a-z0-9-]/gi, '-').
        replace(/-+/g, '-').
        replace(/^-|-$/g, '');
        return $slug.toLowerCase();
    }
    $("#nameLandingPage").keyup(function() {
        let nameVl = $("#nameLandingPage").val();
        let slug = removeVietnameseTones(nameVl);
        $("#slugLandingPage").val(slug);
    });
});
