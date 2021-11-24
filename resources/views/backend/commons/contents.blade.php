<h2 style="text-align: center">Content</h2><div class='content' id="ct-{{$id}}"></div>
<button type="button" style="display: none" class="btn btn-contents btn-success edit-content-{{$id}}" onclick="editContent('{{$id}}')">
    <span>
      <i class="fa fa-pencil" aria-hidden="true"></i>
    </span>
</button>
<button type="button" style="display: none" class="btn btn-danger delete-content delete-content-{{$id}}" onclick="deleteContent('{{$id}}')">
    <i class="fa fa-times" aria-hidden="true"></i>
</button>
<input type="hidden" class="block-data" name="content-{{$id}}" id="data-content-{{$id}}" >
<div id="parent-{{$id}}"><textarea class="tinymce" id="{{$id}}">{{$description}}</textarea></div><div class="div-save-content">
    <button type="button" class="btn btn-primary btn-save-content" onclick="saveContent('{{$id}}')">
    <span>
      <i class="fa fa-floppy-o" aria-hidden="true"></i>
    </span>
    </button>
</div>

<script>
    $(document).ready(function () {
        setTimeout(function(){
            saveContent('{{$id}}');
        }, 2000);
    });
</script>
