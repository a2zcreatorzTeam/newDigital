 <div class="section" id="section1">
     <div class="services-item-wrap mt-50">
         <h2 style="text-align: center;">{{ $main_category->name }}</h2>
         <div class="row justify-content-center mt-50">
             @foreach($policies as $data)
             <div class="col-xl-3 col-lg-4 col-md-6 col-sm-8">
                 <div class="box" id="box3">
                     <div class="services-item shine-animate-item">
                         <div class="services-thumb">
                             <a href="{{ route('frontend.dashboard') }}" class="shine-animate"><img src="{{ asset('storage/'.$data->logo) }}" alt="image"></a>
                         </div>
                         <div class="services-content">
                             <div class="icon">
                                 <img src="{{asset('frontend/images/Mahfooz-Plan.png')}}" alt="">
                             </div>
                             <h4 class="title"><a href="{{ route('frontend.product') }}"> {{ $data->name }}</a></h4>
                           
                         </div>
                     </div>
                 </div>
             </div>
             @endforeach
         </div>
         <div style="text-align: center;"><img width="600px" src="{{asset('frontend/images/line.png')}}" alt=""></div>
     </div>
 </div>