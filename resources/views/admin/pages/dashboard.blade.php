@extends("admin.admin_app")

@section("content")

  

<div class="content-page">
      <div class="content">
        <div class="container-fluid">
          
          @if(Auth::User()->usertype=="Admin")  
                <div class="row">
                     
                    <div class="col-xl-3 col-md-4 col-6">
                        <a href="{{URL::to('admin/category')}}">
                        <div class="card-box widget-user">
                            <div class="text-center">
                                <h2 class="text-custom" data-plugin="counterup">{{$category}}</h2>
                                <h5 style="color: #f9f9f9;">{{trans('words.categories_text')}}</h5>
                            </div>
                        </div>
                        </a>
                    </div>

                    <div class="col-xl-3 col-md-4 col-6">
                        <a href="{{URL::to('admin/sub_category')}}">
                        <div class="card-box widget-user">
                            <div class="text-center">
                                <h2 class="text-purple" data-plugin="counterup">{{$sub_category}}</h2>
                                <h5 style="color: #f9f9f9;">{{trans('words.sub_categories_text')}}</h5>
                            </div>
                        </div>
                        </a>
                    </div>

                    <div class="col-xl-3 col-md-4 col-6">
                        <a href="{{URL::to('admin/authors')}}">
                        <div class="card-box widget-user">
                            <div class="text-center">
                                <h2 class="text-success" data-plugin="counterup">{{$authors}}</h2>
                                <h5 style="color: #f9f9f9;">{{trans('words.authors_text')}}</h5>
                            </div>
                        </div>
                        </a>
                    </div>

                    <div class="col-xl-3 col-md-4 col-6">
                        <a href="{{URL::to('admin/books')}}">
                        <div class="card-box widget-user">
                            <div class="text-center">
                                <h2 class="text-warning" data-plugin="counterup">{{$books}}</h2>
                                <h5 style="color: #f9f9f9;">{{trans('words.books_text')}}</h5>
                            </div>
                        </div>
                        </a>
                    </div>
 

                    <div class="col-xl-3 col-md-4 col-6">
                        <a href="{{URL::to('admin/users')}}">
                        <div class="card-box widget-user">
                            <div class="text-center">
                                <h2 class="text-info" data-plugin="counterup">{{$users}}</h2>
                                <h5 style="color: #f9f9f9;">{{trans('words.users')}}</h5>
                            </div>
                        </div>
                        </a>
                    </div>

                    <div class="col-xl-3 col-md-4 col-6">
                        <a href="{{URL::to('admin/transactions')}}">
                        <div class="card-box widget-user">
                            <div class="text-center">
                                <h2 class="text-danger" data-plugin="counterup">{{$transactions}}</h2>
                                <h5 style="color: #f9f9f9;">{{trans('words.transactions')}}</h5>
                            </div>
                        </div>
                        </a>
                    </div>

                    <div class="col-xl-3 col-md-4 col-6">
                        <a href="{{URL::to('admin/reviews')}}">
                        <div class="card-box widget-user">
                            <div class="text-center">
                                <h2 class="text-pink" data-plugin="counterup">{{$reviews}}</h2>
                                <h5 style="color: #f9f9f9;">{{trans('words.reviews')}}</h5>
                            </div>
                        </div>
                        </a>
                    </div>
                     

                    <div class="col-xl-3 col-md-4 col-6">
                        <a href="{{URL::to('admin/reports')}}">
                        <div class="card-box widget-user">
                            <div class="text-center">
                                <h2 class="text-dark" data-plugin="counterup">{{$reports}}</h2>
                                <h5 style="color: #f9f9f9;">{{trans('words.reports')}}</h5>
                            </div>
                        </div>
                        </a>
                    </div>
                     
 
                </div> 

                  
                <div class="row">
                
                <div class="col-xl-4 col-md-6">
                        <div class="card-box">
                            

                            <h4 class="header-title mt-0 m-b-5">{{trans('words.trending_now')}}</h4>
                            <p class="text-muted m-b-20">{{trans('words.based_on_30_days')}}</p>

                            <div class="inbox-widget nicescroll" style="height: 315px; overflow: hidden; outline: none;" tabindex="5000">

                                @foreach($trending_now as $trending_data)
                                 
                                <a href="Javascript::void(0);" class="text-inverse">
                                
                                <p class="font-600 m-b-5 " data-toggle="tooltip" data-html="true" data-placement="right" title='<img src="{{URL::to('/'.\App\Books::getBookInfo($trending_data->post_id,'image'))}}" alt="image" class="thumb-img"> 
                                <br/> <br/>
                                <span class="badge badge-success"><i class="fa fa-eye"></i> {{number_format_short($trending_data->total_views)}}</span> &nbsp;
                                <span class="badge badge-warning"><i class="fa fa-star"></i> {{\App\PostRatings::getPostTotalRatings($trending_data->post_id,"Book")}}</span> &nbsp;
                                <span class="badge badge-purple"><i class="fa fa-download"></i> {{post_download_count($trending_data->post_id,"Book")}}</span>
                                '>  
                                    {{Str::limit(stripslashes(\App\Books::getBookInfo($trending_data->post_id,'title')), 25)}} 
                                     
                                    <span class="badge badge-danger pull-right">{{number_format_short($trending_data->total_views)}} {{trans('words.views')}}  </span>
                                </p>

                                </a>

                                @endforeach
                                 
                            </div>
                        </div>
                </div>
                
                <div class="col-xl-4 col-md-6">
                    <div class="card-box">
                         

                        <h4 class="header-title mt-0 m-b-5">{{trans('words.latest_books')}}</h4>
                        <p class="text-muted m-b-20">&nbsp;</p>
                      
                        <div class="inbox-widget nicescroll" style="height: 315px; overflow: hidden; outline: none;" tabindex="5000">

                            @foreach($latest_books as $latest_data)
                                 
                                 <a href="Javascript::void(0);" class="text-inverse">
                                 <p class="font-600 m-b-5 " data-toggle="tooltip" data-html="true" data-placement="right" title='<img src="{{URL::to('/'.\App\Books::getBookInfo($latest_data->id,'image'))}}" alt="image" class="thumb-img"> 
                                <br/> <br/>
                                <span class="badge badge-success"><i class="fa fa-eye"></i> {{number_format_short(post_views_count($latest_data->id,"Book"))}}</span> &nbsp;
                                <span class="badge badge-warning"><i class="fa fa-star"></i> {{\App\PostRatings::getPostTotalRatings($latest_data->id,"Book")}}</span> &nbsp;
                                <span class="badge badge-purple"><i class="fa fa-download"></i> {{post_download_count($latest_data->id,"Book")}}</span>'>
                                  
                                     {{Str::limit(stripslashes($latest_data->title), 25)}} 
                                      
                                     <span class="badge badge-danger pull-right">{{number_format_short(post_views_count($latest_data->id,"Book"))}} {{trans('words.views')}}  </span>
                                 </p>
 
                                 </a>
 
                            @endforeach  

                            
                             
                        </div>
                    </div>
                </div>

                <div class="col-xl-4 col-md-6">
                    <div class="card-box">
                        

                        <h4 class="header-title mt-0 m-b-5">{{trans('words.top_country')}}</h4>
                        <p class="text-muted m-b-20">{{trans('words.based_on_30_days')}}</p>
                      
                        <div class="inbox-widget nicescroll" style="height: 315px; overflow: hidden; outline: none;" tabindex="5000">

                            @foreach($top_country as $country_data)

                            <p class="font-600 m-b-5"><img src="{{ URL::asset('admin_assets/country_icons/').'/'.strtolower(countryNameToISO3166($country_data->country,'US')) }}.png" alt="" style="width:20px;"> &nbsp;{{$country_data->country}} <span class="badge badge-success pull-right">{{number_format_short($country_data->count_row)}} <i class="fa fa-eye"></i></span></p>

                            @endforeach
 
                             
                        </div>
                    </div>
                </div>

                <div class="col-xl-4 col-md-6">
                    <div class="card-box">
                          
                        <h4 class="header-title mt-0 m-b-5">{{trans('words.latest_reviews')}}</h4>
                        <p class="text-muted m-b-20">&nbsp;</p>
                      
                        <div class="inbox-widget nicescroll" style="height: 315px; overflow: hidden; outline: none;" tabindex="5000">
                        
                        @foreach($latest_review as $review_data)
                            <a href="Javascript::void(0);" >
                                <div class="inbox-item">
                                    <div class="inbox-item-img">
                                    @if(isset(\App\User::getUserInfo($review_data->user_id)->user_image))                                 
 
                                    <img src="{{URL::to('upload/'.\App\User::getUserInfo($review_data->user_id,'user_image'))}}" alt="person" class="rounded-circle"/>
                                    
                                    @else
                                        
                                    <img src="{{ URL::asset('admin_assets/images/users/avatar-10.jpg') }}" alt="person" class="rounded-circle"/>
                                    
                                    @endif    
                                     
                                    </div>
                                    <p class="inbox-item-author" style="color: #fff;">{{ \App\User::getUserInfo($review_data->user_id,'name') }}</p>
                                    <p class="inbox-item-text">{{Str::limit(stripslashes($review_data->review_text), 40)}}</p>
                                    <p class="inbox-item-date">{{date('M d, Y',$review_data->date)}}</p>
                                </div>
                            </a>
                        @endforeach
 
                        </div>
                    </div>
                </div>

                  

                <div class="col-xl-8 col-md-6">
                <div class="card-box">
                         
                         <h4 class="header-title mt-0 m-b-30">{{trans('words.latest_reports')}}</h4>

                         <div class="table-responsive">
                                        <table class="table mb-0">
                                            <thead>
                                            <tr>
                                                <th style="width: 15%;">&nbsp;</th>
                                                <th style="width: 15%;">{{trans('words.name')}}</th>
                                                <th style="width: 40%;">{{trans('words.message')}}</th>
                                                <th style="text-align: center">Date</th>
                                                 
                                            </tr>
                                            </thead>
                                            <tbody>
                                            @foreach($reports_list as $reports_data)    
                                             
                                            <tr>
                                                    <td>
                                                    <div class="inbox-item-img">
                                                    @if(isset(\App\User::getUserInfo($reports_data->user_id)->user_image))
                                                    <img src="{{URL::to('upload/'.\App\User::getUserInfo($reports_data->user_id)->user_image)}}" class="rounded-circle" alt="" width="50">
                                                    @else
                                                    <img src="{{URL::to('upload/profile.jpg')}}" class="rounded-circle" alt="" width="50">
                                                    @endif                                         
                                                    </div>
                                                    </td>
                                                    <td>
                                                    <p class="inbox-item-author" style="color:#fff;">{{\App\User::getUserFullname($reports_data->user_id)}}</p>
                                                    </td>
                                                    <td>
                                                        <p class="inbox-item-text">{{Str::limit($reports_data->message,70)}}</p>
                                                    </td>
                                                     <td style="text-align: center">
                                                        <span class="badge badge-success">{{ date('m-d-Y h:i a',$reports_data->date) }}</span>
                                                    </td>
                                                     
                                                 </tr>
                                                 
                                            @endforeach       
                                        

                                            </tbody>
                                        </table>
                                    </div>
 
                          
                     </div>
                </div><!-- end col-->
 
                       
          </div>

          
          @else

                <div class="row">
                     
                <div class="col-xl-3 col-md-4 col-6">
                        <a href="{{URL::to('admin/category')}}">
                        <div class="card-box widget-user">
                            <div class="text-center">
                                <h2 class="text-custom" data-plugin="counterup">{{$category}}</h2>
                                <h5 style="color: #f9f9f9;">{{trans('words.categories_text')}}</h5>
                            </div>
                        </div>
                        </a>
                    </div>

                    <div class="col-xl-3 col-md-4 col-6">
                        <a href="{{URL::to('admin/sub_category')}}">
                        <div class="card-box widget-user">
                            <div class="text-center">
                                <h2 class="text-purple" data-plugin="counterup">{{$sub_category}}</h2>
                                <h5 style="color: #f9f9f9;">{{trans('words.sub_categories_text')}}</h5>
                            </div>
                        </div>
                        </a>
                    </div>

                    <div class="col-xl-3 col-md-4 col-6">
                        <a href="{{URL::to('admin/authors')}}">
                        <div class="card-box widget-user">
                            <div class="text-center">
                                <h2 class="text-success" data-plugin="counterup">{{$authors}}</h2>
                                <h5 style="color: #f9f9f9;">{{trans('words.authors_text')}}</h5>
                            </div>
                        </div>
                        </a>
                    </div>

                    <div class="col-xl-3 col-md-4 col-6">
                        <a href="{{URL::to('admin/books')}}">
                        <div class="card-box widget-user">
                            <div class="text-center">
                                <h2 class="text-warning" data-plugin="counterup">{{$books}}</h2>
                                <h5 style="color: #f9f9f9;">{{trans('words.books_text')}}</h5>
                            </div>
                        </div>
                        </a>
                    </div>
 

                    <div class="col-xl-3 col-md-4 col-6">
                        <a href="{{URL::to('admin/users')}}">
                        <div class="card-box widget-user">
                            <div class="text-center">
                                <h2 class="text-info" data-plugin="counterup">{{$users}}</h2>
                                <h5 style="color: #f9f9f9;">{{trans('words.users')}}</h5>
                            </div>
                        </div>
                        </a>
                    </div>

                    <div class="col-xl-3 col-md-4 col-6">
                        <a href="{{URL::to('admin/transactions')}}">
                        <div class="card-box widget-user">
                            <div class="text-center">
                                <h2 class="text-danger" data-plugin="counterup">{{$transactions}}</h2>
                                <h5 style="color: #f9f9f9;">{{trans('words.transactions')}}</h5>
                            </div>
                        </div>
                        </a>
                    </div>

                    <div class="col-xl-3 col-md-4 col-6">
                        <a href="{{URL::to('admin/reviews')}}">
                        <div class="card-box widget-user">
                            <div class="text-center">
                                <h2 class="text-pink" data-plugin="counterup">{{$reviews}}</h2>
                                <h5 style="color: #f9f9f9;">{{trans('words.reviews')}}</h5>
                            </div>
                        </div>
                        </a>
                    </div>
                     

                    <div class="col-xl-3 col-md-4 col-6">
                        <a href="{{URL::to('admin/reports')}}">
                        <div class="card-box widget-user">
                            <div class="text-center">
                                <h2 class="text-dark" data-plugin="counterup">{{$reports}}</h2>
                                <h5 style="color: #f9f9f9;">{{trans('words.reports')}}</h5>
                            </div>
                        </div>
                        </a>
                    </div>
                    
                    
                </div> 


          @endif 
        
        </div>

        
      </div>
      @include("admin.copyright") 
    </div>

 
 
@endsection