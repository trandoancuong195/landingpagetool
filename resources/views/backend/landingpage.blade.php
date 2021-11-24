<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Laravel</title>
    <link rel="stylesheet" type="text/css" href="/css/app.css">
    <link href="/bootstrap/css/all.min.css" rel="stylesheet" type="text/css">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.3/css/select2.min.css" rel="stylesheet" />
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.6.1/css/font-awesome.min.css">
    <script src="/js/libs/jquery.js"></script>
    <script src="/js/libs/jquery-ui.min.js"></script>
    <script src="/js/libs/bootstrap.min.js"></script>
    <script src="/js/libs/jquery.nestable.js "></script>
    <script src="/js/libs/select2.js "></script>
{{--    <link href="css/vendor/font/css/datepicker.css" rel="stylesheet" type="text/css">--}}

    <!-- import components -->
    <script src="/js/backend/components/content.js "></script>
    <script src="/js/backend/components/product.js "></script>
    <script src="/js/backend/components/banner.js "></script>
    <script src="/js/backend/components/menu.js "></script>
    <!-- call code general form component -->
    <script src="/js/backend/components/index.js "></script>
    <script src="{{ asset('node_modules/tinymce/tinymce.min.js') }}"></script>
    <script>var obj = []</script>
</head>
{{--<button type="button" class="btn btn-warning make-landingpage">--}}
{{--    <svg width="1em" height="1em" viewBox="0 0 16 16" class="bi bi-plus-circle" fill="currentColor" xmlns="http://www.w3.org/2000/svg">--}}
{{--        <path fill-rule="evenodd" d="M8 15A7 7 0 1 0 8 1a7 7 0 0 0 0 14zm0 1A8 8 0 1 0 8 0a8 8 0 0 0 0 16z"/>--}}
{{--        <path fill-rule="evenodd" d="M8 4a.5.5 0 0 1 .5.5v3h3a.5.5 0 0 1 0 1h-3v3a.5.5 0 0 1-1 0v-3h-3a.5.5 0 0 1 0-1h3v-3A.5.5 0 0 1 8 4z"/>--}}
{{--    </svg>--}}
{{--</button>--}}
<a type="button" href="{{url('/')}}" class="btn btn-danger close-landingpage">
    <i class="fa fa-times" aria-hidden="true"></i>
</a>
<button type="button" onclick="saveTemplate()" class="btn btn-success save-landingpage">
    <i class="fa fa-floppy-o" aria-hidden="true"></i>
</button>
<a type="button" href="{{url('/review-landingpage')}}/{{$landingpage['slug']}}" target="_blank" class="btn btn-info btn-circle view-landingpage">
    <i class="fas fa-eye"></i>
</a>
<input type="hidden" name="landingpageid" id="LandingPageId" value="{{ app('request')->input('id')}}">
<input type="hidden"  id="use-for-page" value="{{$landingpage['use_for_page']}}">
<input type="hidden"  id="url_cscart" value="{{env('URL_CSCART')}}">
<input type="hidden" id="authorization_v2" value="{{config('constants.authorization_v2')}}">
<input type="hidden" id="authorization_v1" value="{{config('constants.authorization_v1')}}">
<input type="hidden" id="authorization_mrtho" value="{{config('constants.authorization_mrtho')}}">
<input type="hidden"  id="url_tatmart" value="{{env('URL_TATMART')}}">
<input type="hidden" id="url-insert" url="{{url('insertComponent')}}" />
<div class="canvas">
    @foreach($listComponent as $component)
        <div class="child">
        @if($component['type'] == "content")
            @include('backend.commons.contents', ['id' => $component['position'],'description'=>$component['description']])
        @elseif($component['type'] == "menu")
            @include('backend.commons.menu', ['id' => $component['position'],'menu'=>$component['data'][0]])
                <script>
                    $('#nestable').nestable({
                        maxDepth: 3
                    }).on('change', saveMenuBlock);
                </script>
        @elseif($component['type'] == "product")
                @include('backend.commons.products', ['id' => $component['position']])
        @elseif($component['type'] == "banner")
                @include('backend.commons.banners', ['id' => $component['position']])
        @endif
        </div>
    @endforeach
</div>

<div class="navbar-landingpage d-none" align="center">
    @yield('contents',View::make('backend.components.contents'))
    @yield('products',View::make('backend.components.products'))
    @yield('banners',View::make('backend.components.banners'))
    @yield('menu',View::make('backend.components.menu'))
{{--    @yield('tab',View::make('backend.components.tab'))--}}
{{--    @yield('grids',View::make('backend.components.grids'))--}}

</div>
<script>

    tinymce.init({
        selector: 'textarea.tinymce',
        plugins: [
            "advlist autolink lists link image charmap print preview anchor",
            "searchreplace visualblocks code fullscreen",
            "insertdatetime media table contextmenu paste textcolor"
        ],
        menubar: true,
        statusbar: true,
        force_p_newlines: true,
        extended_valid_elements: "i[*],span[*]",
        forced_root_block: '',
        media_strict: false,
        toolbar: undefined,
        resize: true,
        theme: 'modern',
        strict_loading_mode: true,
        convert_urls: false,
        remove_script_host: false,
        body_class: 'wysiwyg-content'
    });

</script>
</html>
