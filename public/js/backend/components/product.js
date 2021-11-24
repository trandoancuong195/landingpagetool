window.removeProducts = function (idBlock, idProduct, el) {
    let dataProduct = JSON.parse($(`#data-product-${idBlock}`).val());
    let productDtl = dataProduct.data;
    let vl = $(`#list-product-${idBlock}`).val().split(",");
    if ($.inArray(idProduct.toString(), vl) > -1) {
        //finding position product
        vl = vl.filter(v => v != idProduct)
        //delet id product
        $(`#list-product-${idBlock}`).val(vl);
        productDtl = productDtl.filter(v => v.id != idProduct);
        dataProduct.data = productDtl;
        $(`#data-product-${idBlock}`).val(JSON.stringify(dataProduct));
        $(el).parents("li").remove();
    }

}

function excuseProduct(child, element) {
    let landingType = $("#use-for-page").val();
    let urlCscart = $("#url_cscart").val();
    let urlTatmart = $("#url_tatmart").val();
    console.log($('.canvas>.child').length);
    let idPrd = $('.canvas>.child').length;
    let select2 = $(`
                    <button type="button" class="btn btn-danger delete-content delete-content-${idPrd}" onclick="deleteContent('${idPrd}')">
                                 <i class="fa fa-times" aria-hidden="true"></i>
                            </button>
                       `);
    child.html(`<div class='product' id="block-prd-${idPrd}"></div>
                            <h2 style="text-align: center">Product</h2>
                            <div id="parent-${idPrd}">
                                <div class="form-group" style="display: flex">
                                <label for="tag_list-${idPrd}">products:</label>
                                <select id="tag_list-${idPrd}" class="form-control" style="width: 50%"></select>
                                <div class="form-check" style="margin: 0 30px; display: flex;align-items: center">
                                    <input class="form-check-input" style="margin-top: 0px" type="radio" name="productperrow-${idPrd}" value="4" onclick="changeProductInRow(4)" id="flexRadioDefault1">
                                    <label class="form-check-label" for="flexRadioDefault1">
                                        4 product in row
                                    </label>
                                </div>
                                <div class="form-check" style="display: flex;align-items: center">
                                    <input class="form-check-input" type="radio" name="productperrow-${idPrd}" value="5" id="flexRadioDefault2" onclick="changeProductInRow(5)" checked>
                                    <label class="form-check-label" for="flexRadioDefault2">
                                        5 product in row
                                    </label>
                                </div>
                                </div>
                            </div>
                            <input type="hidden" id="list-product-${idPrd}" >
                            <input type="hidden" class="block-data" name="data-product-${idPrd}" id="data-product-${idPrd}" >
                             <ul id="columns-${idPrd}" class="parent-column" style="width: 100%;"></ul>
                         `);
    child.append(select2);
    $(element).append(child);
    $(`#columns-${idPrd}`).hover(function () {
        $(".canvas").addClass('canvas1');
        $(".canvas1").removeClass("canvas");
    }, function () {
        $(".canvas1").addClass('canvas');
    });
    if ($(`#columns-${idPrd}`).height() > 500) {
        $(`#columns-${idPrd}`).css('height', '500px');
        $(`#columns-${idPrd}`).css('overflow-y', 'scroll');
        $(`#columns-${idPrd}`).css('overflow-x', 'hidden');
    }
    let product_in_row = $('input[name="productperrow-' + idPrd + '"]:checked').val();
    let dataProduct = {
        type: "product",
        product_in_rows: product_in_row,
        data: []
    }
    let objAjax = {
        url: urlCscart+"api/products?show_master_products_only=1&active=A",
        headers: {
            "Authorization": $("#authorization_v2").val()
        },
        dataType: 'json',
        data: function (params) {
            return {
                q: $.trim(params.term),
            };
        }
    }
    switch (landingType.toString().toLowerCase()) {
        case "tatmartv1":
            objAjax = {
                url: urlTatmart+"products/get-list-product-landing-page",
                dataType: 'json',
                data: function (params) {
                    return {
                        search_keywords: $.trim(params.term),
                    };
                }
            }
            break;
        case "mrtho":
            objAjax = {
                url: urlCscart+"api/products?show_master_products_only=1&active=A",
                headers: {
                    "Authorization": $("#authorization_mrtho").val()
                },
                dataType: 'json',
                data: function (params) {
                    return {
                        q: $.trim(params.term),
                    };
                }
            }
            break;
    }
    $(`#tag_list-${idPrd}`).select2({
        placeholder: "Choose product...",
        closeOnSelect: false,
        minimumInputLength: 1,
        ajax: {
            ...objAjax,
            processResults: function (data) {
                let products = data.products.map(p => {
                    p.id = p.product_id
                    return p;
                })
                return {
                    results: products
                };
            },
            cache: false
        },
        templateResult: function (data) {
            if (data.loading) return false
            let container = '';
            container = `<div class='select2-result-repository clearfix'>
                    ${(data.main_pair) ? `<div class='select2-result-repository__avatar'><img src='${data.main_pair.detailed.https_image_path}' /></div>` : ``}
                     ${(data.image_file) ? `<div class='select2-result-repository__avatar'><img src='${data.image_file}' /></div>` : ``}
                    <div class='select2-result-repository__meta'>
                        <div class='select2-result-repository__title'>${data.product}</div>
                        <div class='select2-result-repository__title'>${data.product_code}</div>
                        <div class='select2-result-repository__title'>${data.price}</div>
                    </div>
                 </div>`;

            return $(container);
        },
        templateSelection: function (data) {
            if (!data.id) return false;
            let vl = $(`#list-product-${idPrd}`).val().split(",");
            if ($(`#list-product-${idPrd}`).val() != "" && $.inArray(data.id, vl) > -1) return false;

            $(`#list-product-${idPrd}`).val($(`#list-product-${idPrd}`).val() + "," + data.id);

            let dataHidden = $(`#data-product-${idPrd}`).val();
            if (dataHidden !== "") {
                dataProduct = JSON.parse(dataHidden);
            }
            let promotion_price = data.list_price ? data.list_price : '';
            let img = '';
            let url = '';
            if (landingType == "tatmartv2") {
                img = data.main_pair ? data.main_pair.detailed.image_path : '';
                url = urlCscart+"index.php?dispatch=products.view&product_id=" + data.product_id;
            }
            if (landingType == "tatmartv1") {
                img = data.image_file ? data.image_file : '';
                url = data.url?data.url:'';
            }
            let objProduct = {
                id: data.id,
                name: data.product ? data.product : '',
                code: data.product_code ? data.product_code : '',
                image: img,
                price: data.price,
                promotion_price: promotion_price,
                url: url
            }
            dataProduct.data.push(objProduct)
            $(`#data-product-${idPrd}`).val(JSON.stringify(dataProduct));
            obj[`columns-${idPrd}`] = dataProduct;
            let blockProduct = `
                    <li class="column" class = "data-product-id-${data.id}" data-product-id="${data.id}">
                    <div class="row">
                        <div class="col-md-12">
                        <div style="width: 50px;height: 50px; display: flex">
                        ${(data.main_pair) ? `<img style="max-width: 100%; margin-right: 35px;" src='${data.main_pair.detailed.https_image_path}' />` : ``}
                         ${(data.image_file) ? `<img style="max-width: 100%; margin-right: 35px;" src='${data.image_file}' />` : ``}
                            <div class="button-delete-prd">
                                <button type="button" class="btn btn-danger button-edit-product" onclick="removeProducts(${idPrd},${data.id}, this)">
                                     <i class="fa fa-times" aria-hidden="true"></i>
                                </button>
                            </div>
                        </div>
                        <div style="position: absolute;top: 20px;left: 100px;">
                                ${data.product} - ${data.product_code} - ${data.price}
                            </div>

                        </div>
                    </div>
                 </li>`;
            $(`#columns-${idPrd}`).append(blockProduct);
            $(`#columns-${idPrd}`).sortable({
                update: function (event, ui) {
                    let dataTemp = [];
                    let hiddenTag = $(this).prev();
                    let data = obj[`columns-${idPrd}`].data;
                    $(this).children("li").each(function () {
                        for (let d in data) {
                            if (data[d].id == $(this).data("productId")) {
                                dataTemp.push(data[d]);
                                data.splice(d, 1);
                                break;
                            }
                        }
                    });
                    dataProduct.data = dataTemp;
                    hiddenTag.val(JSON.stringify(dataProduct));
                }
            });
            if ($(`#columns-${idPrd}`).height() > 500) {
                $(`#columns-${idPrd}`).css('height', '500px');
                $(`#columns-${idPrd}`).css('overflow-y', 'scroll');
                $(`#columns-${idPrd}`).css('overflow-x', 'hidden');
            }
            $(`#columns-${idPrd}`).animate({
                scrollTop: $(
                    'html, body').get(0).scrollHeight
            }, 1000);
        }
    });
    $(".canvas").css("width", "auto");
    window.changeProductInRow = function (vl) {
        if(typeof dataProduct === "undefined"){
            product_in_row=vl;
        }else{
            dataProduct.product_in_rows = vl;
            $(`#data-product-${idPrd}`).val(JSON.stringify(dataProduct));
            console.log(dataProduct);
        }
    }
}
