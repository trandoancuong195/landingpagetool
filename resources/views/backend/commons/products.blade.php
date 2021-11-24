<div class='product' id="block-prd-{{$id}}"></div>
<h2 style="text-align: center">Product</h2>
<div id="parent-{{$id}}">
    <div class="form-group" style="display: flex">
        <label for="tag_list-{{$id}}">products:</label>
        <select id="tag_list-{{$id}}" class="form-control" style="width: 50%"></select>
        <div class="form-check" style="margin: 0 30px; display: flex;align-items: center">
            <input class="form-check-input" style="margin-top: 0px" type="radio" name="productperrow-{{$id}}" value="4" onclick="changeProductInRow({{$id}}, 4)" @if($component['product_in_rows'] == 4) checked @endif id="flexRadioDefault1">
            <label class="form-check-label" for="flexRadioDefault1">
                4 product in row
            </label>
        </div>
        <div class="form-check" style="display: flex;align-items: center">
            <input class="form-check-input" type="radio" name="productperrow-{{$id}}" value="5" id="flexRadioDefault2" onclick="changeProductInRow({{$id}}, 5)" @if($component['product_in_rows'] == 5) checked @endif>
            <label class="form-check-label" for="flexRadioDefault2">
                5 product in row
            </label>
        </div>
    </div>
</div>
<input type="hidden" id="list-product-{{$id}}"
       value="@foreach($component['data'] as $product){{$product['id']}},@endforeach">
<input type="hidden" class="block-data" name="data-product-{{$id}}" id="data-product-{{$id}}">
<ul id="columns-{{$id}}" class="parent-column" style="width: 100%">
    @foreach($component['data'] as $product)
        <li class="column" class="data-product-id-${data.id}" data-product-id="{{$product['id']}}">
            <div class="row">
                <div class="col-md-12">
                    <div style="width: 50px;height: 50px; display: flex">
                        <img style="max-width: 100%; margin-right: 35px;"
                             src="{{ $product['image'] ? $product['image'] : ''}}"/>
                        <div class="button-delete-prd">
                            <button type="button" class="btn btn-danger button-edit-product"
                                    onclick="removeProducts({{$id}},{{$product['id']}}, this)">
                                <i class="fa fa-times" aria-hidden="true"></i>
                            </button>
                        </div>
                    </div>
                    <div style="position: absolute;top: 20px;left: 100px;">
                        {{$product['name']}} - {{$product['code']}} - {{$product['price']}}
                    </div>
                </div>
            </div>
        </li>
    @endforeach
</ul>
<input type="hidden" id="data-products-{{$id}}" value="{{json_encode($component['data'])}}">
<button type="button" class="btn btn-light zoom-content zoom-content-{{$id}}" onclick="zoomContent('{{$id}}',this)">
    <i class="fa fa-angle-left" aria-hidden="true"></i>
    <i class="fa fa-angle-right" aria-hidden="true"></i>
</button>
<button type="button" class="btn btn-light thumb-content thumb-content-{{$id}}" onclick="thumbContent('{{$id}}',this)">
    <i class="fa fa-angle-right" aria-hidden="true"></i>
    <i class="fa fa-angle-left" aria-hidden="true"></i>
</button>
<button type="button" class="btn btn-danger delete-content delete-content-{{$id}}" onclick="deleteContent('{{$id}}')">
    <i class="fa fa-times" aria-hidden="true"></i>
</button>
<script>
    obj["columns-{{$id}}"] = {!! json_encode($component)  !!};
    $(`#columns-{{$id}}`).hover(function () {
        $(".canvas").addClass('canvas1');
        $(".canvas1").removeClass("canvas");
    }, function () {
        $(".canvas1").addClass('canvas');
        $(".canvas").removeClass("canvas1");
    });
    $("#columns-{{$id}}").sortable({
        update: function (event, ui) {
            let dataTemp = [];
            let hiddenTag = $(this).prev();
            let data = obj["columns-{{$id}}"].data;
            $(this).children("li").each(function () {
                for (let d in data) {
                    if (data[d].id == $(this).data("productId")) {
                        dataTemp.push(data[d])
                        data.splice(d, 1);
                        break;
                    }
                }
            });
            obj["columns-{{$id}}"].data = dataTemp;
            hiddenTag.val(JSON.stringify(obj["columns-{{$id}}"]))
        }
    });

    let authorization_v2_{{$id}} = $("#authorization_v2").val();
    let authorization_v1_{{$id}} = $("#authorization_v1").val();
    let authorization_mrtho_{{$id}} = $("#authorization_mrtho").val();
    let landingType_{{$id}} = $("#use-for-page").val();
    let urlCscart_{{$id}} = $("#url_cscart").val();
    let urlTatmart_{{$id}} = $("#url_tatmart").val();
    var dataHidden_{{$id}} = $(`#data-product-{{$id}}`).val();
    var dataprd_{{$id}} = $(`#data-products-{{$id}}`).val();
    let product_in_row_{{$id}} = $('input[name="productperrow-{{$id}}"]:checked').val();
    var dataProduct_{{$id}} = {
        type: "product",
        product_in_rows: product_in_row_{{$id}},
        data: []
    }
    if (dataHidden_{{$id}} !== "") {
        dataProduct = JSON.parse(dataHidden_{{$id}});
    }
    if (dataprd_{{$id}} !== "") {
        dataProduct_{{$id}}.data = JSON.parse(dataprd_{{$id}});
        $(`#data-product-{{$id}}`).val(JSON.stringify(dataProduct_{{$id}}));
    }
        {{--console.log(JSON.parse({{$component['data']}}));--}}
    let objAjax_{{$id}} = {
            url: urlCscart_{{$id}} + "api/products?show_master_products_only=1&status[]=A",
            headers: {
                "Authorization": authorization_v2_{{$id}}
            },
            dataType: 'json',
            data: function (params) {
                return {
                    q: $.trim(params.term),
                };
            }
        }
    switch (landingType_{{$id}}) {
        case "tatmartv1":
            objAjax_{{$id}} = {
                url: urlTatmart_{{$id}} + "products/get-list-product-landing-page",
                dataType: 'json',
                data: function (params) {
                    return {
                        search_keywords: $.trim(params.term),
                    };
                }
            }
            break;
        case "mrtho":
            objAjax_{{$id}} = {
                url: urlCscart_{{$id}} + "api/products?show_master_products_only=1&status[]=A",
                headers: {
                    "Authorization": authorization_mrtho_{{$id}}
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
    $(`#tag_list-{{$id}}`).select2({
        placeholder: "Choose product...",
        minimumInputLength: 1,
        closeOnSelect: false,
        ajax: {
            ...objAjax_{{$id}},
            cache: false,
            processResults: function (data) {
                let products = data.products.map(p => {
                    p.id = p.product_id
                    return p;
                })
                return {
                    results: products
                };
            }
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
            let vl = $(`#list-product-{{$id}}`).val().split(",");
            if ($(`#list-product-{{$id}}`).val() != "" && $.inArray(data.id, vl) > -1) return false;

            $(`#list-product-{{$id}}`).val($(`#list-product-{{$id}}`).val() + "," + data.id);
            let promotion_price = data.list_price ? data.list_price : '';
            let img = '';
            let url = '';
            if (landingType_{{$id}} == "tatmartv2") {
                img = data.main_pair ? data.main_pair.detailed.image_path : '';
                url = urlCscart_{{$id}}+ "index.php?dispatch=products.view&product_id=" + data.product_id;
            }
            if (landingType_{{$id}} == "tatmartv1") {
                img = data.image_file ? data.image_file : '';
                url = data.url ? data.url : '';
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
            dataProduct_{{$id}}.data.push(objProduct)
            $(`#data-product-{{$id}}`).val(JSON.stringify(dataProduct_{{$id}}));
            let blockProduct = `
                    <li class="column" class = "data-product-id-${data.id}" data-product-id="${data.id}">
                    <div class="row">
                        <div class="col-md-12">
                        <div style="width: 50px;height: 50px; display: flex">
                            ${(data.main_pair) ? `<img style="max-width: 100%; margin-right: 35px;" src='${data.main_pair.detailed.https_image_path}' />` : ``}
                             ${(data.image_file) ? `<div class='select2-result-repository__avatar'><img src='${data.image_file}' /></div>` : ``}
                            <div class="button-delete-prd">
                                <button type="button" class="btn btn-danger button-edit-product" onclick="removeProducts({{$id}},${data.id}, this)">
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
            $(`#columns-{{$id}}`).append(blockProduct);
            $("#columns-{{$id}}").sortable({
                update: function (event, ui) {
                    let dataTemp = [];
                    let hiddenTag = $(this).prev();
                    $(this).children("li").each(function () {
                        obj["columns-{{$id}}"].data.map(d => {
                            if (d.id == $(this).data("productId")) {
                                dataTemp.push(d)
                            }
                        })
                    });
                    obj["columns-{{$id}}"].data = dataTemp;
                    hiddenTag.val(JSON.stringify(obj["columns-{{$id}}"]))
                }
            });
            if ($(`#columns-{{$id}}`).height() > 500) {
                $(`#columns-{{$id}}`).css('height', '500px');
                $(`#columns-{{$id}}`).css('overflow-y', 'scroll');
                $(`#columns-{{$id}}`).css('overflow-x', 'hidden');
            }
            $(`#columns-{{$id}}`).animate({
                scrollTop: $(
                    'html, body').get(0).scrollHeight
            }, 1000);
        }
    });
    window.changeProductInRow = function (pos, vl) {
        dataProduct_{{$id}}.product_in_rows=vl;
        $(`#data-product-${pos}`).val(JSON.stringify(dataProduct_{{$id}}));
        console.log($(`#data-product-${pos}`).val());
        console.log('#data-product-{{$id}}');
    }
</script>
