<div id="parent-{{$id}}"><h2 style="text-align: center">Menu</h2>
    <button type="button" class="btn btn-danger delete-content delete-content-{{$id}}" onclick="deleteContent('{{$id}}')">
        <i class="fa fa-times" aria-hidden="true"></i>
    </button></div>
<div class='banner' id="banner-{{$id}}"></div>
<input type="hidden" name="dataMenu" class="block-data dataMenu" value="">
<div class="row">
    <div class="col-md-4">
        <form class="form-inline form-menu" id="menu-add">
            <div class="w-100">
                <h3>Add Menu </h3>
                <div class="form-group">
                    <input type="text" class="form-control" id="addInputName" placeholder="Item name" required>
                </div>
                <div>&nbsp;</div>
                <div class="form-group">
                    <input type="text" class="form-control" id="addInputSlug" placeholder="item-slug" required>
                </div>
                <div>&nbsp;</div>
                <div class="form-group">
                    <button class="btn btn-primary button-add-menu" id="addButton" onclick="addToMenu()"> <i class="fa fa-plus-circle" aria-hidden="true"></i> Add Item</button>
                </div>
            </div>
        </form>

        <form class="form-menu" id="menu-editor" style="display: none;">
            <div class="w-100">
                <h3>Editing <span id="currentEditName"></span></h3>
                <div class="form-group">
                    <input type="text" class="form-control" id="editInputName" placeholder="Item name" required>
                </div>
                <div class="form-group">
                    <input type="text" class="form-control" id="editInputSlug" placeholder="item-slug">
                </div>
                <div>&nbsp;</div>
                <div class="form-group">
                    <button class="btn btn-info button-add-menu" id="editButton">Edit</button>
                </div>
            </div>
        </form>
    </div>
    <div class="col-md-8">
        <h3>List Menu</h3>
        <div class="dd nestable" id="nestable">
            <ol class="dd-list">
                @foreach($menu as $mn)
                    @if(empty($mn['children']) && $mn['deleted'] == 0)
                    <li class="dd-item" data-id="{{$mn['id']}}" data-name="{{$mn['name']}}" data-slug="{{$mn['slug']}}" data-new="{{$mn['new']}}" data-deleted="{{$mn['deleted']}}">
                        <div class="dd-handle">{{$mn['name']}}</div>
                        <span onclick="deleteFromMenu(this)" class="button-delete btn btn-danger btn-xs pull-right"
                              data-owner-id="{{$mn['id']}}">
                          <i class="fa fa-times" aria-hidden="true"></i>
                        </span>
                                <span onclick="prepareEdit(this)" class="button-edit btn btn-success btn-xs pull-right"
                                      data-owner-id="{{$mn['id']}}">
                          <i class="fa fa-pencil" aria-hidden="true"></i>
                        </span>
                    </li>
                    @elseif($mn['deleted'] == 0)
                        <!--- Item4 --->
                        <li class="dd-item" data-id="{{$mn['id']}}" data-name="{{$mn['name']}}" data-slug="{{$mn['slug']}}" data-new="{{$mn['new']}}" data-deleted="{{$mn['deleted']}}">
                            <div class="dd-handle">{{$mn['name']}}</div>
                            <span onclick="deleteFromMenu(this)" class="button-delete btn btn-danger btn-xs pull-right"
                                  data-owner-id="{{$mn['id']}}">
                          <i class="fa fa-times" aria-hidden="true"></i>
                        </span>
                            <span onclick="prepareEdit(this)" class="button-edit btn btn-success btn-xs pull-right"
                                  data-owner-id="{{$mn['id']}}">
                          <i class="fa fa-pencil" aria-hidden="true"></i>
                        </span>
                        <ol class="dd-list">
                        @foreach($mn['children'] as $child)
                            @if(empty($child['children']))
                                <li class="dd-item" data-id="{{$child['id']}}" data-name="{{$child['name']}}" data-slug="{{$child['slug']}}" data-new="{{$child['new']}}" data-deleted="{{$child['deleted']}}">
                                    <div class="dd-handle">{{$child['name']}}</div>
                                    <span onclick="deleteFromMenu(this)" class="button-delete btn btn-danger btn-xs pull-right"
                                          data-owner-id="{{$child['id']}}">
                                      <i class="fa fa-times" aria-hidden="true"></i>
                                    </span>
                                            <span onclick="prepareEdit(this)" class="button-edit btn btn-success btn-xs pull-right"
                                                  data-owner-id="{{$child['id']}}">
                                      <i class="fa fa-pencil" aria-hidden="true"></i>
                                    </span>
                                </li>
                            @else
                                <li class="dd-item" data-id="{{$child['id']}}" data-name="{{$child['name']}}" data-slug="{{$child['slug']}}" data-new="{{$child['new']}}" data-deleted="{{$child['deleted']}}">
                                    <div class="dd-handle">{{$child['name']}}</div>
                                    <span onclick="deleteFromMenu(this)" class="button-delete btn btn-danger btn-xs pull-right"
                                          data-owner-id="{{$child['id']}}">
                                  <i class="fa fa-times" aria-hidden="true"></i>
                                </span>
                                    <span onclick="prepareEdit(this)" class="button-edit btn btn-success btn-xs pull-right"
                                          data-owner-id="{{$child['id']}}">
                                  <i class="fa fa-pencil" aria-hidden="true"></i>
                                </span>
{{--                                <ol class="dd-list">--}}
{{--                                    <!--- Item4 --->--}}
{{--                                    @foreach($child['children'] as $item)--}}
{{--                                        <li class="dd-item" data-id="{{$item['id']}}"  data-name="{{$item['name']}}" data-slug="{{$item['slug']}}" data-new="{{$item['new']}}" data-deleted="{{$item['deleted']}}">--}}
{{--                                            <div class="dd-handle">{{$item['name']}}</div>--}}
{{--                                            <span onclick="deleteFromMenu(this)" class="button-delete btn btn-danger btn-xs pull-right"--}}
{{--                                                  data-owner-id="{{$item['id']}}">--}}
{{--                                              <i class="fa fa-times" aria-hidden="true"></i>--}}
{{--                                            </span>--}}
{{--                                            <span onclick="prepareEdit(this)" class="button-edit btn btn-success btn-xs pull-right"--}}
{{--                                                              data-owner-id="{{$item['id']}}">--}}
{{--                                              <i class="fa fa-pencil" aria-hidden="true"></i>--}}
{{--                                            </span>--}}
{{--                                        </li>--}}
{{--                                    @endforeach--}}
{{--                                </ol>--}}
                                </li>
                            @endif
                        @endforeach
                        </ol>
                        </li>
                    @endif
                @endforeach
                <!--- Initial Menu Items --->

{{--                <!--- Item1 --->--}}
{{--                <li class="dd-item" data-id="1" data-name="Home" data-slug="home-slug-1" data-new="0" data-deleted="0">--}}
{{--                    <div class="dd-handle">Home </div>--}}
{{--                    <span onclick="deleteFromMenu(this)" class="button-delete btn btn-danger btn-xs pull-right"--}}
{{--                          data-owner-id="1">--}}
{{--                  <i class="fa fa-times" aria-hidden="true"></i>--}}
{{--                </span>--}}
{{--                    <span onclick="prepareEdit(this)" class="button-edit btn btn-success btn-xs pull-right"--}}
{{--                          data-owner-id="1">--}}
{{--                  <i class="fa fa-pencil" aria-hidden="true"></i>--}}
{{--                </span>--}}
{{--                </li>--}}

{{--                <!--- Item2 --->--}}
{{--                <li class="dd-item" data-id="2" data-name="About Us" data-slug="about-slug-2" data-new="0" data-deleted="0">--}}
{{--                    <div class="dd-handle">About Us</div>--}}
{{--                    <span onclick="deleteFromMenu(this)" class="button-delete btn btn-danger btn-xs pull-right"--}}
{{--                          data-owner-id="2">--}}
{{--                  <i class="fa fa-times" aria-hidden="true"></i>--}}
{{--                </span>--}}
{{--                    <span onclick="prepareEdit(this)" class="button-edit btn btn-success btn-xs pull-right"--}}
{{--                          data-owner-id="2">--}}
{{--                  <i class="fa fa-pencil" aria-hidden="true"></i>--}}
{{--                </span>--}}
{{--                </li>--}}

{{--                <!--- Item3 --->--}}
{{--                <li class="dd-item" data-id="3" data-name="Services" data-slug="services-slug-3" data-new="0" data-deleted="0">--}}
{{--                    <div class="dd-handle">Services</div>--}}
{{--                    <span onclick="deleteFromMenu(this)" class="button-delete btn btn-danger btn-xs pull-right"--}}
{{--                          data-owner-id="3">--}}
{{--                  <i class="fa fa-times" aria-hidden="true"></i>--}}
{{--                </span>--}}
{{--                    <span onclick="prepareEdit(this)" class="button-edit btn btn-success btn-xs pull-right"--}}
{{--                          data-owner-id="3">--}}
{{--                  <i class="fa fa-pencil" aria-hidden="true"></i>--}}
{{--                </span>--}}
{{--                    <!--- Item3 children --->--}}
{{--                    <ol class="dd-list">--}}
{{--                        <!--- Item4 --->--}}
{{--                        <li class="dd-item" data-id="4" data-name="UI/UX Design" data-slug="uiux-slug-4" data-new="0" data-deleted="0">--}}
{{--                            <div class="dd-handle">UI/UX Design</div>--}}
{{--                            <span onclick="deleteFromMenu(this)" class="button-delete btn btn-danger btn-xs pull-right"--}}
{{--                                  data-owner-id="4">--}}
{{--                      <i class="fa fa-times" aria-hidden="true"></i>--}}
{{--                    </span>--}}
{{--                            <span onclick="prepareEdit(this)" class="button-edit btn btn-success btn-xs pull-right"--}}
{{--                                  data-owner-id="4">--}}
{{--                      <i class="fa fa-pencil" aria-hidden="true"></i>--}}
{{--                    </span>--}}
{{--                        </li>--}}

{{--                        <!--- Item5 --->--}}
{{--                        <li class="dd-item" data-id="5" data-name="Web Design" data-slug="webdesign-slug-5" data-new="0" data-deleted="0">--}}
{{--                            <div class="dd-handle">Web Design </div>--}}
{{--                            <span onclick="deleteFromMenu()" class="button-delete btn btn-danger btn-xs pull-right"--}}
{{--                                  data-owner-id="5">--}}
{{--                      <i class="fa fa-times" aria-hidden="true"></i>--}}
{{--                    </span>--}}
{{--                            <span onclick="prepareEdit(this)" class="button-edit btn btn-success btn-xs pull-right"--}}
{{--                                  data-owner-id="5">--}}
{{--                      <i class="fa fa-pencil" aria-hidden="true"></i>--}}
{{--                    </span>--}}
{{--                        </li>--}}

{{--                    </ol>--}}
{{--                </li>--}}
{{--                <li class="dd-item" data-id="6" data-name="Contact Us" data-slug="contact-slug-6" data-new="0" data-deleted="0">--}}
{{--                    <div class="dd-handle">Contact Us</div>--}}
{{--                    <span onclick="deleteFromMenu(this)" class="button-delete btn btn-danger btn-xs pull-right"--}}
{{--                          data-owner-id="6">--}}
{{--                  <i class="fa fa-times" aria-hidden="true"></i>--}}
{{--                </span>--}}
{{--                    <span onclick="prepareEdit(this)" class="button-edit btn btn-success btn-xs pull-right"--}}
{{--                          data-owner-id="6">--}}
{{--                  <i class="fa fa-pencil" aria-hidden="true"></i>--}}
{{--                </span>--}}
{{--                </li>--}}
                <!--------------------------->

            </ol>
        </div>
    </div>
</div>
<script>
    $(`#menu-add`).submit(function (e) {
        e.preventDefault();
    });
    $("#editButton").on("click", editMenuItem);
    $(`#menu-editor`).submit(function (e) {
        e.preventDefault();
    });
</script>
