@if((new \Jenssegers\Agent\Agent())->isDesktop())
    <div class="row row-customer row-landing-page-v1 banner-landingpage-v1">
        @foreach($banners as $banner)
            @if(!empty($banner))
                <div class="col-md-{{round(12/$loop->count)}} pl-0 pr-0">
                    <div class="item banner-item">
                        <a href="{{$banner['link_website']}}" title="{{$banner['title']}}">
                            <img data-src="{{$banner['link_img']}}"
                                 style="height: {{$banner['height']}}px; max-height: 443px;" alt="{{$banner['title']}}"
                                 class="img-fluid mx-auto d-block lazy">
                        </a>
                    </div>
                </div>
            @endif
        @endforeach
            @if($status == 1)
                <div id="overlay"><span>CHƯƠNG TRÌNH KHUYẾN MÃI ĐÃ HẾT HẠN</span></div>
            @endif
    </div>
@else
    <div class="row row-customer row-landing-page-v1 banner-landingpage-v1">
        @foreach($banners as $banner)
            @if(!empty($banner))
                <div class="col-md-{{round(12/$loop->count)}} pl-0 pr-0">
                    <div class="item banner-item">
                        <a href="{{$banner['link_website']}}" title="{{$banner['title']}}">
                            <img data-src="{{$banner['link_img']}}"
                                 style="height: {{$banner['height']}}px; max-height: 250px;" alt="{{$banner['title']}}"
                                 class="img-fluid mx-auto d-block lazy">
                        </a>
                    </div>
                </div>
            @endif
        @endforeach
        @if($status == 1)
        <div id="overlay"><span>CHƯƠNG TRÌNH KHUYẾN MÃI ĐÃ HẾT HẠN</span></div>
        @endif
    </div>
@endif
