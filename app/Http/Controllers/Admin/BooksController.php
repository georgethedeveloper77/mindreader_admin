<?php

namespace App\Http\Controllers\Admin;

use Auth;
use App\User;
use App\Category;
use App\SubCategory;
use App\Authors;
use App\Books;
use App\Favourite;
use App\PostRatings;
use App\Reports;
use App\PostViewsDownload;

use App\Http\Requests;
use Illuminate\Http\Request;
use Session;
use Intervention\Image\Facades\Image;
use Illuminate\Support\Str; 

class BooksController extends MainAdminController
{
	public function __construct()
    {
		 $this->middleware('auth');
          
    }

    public function list()
    { 
 
        if(Auth::User()->usertype!="Admin" AND Auth::User()->usertype!="Sub_Admin")
        {

            \Session::flash('flash_message', trans('words.access_denied'));

            return redirect('dashboard');
            
        }

        if(isset($_GET['s']))
        {
            $keyword = $_GET['s'];  
            $list = Books::where("title", "LIKE","%$keyword%")->orderBy('title')->paginate(12);

            $list->appends(\Request::only('s'))->links();
        }
        else if(isset($_GET['filter']))
        {
            
            if($_GET['filter']=="Slider")
            {
                $list = Books::where("featured", "1")->orderBy('id','DESC')->paginate(12);      
            }
            else if($_GET['filter']=="Paid")
            {
                $list = Books::where("book_access", "Paid")->orderBy('id','DESC')->paginate(12);      
            }   
            else if($_GET['filter']=="Free")
            {
                $list = Books::where("book_access", "Free")->orderBy('id','DESC')->paginate(12);      
            }
            else if($_GET['filter']=="Active")
            {
                $list = Books::where("status",1)->orderBy('id','DESC')->paginate(12);      
            }
            else if($_GET['filter']=="Inactive")
            {
                $list = Books::where("status", 0)->orderBy('id','DESC')->paginate(12);      
            } 
            else
            {
                $list = Books::orderBy('id','DESC')->paginate(12);      
            }
                 
            $list->appends(request()->input())->links();
        } 
        else if(isset($_GET['cat_id']) AND isset($_GET['author_id']))
        {
           
            $cat_id = $_GET['cat_id'];  
            $author_id = $_GET['author_id']; 
            
            $list = Books::when($cat_id, function ($q) use ($cat_id) {
                return $q->where('cat_id',$cat_id);
            })             
            ->when($author_id, function ($q) use ($author_id) {
                return $q->whereRaw("find_in_set('$author_id',author_ids)");
            })             
            ->orderBy('id','DESC')->paginate(12);
              
            $list->appends(request()->input())->links();
        }        
        else
        {
            $list = Books::orderBy('id','DESC')->paginate(12);

        }

        $cat_list = Category::orderBy('category_name')->get();
        $authors_list = Authors::orderBy('name')->get();

        $page_title=trans('words.books_text');

          
        return view('admin.pages.books.list',compact('page_title','list','cat_list','authors_list'));
    }

    public function add()    
    {     
          if(Auth::User()->usertype!="Admin" AND Auth::User()->usertype!="Sub_Admin")
            {

                \Session::flash('flash_message', trans('words.access_denied'));

                return redirect('dashboard');
                
             }  

          $page_title=trans('words.add_book');

          $cat_list = Category::orderBy('category_name')->get();
          $sub_cat_list = SubCategory::orderBy('sub_category_name')->get();
          $authors_list = Authors::orderBy('name')->get();
          
          return view('admin.pages.books.addedit',compact('page_title','cat_list','sub_cat_list','authors_list'));
        
    }

    public function edit($page_id)    
    {     
          if(Auth::User()->usertype!="Admin" AND Auth::User()->usertype!="Sub_Admin")
            {

                \Session::flash('flash_message', trans('words.access_denied'));

                return redirect('dashboard');
                
             }  

          $page_title=trans('words.edit_book');

          $info = Books::findOrFail($page_id);

          $cat_list = Category::orderBy('category_name')->get();
          $sub_cat_list = SubCategory::where('cat_id',$info->cat_id)->orderBy('sub_category_name')->get();
          $authors_list = Authors::orderBy('name')->get();
         
          return view('admin.pages.books.addedit',compact('page_title','info','cat_list','sub_cat_list','authors_list'));
        
    }

    public function addnew(Request $request)
    {  
       
       $data =  \Request::except(array('_token')) ;
       
       if(!empty($inputs['id'])){
                
            $rule=array(
            'title' => 'required',
            'category' => 'required'           
                 );
        }
        else
        {
            $rule=array(
                'title' => 'required',
                'category' => 'required',
                'book_image' => 'required'                                 
                    );
        }

        
        $validator = \Validator::make($data,$rule);
 
        if ($validator->fails())
        {
                return redirect()->back()->withErrors($validator->messages());
        } 
        $inputs = $request->all();

        if(!empty($inputs['id'])){
           
            $data_obj = Books::findOrFail($inputs['id']);

        }else{

            $data_obj = new Books;

        }         
        
        $author_ids= isset($inputs['author_ids'])?implode(',', $inputs['author_ids']):'';

        $data_obj->book_access = $inputs['book_access']; 
        $data_obj->title = addslashes($inputs['title']);
        $data_obj->description = addslashes($inputs['description']);
        $data_obj->cat_id = $inputs['category']; 
        $data_obj->sub_cat_id = $inputs['sub_category']; 
        $data_obj->author_ids = $author_ids;
        $data_obj->image = $inputs['book_image'];       
        
        $data_obj->url_type = $inputs['url_type'];

        if($inputs['url_type']=="server_url")
        {
        $data_obj->url = $inputs['book_url_server'];
        }
        else
        {
        $data_obj->url = $inputs['book_url_local'];
        }

        if(isset($inputs['download_enable']))
         {
            $data_obj->download_enable = $inputs['download_enable'];  
          }

        $data_obj->book_on_rent = $inputs['book_on_rent'];

        if($inputs['book_on_rent']==1)
        {
            $data_obj->book_rent_price = $inputs['book_rent_price'];
            $data_obj->book_rent_time = $inputs['book_rent_time'];
        }

        $data_obj->status = $inputs['status']; 
        
        $data_obj->save();
 
        if(!empty($inputs['id'])){

            \Session::flash('flash_message', trans('words.successfully_updated'));

            return \Redirect::back();
        }else{

            \Session::flash('flash_message', trans('words.added'));

            return \Redirect::back();

        }   
    }
  
}
