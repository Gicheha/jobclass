<?php
/**
 * JobClass - Geolocalized Job Board Script
 * Copyright (c) BedigitCom. All Rights Reserved
 *
 * Website: http://www.bedigit.com
 *
 * LICENSE
 * -------
 * This software is furnished under a license and may be used and copied
 * only in accordance with the terms of such license and with the inclusion
 * of the above copyright notice. If you Purchased from Codecanyon,
 * Please read the full License from here - http://codecanyon.net/licenses/standard
 */

namespace App\Http\Controllers\Search;

use App\Helpers\Search;
use App\Models\User;
use Illuminate\Pagination\LengthAwarePaginator;
use Torann\LaravelMetaTags\Facades\MetaTag;
use App\Models\Company;
use App\Models\SubAdmin1;
use App\Models\SubAdmin2;

class UserController extends BaseController
{
	public $isUserSearch = true;
	public $sUser;

    /**
     * @param $countryCode
     * @param null $userId
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index($countryCode, $userId = null)
    {
        // Check multi-countries site parameters
        if (!config('settings.seo.multi_countries_urls')) {
            $userId = $countryCode;
        }

        view()->share('isUserSearch', $this->isUserSearch);
        // Get User
		$this->sUser = User::all();
		// Redirect to User's profile If username exists
		if (!empty($this->sUser->username)) {
			$attr = ['countryCode' => $countryCode, 'username' => $this->sUser->username];
			$url = lurl(trans('routes.v-search-username', $attr), $attr);
			headerLocation($url);
		}else{

			$users = \DB::table('users');

			if(!empty(request()->get('job-title-skills'))){
				$users->where('job_title','like','%'.request()->get('job-title-skills').'%');
				$users->orWhere('skill','like','%'.request()->get('job-title-skills').'%');
			}
			if(!empty(request()->get('category'))){
				$users->where('category_id','=',request()->get('category'));
			}
			if(!empty(request()->get('sub-category'))){
				$users->where('sub_category','=',request()->get('sub-category'));
			}
			if(!empty(request()->get('city'))){
				$users->where('city','=',request()->get('city'));
			}
			if(!empty(request()->get('location'))){
				$users->where('city','=',request()->get('location'));
			}
			if(!empty(request()->get('employment_type'))){
				$users->where('post_type_id','=',request()->get('employment_type'));
			}
			
			$companies = Company::pluck('name','id');
			$states = SubAdmin1::pluck('name','id');
			$districts = SubAdmin2::pluck('name','id');

			$users = $users->paginate(1)->setPath('');
			/*$users = User::paginate(15);
			$users = $users->where('name','Nagesh');*/
			return view('search.userserp', compact('users','companies','states','districts'));
		}

		return $this->searchByUserId($this->sUser->id);
    }
	
	/**
	 * @param $countryCode
	 * @param null $username
	 * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
	 */
	public function profile($countryCode, $username = null)
	{
		// Check multi-countries site parameters
		if (!config('settings.seo.multi_countries_urls')) {
			$username = $countryCode;
		}
		
		view()->share('isUserSearch', $this->isUserSearch);
		
		// Get User
		$this->sUser = User::where('username', $username)->firstOrFail();
		
		return $this->searchByUserId($this->sUser->id, $this->sUser->username);
	}
	
	/**
	 * @param $userId
	 * @param null $username
	 * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
	 */
	private function searchByUserId($userId, $username = null)
	{
		// Search
		$search = new Search();
		$data = $search->setUser($userId)->setRequestFilters()->fetch();
		
		// Get Titles
		$bcTab = $this->getBreadcrumb();
		$htmlTitle = $this->getHtmlTitle();
		view()->share('bcTab', $bcTab);
		view()->share('htmlTitle', $htmlTitle);
		
		// Meta Tags
		$title = $this->getTitle();
		MetaTag::set('title', $title);
		MetaTag::set('description', $title);
		
		// Translation vars
		view()->share('uriPathUserId', $userId);
		view()->share('uriPathUsername', $username);
		
		return view('search.serp', $data);
	}

	function searchUsers(){

		view()->share('isIndexSearch', $this->isIndexSearch);
		
		// Pre-Search
		if (request()->filled('c')) {
			if (request()->filled('sc')) {
				$this->getCategory(request()->get('c'), request()->get('sc'));
			} else {
				$this->getCategory(request()->get('c'));
			}
		}
		if (request()->filled('l') || request()->filled('location')) {
			$city = $this->getCity(request()->get('l'), request()->get('location'));
		}
		if (request()->filled('r') && !request()->filled('l')) {
			$admin = $this->getAdmin(request()->get('r'));
		}
		
		// Pre-Search values
		$preSearch = [
			'name'  => (isset($name) && !empty($name)) ? $city : null,
			'admin' => (isset($admin) && !empty($admin)) ? $admin : null,
		];
		
		// Search
		// $search = new Search($preSearch);
		$data = $this->fetch();

		/*$user = new User();
		$data = user->get();
		dd($data);*/

		// Export Search Result
		view()->share('count', $data['count']);
		view()->share('paginator', $data['paginator']);
		
		// Get Titles
		$title = $this->getTitle();
		$this->getBreadcrumb();
		$this->getHtmlTitle();
		
		// Meta Tags
		MetaTag::set('title', $title);
		MetaTag::set('description', $title);

		return view('search.userserp');
	}


	public function fetch()
    {

    	$user = User::all();
    	// dd($user);
        $count = $user->count();

        // $sql = $this->builder() . "\n" . "LIMIT " . (int)$this->sqlCurrLimit . ", " . (int)$this->perPage;

        // Count real query ads (request()->get('type') is an array in JobClass)
        $total = 10;


        // Fetch Query !
		$paginator = $user;
		$paginator = new LengthAwarePaginator($paginator, $total, $this->perPage, $this->currentPage);
		$paginator->setPath(Request::url());
	
		// Append the Posts 'uri' attribute
		/*$paginator->getCollection()->transform(function ($post) {
			$post->title = mb_ucfirst($post->title);
			$post->uri = trans('routes.v-post', ['slug' => slugify($post->title), 'id' => $post->id]);
			
			return $post;
		});*/

        return ['paginator' => $paginator, 'count' => $count];
    }
}
