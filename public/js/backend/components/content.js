function excuseContent(child, element){
    let id = `tinymce-`+ Math.floor((Math.random() * 100000)).toString() + Math.floor((Math.random() * 100000)).toString()  + $('.canvas>.child').length;

    let textarea = $(`<div id="parent-${id}"><textarea class="tinymce" id="${id}"></textarea></div><div class="div-save-content"><input type="button" class="btn btn-primary btn-save-content" onclick="saveContent('${id}')" value="save"></div>`);
    child.html(`<h2 style="text-align: center">Content</h2><div class='content' id="ct-${id}"></div>
                            <button type="button" style="display: none" class="btn btn-contents btn-success edit-content-${id}" onclick="editContent('${id}')">
                                EDIT
                            </button>
                            <button type="button" style="display: none" class="btn btn-danger delete-content delete-content-${id}" onclick="deleteContent('${id}')">
                                <i class="fa fa-times" aria-hidden="true"></i>
                            </button>
                            <input type="hidden" class="block-data" name="content-${id}" id="data-content-${id}" >
                         `);
    child.append(textarea);
    $(element).append(child);

    //extend
    tinyMCE.execCommand('mceAddEditor', false, id);
    $(".canvas").css("width", "auto");
}

function saveContent(idTinymce) {
    let ct = tinyMCE.get(`${idTinymce}`).getContent();
    $(`#ct-${idTinymce}`).html(ct);
    $(`.edit-content-${idTinymce}`).show();
    $(`.delete-content-${idTinymce}`).show();
    $(`#ct-${idTinymce}`).show();
    $(`#parent-${idTinymce}`).hide();
    $(`#parent-${idTinymce}`).next().hide();
    $(`#data-content-${idTinymce}`).val(JSON.stringify({
        type: "content",
        description: ct
    }));
}

function editContent(idTinymce){
    $(`.edit-content-${idTinymce}`).hide();
    $(`#ct-${idTinymce}`).hide();
    $(`#parent-${idTinymce}`).show();
    $(`#parent-${idTinymce}`).next().show();
    $(`.delete-content-${idTinymce}`).hide();
}

function deleteContent(idTinymce){
    $(`#parent-${idTinymce}`).parents('div.child').remove();
}
function zoomContent(idTinymce,el){
    $(`#parent-${idTinymce}`).parents('div.child').addClass('full-width-product');
    $(el).hide();
    $(`.thumb-content-${idTinymce}`).show();
    $(`.delete-content-${idTinymce}`).hide();
}
function thumbContent(idTinymce,el){
    $(`#parent-${idTinymce}`).parents('div.child').removeClass('full-width-product');
    $(el).hide();
    $(`.zoom-content-${idTinymce}`).show();
    $(`.delete-content-${idTinymce}`).show();
}
