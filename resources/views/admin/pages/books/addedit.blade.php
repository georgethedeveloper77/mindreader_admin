@extends("admin.admin_app")

@section("content")

<style type="text/css">
  .iframe-container {
  overflow: hidden;
  padding-top: 56.25% !important;
  position: relative;
}
 
.iframe-container iframe {
   border: 0;
   height: 100%;
   left: 0;
   position: absolute;
   top: 0;
   width: 100%;
}
</style>
 
  <div class="content-page">
      <div class="content">
        <div class="container-fluid">
          <div class="row">
            <div class="col-lg-12">
              <div class="card-box">
                 <div class="row">
                 <div class="col-sm-6">
                      <a href="{{ URL::to('admin/books') }}"><h4 class="header-title m-t-0 m-b-30 text-primary pull-left" style="font-size: 20px;"><i class="fa fa-arrow-left"></i> {{trans('words.back')}}</h4></a>
                 </div>                  
               </div> 
                 
                 {!! Form::open(array('url' => array('admin/books/add_edit'),'class'=>'form-horizontal','name'=>'settings_form','id'=>'settings_form','role'=>'form','enctype' => 'multipart/form-data')) !!}  
                  
                 <input type="hidden" name="id" value="{{ isset($info->id) ? $info->id : null }}">
                  
                 <div class="form-group row">
                    <label class="col-sm-3 col-form-label">{{trans('words.book_access')}}</label>
                      <div class="col-sm-8">
                            <select class="form-control" name="book_access">                               
                                <option value="Paid" @if(isset($info->book_access) AND $info->book_access=='Paid') selected @endif>{{trans('words.paid')}}</option>
                                <option value="Free" @if(isset($info->book_access) AND $info->book_access=='Free') selected @endif>{{trans('words.free')}}</option>                            
                            </select>
                      </div>

                  </div>

                  <div class="form-group row">
                    <label class="col-sm-3 col-form-label">{{trans('words.book_title')}}*</label>
                    <div class="col-sm-8">
                      <input type="text" name="title" value="{{ isset($info->title) ? stripslashes($info->title) : null }}" class="form-control">
                    </div>
                  </div>

                  <div class="form-group row">
                    <label class="col-sm-3 col-form-label">{{trans('words.book_desc')}}</label>
                    <div class="col-sm-8"> 
                    <textarea name="description" class="form-control elm1_editor" placeholder="">{{ isset($info->description) ? stripslashes($info->description) : null }}</textarea>                      
                    </div>
                  </div>

                  <div class="form-group row">
                    <label class="col-sm-3 col-form-label">{{trans('words.category')}}*</label>
                      <div class="col-sm-8">
                            <select class="form-control select2" name="category" id="category_id">   
                               <option value="">{{trans('words.select_category')}}</option>                            
                              @foreach($cat_list as $cat_data)  
                                <option value="{{$cat_data->id}}" @if(isset($info->id) AND $cat_data->id==$info->cat_id) selected @endif>{{$cat_data->category_name}}</option>
                              @endforeach   
                            </select>
                      </div>
                  </div>

                  <div class="form-group row">
                    <label class="col-sm-3 col-form-label">{{trans('words.sub_category')}}*</label>
                      <div class="col-sm-8">
                            <select class="form-control select2" name="sub_category" id="sub_category_id">   
                               <option value="">{{trans('words.select_sub_category')}}</option>   
                               @if(isset($info->id))                           
                                @foreach($sub_cat_list as $sub_cat_data)  
                                  <option value="{{$sub_cat_data->id}}" @if(isset($info->id) AND $sub_cat_data->id==$info->sub_cat_id) selected @endif>{{$sub_cat_data->sub_category_name}}</option>
                                @endforeach   
                              @endif  
                            </select>
                      </div>
                  </div>

                  <div class="form-group row">
                    <label class="col-sm-3 col-form-label">{{trans('words.authors_text')}}</label>
                      <div class="col-sm-8">
                            <select class="select2 select2-multiple" multiple name="author_ids[]" id="author_ids" data-placeholder="{{trans('words.select_author')}}">   
                                                   
                               @foreach($authors_list as $authors_data)
                                  <option value="{{$authors_data->id}}" @if(isset($info->id) && in_array($authors_data->id, explode(",",$info->author_ids))) selected @endif>{{stripslashes($authors_data->name)}}</option>
                                @endforeach
                            </select>
                      </div>
                  </div>
 
                  <div class="form-group row">
                    <label class="col-sm-3 col-form-label">{{trans('words.book_image')}}* </label>
                    <div class="col-sm-8">
                      <div class="input-group">
                        <input type="text" name="book_image" id="book_image" value="{{ isset($info->image) ? stripslashes($info->image) : null }}" class="form-control" readonly>
                        <div class="input-group-append">                           
                          <button type="button" class="btn btn-dark waves-effect waves-light popup_selector" data-input="book_image" data-preview="holder_logo" data-inputid="book_image">Select</button>                        
                        </div>
                      </div>
                      <small class="form-text text-muted">({{trans('words.recommended_resolution')}} : 240x365, 480x730, 720x1095 or Portrait Image)</small>
                       


                      <div id="image_holder" style="margin-top:5px;max-height:100px;"></div>                     
                    </div>
                  </div>
               
                    

                  @if(isset($info->image)) 
                  <div class="form-group row">
                    <label class="col-sm-3 col-form-label">&nbsp;</label>
                    <div class="col-sm-8">                                                                         
                      <img src="{{URL::to('/'.$info->image)}}" alt="image" class="img-thumbnail" width="140">                                               
                    </div>
                  </div>
                  @endif  

                  <div class="form-group row">
                    <label class="col-sm-3 col-form-label">{{trans('words.upload_type')}}</label>
                      <div class="col-sm-8">
                            <select class="form-control" name="url_type" id="upload_type">                               
                                <option value="local" @if(isset($info->url_type) AND $info->url_type=="local") selected @endif>Browse from Device</option>
                                <option value="server_url" @if(isset($info->url_type) AND $info->url_type=="server_url") selected @endif>Server URL</option>     
                            </select>
                      </div>
                  </div>

                  <div class="form-group row" id="local_upload_id" @if(isset($info->url_type) AND $info->url_type!="local") style="display:none;" @endif>
                    <label class="col-sm-3 col-form-label">{{trans('words.book_upload')}}

                    <small class="form-text text-muted">(Supported File: .pdf and .epub)</small>

                    </label>
                    <div class="col-sm-8">
                      <div class="input-group">
                        <input type="text" name="book_url_local" id="book_url_local" value="{{ isset($info->url) ? $info->url : null }}" class="form-control" readonly>
                        <div class="input-group-append">                           
                          <button type="button" class="btn btn-dark waves-effect waves-light popup_selector" data-input="book_url_local" data-inputid="book_url_local">Select</button>                        
                        </div>
                      </div>                       
                     </div>
                  </div>

                  <div class="form-group row" id="server_upload_id" @if(isset($info->url_type) AND $info->url_type!="server_url") style="display:none;" @endif @if(!isset($info->id)) style="display:none;" @endif>
                    <label class="col-sm-3 col-form-label">{{trans('words.book_url')}}
                    <small class="form-text text-muted">(Supported File: .pdf and .epub)</small>
                    </label>
                    <div class="col-sm-8">
                      <div class="input-group">
                        <input type="text" name="book_url_server" id="book_url_server" value="{{ isset($info->url) ? $info->url : null }}" class="form-control">
                         
                      </div>                       
                     </div>
                  </div>
                  <div class="form-group row">
                    <label class="col-sm-3 col-form-label">{{trans('words.download')}}</label>
                    <div class="col-sm-8">
                      <div class="radio radio-success form-check-inline pl-2"  style="margin-top: 8px;">
                          <input type="radio" id="inlineRadio3" value="1" name="download_enable" @if(isset($info->download_enable) && $info->download_enable==1) {{ 'checked' }} @endif>
                          <label for="inlineRadio3"> {{trans('words.active')}} </label>
                      </div>
                      <div class="radio form-check-inline" style="margin-top: 8px;">
                          <input type="radio" id="inlineRadio4" value="0" name="download_enable" @if(isset($info->download_enable) && $info->download_enable==0) {{ 'checked' }} @endif {{ isset($info->id) ? '' : 'checked' }}>
                          <label for="inlineRadio4"> {{trans('words.inactive')}} </label>
                      </div>
                    </div>
                  </div>

                  <hr/>
                  <h4 class="m-t-0 m-b-30 header-title" style="font-size: 20px;">{{trans('words.book_on_rent')}}</h4>
                  <div class="form-group row">
                    <label class="col-sm-3 col-form-label">{{trans('words.book_on_rent')}}</label>
                      <div class="col-sm-8">
                            <select class="form-control" name="book_on_rent" id="book_on_rent">    

                                <option value="0" @if(isset($info->book_on_rent) AND $info->book_on_rent==0) selected @endif>{{trans('words.rent_no')}}</option>
                                <option value="1" @if(isset($info->book_on_rent) AND $info->book_on_rent==1) selected @endif>{{trans('words.rent_yes')}}</option>
                                                            
                            </select>
                      </div>
                  </div>

                  <div id="on_rent_sec" @if(isset($info->book_on_rent) AND $info->book_on_rent!=1) style="display:none;" @endif @if(!isset($info->id)) style="display:none;" @endif>
                      <div class="form-group row">
                        <label class="col-sm-3 col-form-label">{{trans('words.rent_price')}}</label>
                        <div class="col-sm-8">
                          <input type="number" name="book_rent_price" id="book_rent_price" value="{{ isset($info->book_rent_price) ? $info->book_rent_price : old('book_rent_price') }}" class="form-control" placeholder="2.00" min="1" step="0.01">
                        </div>
                      </div>
                      <div class="form-group row">
                        <label class="col-sm-3 col-form-label">{{trans('words.rent_time')}}<small id="emailHelp" class="form-text text-muted">(Set day(s) value only)</small></label>
                        <div class="col-sm-8">
                          <input type="number" name="book_rent_time" id="book_rent_time" value="{{ isset($info->book_rent_time) ? $info->book_rent_time : old('book_rent_time') }}" class="form-control" placeholder="1" min="0">
                        </div>
                      </div>
                  </div>
 
                  <hr/>  
                  <div class="form-group row">
                    <label class="col-sm-3 col-form-label">{{trans('words.status')}}</label>
                      <div class="col-sm-8">
                            <select class="form-control" name="status">                               
                                <option value="1" @if(isset($info->status) AND $info->status==1) selected @endif>{{trans('words.active')}}</option>
                                <option value="0" @if(isset($info->status) AND $info->status==0) selected @endif>{{trans('words.inactive')}}</option>                            
                            </select>
                      </div>
                  </div>
                  <div class="form-group">
                    <div class="offset-sm-3 col-sm-9 pl-1">
                      <button type="submit" class="btn btn-primary waves-effect waves-light"> {{trans('words.save')}}</button>                      
                    </div>
                  </div>
                {!! Form::close() !!} 
              </div>
            </div>            
          </div>              
        </div>
      </div>

      @include("admin.copyright") 
    
    </div>  

  <script type="text/javascript">
     
     
// function to update the file selected by elfinder
function processSelectedFile(filePath, requestingField) {

//alert(requestingField);

var elfinderUrl = "{{ URL::to('/') }}/";

if(requestingField=="book_image")
{
  var target_preview = $('#image_holder');
  target_preview.html('');
  target_preview.append(
          $('<img>').css('height', '5rem').attr('src', elfinderUrl + filePath.replace(/\\/g,"/"))
        );
  target_preview.trigger('change');
}


//$('#' + requestingField).val(filePath.split('\\').pop()).trigger('change'); //For only filename
$('#' + requestingField).val(filePath.replace(/\\/g,"/")).trigger('change');

}

 
 </script>

 <script type="text/javascript">
    
    @if(Session::has('flash_message'))     
 
      const Toast = Swal.mixin({
        toast: true,
        position: 'top-end',
        showConfirmButton: false,
        timer: 3000,
        timerProgressBar: false,
        /*didOpen: (toast) => {
          toast.addEventListener('mouseenter', Swal.stopTimer)
          toast.addEventListener('mouseleave', Swal.resumeTimer)
        }*/
      })

      Toast.fire({
        icon: 'success',
        title: '{{ Session::get('flash_message') }}'
      })     
     
  @endif

  @if (count($errors) > 0)
                  
          Swal.fire({
            icon: 'error',
            title: 'Oops...',
            html: '<p>@foreach ($errors->all() as $error) {{$error}}<br/> @endforeach</p>',
            showConfirmButton: true,
            confirmButtonColor: '#10c469',
            background:"#1a2234",
            color:"#fff"
           }) 
  @endif

  </script>

<script src="{{ URL::asset('admin_assets/js/jquery.min.js') }}"></script>
<script type="text/javascript">
  $(document).ready(function(e) {
      
     $("#category_id").change(function(){ 
         var cat_id=$("#category_id").val();
          $.ajax({
          type: "GET",
          url: "{{ URL::to('admin/ajax_get_sub_cat') }}/"+cat_id,
          //data: "cat=" + cat,
          success: function(result){

              $("#sub_category_id option").remove();
                
              $("#sub_category_id").html(result);

            }
          });
      
      });

      $("#upload_type").change(function(){         
        var type=$("#upload_type").val();

        if(type=="local")
        {   
            $("#local_upload_id").show();
            $("#server_upload_id").hide();

        }         
        else
        {   
            $("#local_upload_id").hide();
            $("#server_upload_id").show();
        }

      }); 
      
      $("#book_on_rent").change(function(){         
        var on_rent=$("#book_on_rent").val();

        if(on_rent==1)
        {   
            $("#on_rent_sec").show();

        }         
        else
        {   
            $("#on_rent_sec").hide();
        }

      }); 

  });
</script>

 
  
@endsection