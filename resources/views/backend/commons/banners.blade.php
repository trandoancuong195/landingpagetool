<div id="parent-{{$id}}"><h2 style="text-align: center">Banner</h2>
    <button type="button" class="btn btn-danger delete-content delete-content-{{$id}}" onclick="deleteContent('{{$id}}')">
        <i class="fa fa-times" aria-hidden="true"></i>
    </button></div>
<div class='banner' id="banner-{{$id}}"></div>
<div class="row">
    <div class="col-md-4">
        <div class="w-100">
        <form class="form-inline form-menu" class="banner-border" id="banner-add-{{$id}}">
                <h3>Add banner </h3>
                <div class="form-group">
                    <input type="text" class="form-control" id="addInputImage-{{$id}}" placeholder="link image" required>
                </div>
                <div>&nbsp;</div>
                <div class="form-group">
                    <input type="text" class="form-control" id="addInputUrl-{{$id}}" placeholder="link redirect image" required>
                </div>
                <div class="form-group">
                    <input type="text" class="form-control" id="addInputTitle-{{$id}}" placeholder="Title image" required>
                </div>
                <div>&nbsp;</div>
                <button class="btn btn-primary button-add-menu" id="addButton-{{$id}}"> <i class="fa fa-plus-circle" aria-hidden="true"></i> Add Item</button>
        </form>
        </div>
        <div class="w-100">
            <form class="form-menu" id="banner-editor-{{$id}}" style="display: none;">
                <h3>Editing <span id="currentEditName-{{$id}}"></span></h3>
                <div class="form-group">
                    <input type="text" class="form-control" id="editInputName-{{$id}}" placeholder="link image" required>
                </div>
                <div class="form-group">
                    <input type="text" class="form-control" id="editInputUrl-{{$id}}" placeholder="link redirect image" required>
                </div>
                <div class="form-group">
                    <input type="text" class="form-control" id="editInputTitle-{{$id}}" placeholder="Title image">
                </div>
                <div>&nbsp;</div>
                <button class="btn btn-info button-add-menu" onclick="editbannerItem({{$id}},this)" id="editButton-{{$id}}">Edit</button>
            </form>
        </div>
    </div>
    <div class="col-md-8">
        <h3>List Banner</h3>
        <div class="dd nestable-{{$id}}" id="nestable-{{$id}}">
            <input type="hidden" class="block-data" name="data-banner-{{$id}}" id="data-banner-{{$id}}" >
            <ul class="dd-list-{{$id}}">
                @foreach($component['data'] as $banner)
                    <li class="dd-item" data-id-banner="{{$banner['id']}}" data-image="{{$banner['link_img']}}"
                        data-url="{{$banner['link_website']}}" data-title="{{$banner['title']}}" data-new="1" data-deleted="0">
                        <div class="dd-handle"><a href="{{$banner['link_website']}}"><img class="img-thumb" src='{{$banner['link_img']}}' />{{$banner['title']}}</a></div>
                        <span onclick="deleteFrombanner('{{$id}}',this)" class="button-delete btn btn-danger btn-xs pull-right"
                              data-banner-id="{{$banner['id']}}"><i class="fa fa-times" aria-hidden="true"></i>
                                    </span>
                        <span onclick="prepareEditBanner('{{$id}}',this)" class="button-edit btn btn-success btn-xs pull-right"
                              data-banner-id="{{$banner['id']}}">
                                    <i class="fa fa-pencil" aria-hidden="true"></i>
                                    </span>
                    </li>
                @endforeach
            </ul>
        </div>
    </div>
</div>


<script>
    $(`#data-banner-{{$id}}`).val(`{!!$component!!}`);
    let el = $(`#nestable-{{$id}} > .dd-list-{{$id}}`);
    $(`#banner-add-{{$id}}`).submit(function (e) {
        e.preventDefault();
        addTobanner(el, {{$id}});
    });
    $(`.dd-list-{{$id}}`).hover(function () {
        $(".canvas").addClass('canvas1');
        $(".canvas1").removeClass("canvas");
    }, function () {
        $(".canvas1").addClass('canvas');
    });
</script>
