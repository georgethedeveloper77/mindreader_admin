<?php

namespace App\Http\Controllers\Admin;

use Auth;
use App\User;
use App\Category;
use App\SubCategory;
use App\Authors;
use App\Books;
use App\Reports;
use App\Transactions;
use App\PostRatings;
use App\PostViewsDownload;
 
use App\Http\Requests;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
 
class DashboardController extends MainAdminController
{
	public function __construct()
    {
		 $this->middleware('auth');
          
         parent::__construct();
          
    }
    public function index()
    { 
            if(Auth::User()->usertype!="Admin" AND Auth::User()->usertype!="Sub_Admin")
            {

                \Session::flash('flash_message', 'Access denied!');

                return redirect('dashboard');
                
             }
           
            $category = Category::count();
            $sub_category = SubCategory::count();
            $authors = Authors::count();
            $books = Books::count();
             
            $users = User::where('usertype','User')->count(); 
            $transactions = Transactions::count();
            $reviews = PostRatings::count();
            $reports = Reports::count();
            
            //Trending
            $trending_start_date = date('Y-m-d', strtotime('today - 30 days'));
            $trending_end_date = date('Y-m-d');

            $trending_now = PostViewsDownload::select("post_id","post_type")->whereBetween('date', array(strtotime($trending_start_date), strtotime($trending_end_date)))->selectRaw('SUM(post_views) as total_views')->groupBy('post_id','post_type')->orderby('total_views','DESC')->take(10)->get();
            
            //Latest Books
            $latest_books = Books::where('status',1)->orderby('id','DESC')->take(10)->get();

            $start_date = date('Y-m-d', strtotime('today - 300 days'));
            $end_date = date('Y-m-d');  

            //Top Country
            $top_country= DB::table("analytics")->select("country",DB::raw("COUNT(1) as count_row"))->where('country','!=','')->whereBetween('date', array(strtotime($start_date), strtotime($end_date)))->groupBy(DB::raw("(country)"))->orderby('count_row','DESC')->take(10)->get();

            //dd($top_country);exit;
            
            //Latest Reviews
            $latest_review = PostRatings::orderby('id','DESC')->take(10)->get();

            //Latest Reports
            $reports_list = Reports::orderby('id','DESC')->take(10)->get();

             
            $page_title = trans('words.dashboard_text')?trans('words.dashboard_text'):'Dashboard';
                
            return view('admin.pages.dashboard',compact('page_title','category','sub_category','authors','books','users','transactions','reviews','reports','trending_now','latest_books','top_country','latest_review','reports_list'));                  
        
    }
	
	 
    	
}
