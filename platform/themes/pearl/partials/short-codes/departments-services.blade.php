@if (is_plugin_active('hospital'))
@php
$departments = get_departments_for_front(9);
// $featuredList = [];
// if (!empty($featured)) {
//   $featuredList = $featured->pluck('id')->all();
// }
@endphp
<!-- service Block -->
@if (!empty($departments))
 <section class="services-section">
     <div class="auto-container">
         <h2>أقسامنا وعياداتنا الطبية</h2>
         <div class="carousel-outer">
             <div class="services-carousel owl-carousel owl-theme default-dots">
                 @foreach ($departments as $department)
                     <div class="service-block-four">
                         <div class="inner-box">
                             <div class="image-box">
                                 <figure class="image"><a href="{{ $department->url }}"><img src="{{ RvMedia::getImageUrl($department->image, 'department', false, RvMedia::getDefaultImage()) }}" alt="{{ $department->name }}"></a></figure>
                             </div>
                             <div class="lower-content">
                                 <h4><a href="">{{ $department->name }}</a></h4>
                                 <div class="text">
                                     @if($department->content)
                                         {{ utf8_word_truncate(trim(strip_tags($department->content)), 25)}}
                                     @elseif($department->descripiton)
                                         {{ utf8_word_truncate(trim(strip_tags($department->descripiton)), 25)}}
                                     @endif
                                 </div>
                                 <a href="{{ $department->url }}" class="read-more"><i class="flaticon-left"></i> قراءة المزيد </a>
                             </div>
                         </div>
                     </div>
                 @endforeach
                 <div class="services-carousel owl-carousel owl-theme default-dots"></div>
                 <div class="services-carousel owl-carousel owl-theme default-dots"></div>
             </div>
         </div>
     </div>

@endif
 </section>
@endif
