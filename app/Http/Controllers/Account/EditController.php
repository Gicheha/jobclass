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

namespace App\Http\Controllers\Account;

use App\Http\Controllers\Auth\Traits\VerificationTrait;
use App\Http\Requests\UserRequest;
use App\Models\Scopes\VerifiedScope;
use App\Models\UserType;
use Creativeorange\Gravatar\Facades\Gravatar;
use App\Models\Post;
use App\Models\PostType;
use App\Models\SavedPost;
use App\Models\Gender;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Torann\LaravelMetaTags\Facades\MetaTag;
use App\Helpers\Localization\Helpers\Country as CountryLocalizationHelper;
use App\Helpers\Localization\Country as CountryLocalization;
use App\Models\User;
use App\Models\City;
use App\Models\Company;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use File;
use App\Models\SubAdmin1;
use App\Models\SubAdmin2;

class EditController extends AccountBaseController
{
	use VerificationTrait;
	
	/**
	 * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
	 */
	public function index()
	{
		$data = [];
		
		$data['countries'] = CountryLocalizationHelper::transAll(CountryLocalization::getCountries());
		$data['genders'] = Gender::trans()->get();
		$data['userTypes'] = UserType::all();
		$data['postTypes'] = PostType::trans()->get();
		$data['gravatar'] = (!empty(auth()->user()->email)) ? Gravatar::fallback(url('images/user.jpg'))->get(auth()->user()->email) : null;
		
		// Mini Stats
		$data['countPostsVisits'] = DB::table('posts')
			->select('user_id', DB::raw('SUM(visits) as total_visits'))
			->where('country_code', config('country.code'))
			->where('user_id', auth()->user()->id)
			->groupBy('user_id')
			->first();
		$data['countPosts'] = Post::currentCountry()
			->where('user_id', auth()->user()->id)
			->count();
		$data['countFavoritePosts'] = SavedPost::whereHas('post', function ($query) {
			$query->currentCountry();
		})->where('user_id', auth()->user()->id)
			->count();

		$data['cities'] = City::pluck('name','id');
		$data['subcategory'] = Company::where('user_id', auth()->user()->id)->pluck('name','id');
		$data['categories'] = Category::pluck('name','id');
		
        // Get Statess Types
        $data['states'] = SubAdmin1::pluck('name','id');

        // Get districts Types
        $data['districts'] = SubAdmin2::pluck('name','id');
		
		// Meta Tags
		MetaTag::set('title', t('My account'));
		MetaTag::set('description', t('My account on :app_name', ['app_name' => config('settings.app.app_name')]));
		
		return view('account.edit', $data);
	}
	
	/**
	 * @param UserRequest $request
	 * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
	 */
	public function updateDetails(UserRequest $request)
	{
		// Check if these fields has changed
		$emailChanged = $request->filled('email') && $request->input('email') != auth()->user()->email;
		$phoneChanged = $request->filled('phone') && $request->input('phone') != auth()->user()->phone;
		$usernameChanged = $request->filled('username') && $request->input('username') != auth()->user()->username;
		
		// Conditions to Verify User's Email or Phone
		$emailVerificationRequired = config('settings.mail.email_verification') == 1 && $emailChanged;
		$phoneVerificationRequired = config('settings.sms.phone_verification') == 1 && $phoneChanged;
		
		// Get User
		$user = User::withoutGlobalScopes([VerifiedScope::class])->find(auth()->user()->id);
		
		// Update User
		$input = $request->only($user->getFillable());
		foreach ($input as $key => $value) {
			if (in_array($key, ['email', 'phone', 'username']) && empty($value)) {
				continue;
			}
			$user->{$key} = $value;
		}

		$user->phone_hidden = $request->input('phone_hidden');
		$user->start_end_date = implode(',' ,$request->input('start_end_date'));
		$user->work_location = !is_null($request->input('work_location')) ? implode(',' ,$request->input('work_location')) : '' ;
		$user->education = implode(',' ,$request->input('education'));
		$user->qualification = implode(',' ,$request->input('qualification'));
		$user->lang_prof = implode(',' ,$request->input('lang_prof'));
		$user->lang_star = implode(',' ,$request->input('lang_star'));
		$user->skill = implode(',' ,$request->input('skills'));
		$user->skill_star = implode(',' ,$request->input('skill_star'));
		$user->description = implode(',' ,$request->input('description'));
		$user->job_year = implode(',' ,$request->input('job_year'));
		$user->job_month = implode(',' ,$request->input('job_month'));
		$user->recent_job = implode(',' ,$request->input('recent_job'));
		$user->recent_employer = implode(',' ,$request->input('recent_employer'));
		$user->job_start_end_date = implode(',' ,$request->input('job_start_end_date'));
		
		// Email verification key generation
		if ($emailVerificationRequired) {
			$user->email_token = md5(microtime() . mt_rand());
			$user->verified_email = 0;
		}
		
		// Phone verification key generation
		if ($phoneVerificationRequired) {
			$user->phone_token = mt_rand(100000, 999999);
			$user->verified_phone = 0;
		}
		
		// Don't logout the User (See User model)
		if ($emailVerificationRequired || $phoneVerificationRequired) {
			session(['emailOrPhoneChanged' => true]);
		}
		
		if($request->hasFile('avatar')){

			$cover = $request->file('avatar');
		    $extension = $cover->getClientOriginalExtension();
		    Storage::disk('public')->put('/pictures/'.$cover->getFilename().'.'.$extension,  File::get($cover));
			// $path = $request->file('avatar')->store('pictures','public');
			// $path = Storage::putFile('avatar', new File(storage_path().'/'.'pictures'), 'public');
			// $path = Storage::disk('public')->getAdapter()->getPathPrefix();
			// dd($path);
			$user->avatar = 'uploads/pictures/'.$cover->getFilename().'.'.$extension;
		}
		
		// Save
		$user->save();
		
		// Message Notification & Redirection
		flash(t("Your details account has updated successfully."))->success();
		$nextUrl = config('app.locale') . '/account';
		
		// Send Email Verification message
		if ($emailVerificationRequired) {
			$this->sendVerificationEmail($user);
			$this->showReSendVerificationEmailLink($user, 'user');
		}
		
		// Send Phone Verification message
		if ($phoneVerificationRequired) {
			// Save the Next URL before verification
			session(['itemNextUrl' => $nextUrl]);
			
			$this->sendVerificationSms($user);
			$this->showReSendVerificationSmsLink($user, 'user');
			
			// Go to Phone Number verification
			$nextUrl = config('app.locale') . '/verify/user/phone/';
		}
		
		// Redirection
		return redirect($nextUrl);
	}
	
	/**
	 * @param Request $request
	 * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
	 */
	public function updateSettings(Request $request)
	{
		// Validation
		if ($request->filled('password')) {
			$rules = ['password' => 'between:6,60|dumbpwd|confirmed'];
			$this->validate($request, $rules);
		}
		
		// Get User
		$user = User::find(auth()->user()->id);
		
		// Update
		$user->disable_comments = (int)$request->input('disable_comments');
		if ($request->filled('password')) {
			$user->password = Hash::make($request->input('password'));
		}
		
		// Save
		$user->save();
		
		flash(t("Your settings account has updated successfully."))->success();
		
		return redirect(config('app.locale') . '/account');
	}
	
	/**
	 * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
	 */
	public function updatePreferences()
	{
		$data = [];
		
		return view('account.edit', $data);
	}
}
