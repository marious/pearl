<section class="page-title" style="background-image: url(/storage/images/background/8.jpg);">
    <div class="auto-container">
        <div class="title-outer">
            <h1>الأقسام والعيادات</h1>
        </div>
    </div>
</section>

<section class="services-section-two">
    <div class="auto-container">

        <div class="carousel-outer">
            <div class="row">
                <!-- service Block -->
                @foreach ($departments as $department)
                <div class="service-block-two col-lg-4 col-md-6 col-sm-12">
                    <div class="inner-box">
                        <div class="image-box">
                            <figure class="image"><a href="department-detail.html"><img src="images/departments/doctor_kids_thumb.jpg" alt=""></a></figure>
                        </div>
                        <div class="lower-content">
                            <div class="title-box">
                                <span class="icon flaticon-heart-2"></span>
                                <h4><a href="{{ $department->url }}">{{ $department->name }}</a></h4>
                            </div>
                            <div class="text">
                                @if($department->content)
                                    {{ utf8_word_truncate(trim(strip_tags($department->content)), 25)}}
                                @elseif($department->descripiton)
                                    {{ utf8_word_truncate(trim(strip_tags($department->descripiton)), 25)}}
                                @endif
                            </div>
                            <a href="{{ $department->url }}" class="read-more"><i class="flaticon-left"></i> قراءة المزيد </a>
                            <span class="icon-right flaticon-heart-2"></span>
                        </div>
                    </div>
                </div>
                @endforeach
            </div>

            <!--Styled Pagination-->
            {{ $departments->links() }}
{{--            <ul class="styled-pagination">--}}
{{--                <li><a href="#" class="arrow"><span class="flaticon-left"></span></a></li>--}}
{{--                <li><a href="#">1</a></li>--}}
{{--                <li><a href="#" class="active">2</a></li>--}}
{{--                <li><a href="#">3</a></li>--}}
{{--                <li><a href="#" class="arrow"><span class="flaticon-right"></span></a></li>--}}
{{--            </ul>--}}
            <!--End Styled Pagination-->
        </div>
    </div>
</section>
