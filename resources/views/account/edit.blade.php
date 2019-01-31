{{--
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
--}}
@extends('layouts.master')
<style type="text/css">
body {
  font-family:"Open Sans", Helvetica, Arial, sans-serif;
  color:#555;
  max-width:680px;
  margin:0 auto;
  padding:0 20px;
}

* {
  -webkit-box-sizing:border-box;
  -moz-box-sizing:border-box;
  box-sizing:border-box;
}

*:before, *:after {
-webkit-box-sizing: border-box;
-moz-box-sizing: border-box;
box-sizing: border-box;
}

.clearfix {
  clear:both;
}

.text-center {text-align:center;}

a {
  color: tomato;
  text-decoration: none;
}

a:hover {
  color: #2196f3;
}

pre {
display: block;
padding: 9.5px;
margin: 0 0 10px;
font-size: 13px;
line-height: 1.42857143;
color: #333;
word-break: break-all;
word-wrap: break-word;
background-color: #F5F5F5;
border: 1px solid #CCC;
border-radius: 4px;
}

.header {
  padding:20px 0;
  position:relative;
  margin-bottom:10px;
  
}

.header:after {
  content:"";
  display:block;
  height:1px;
  background:#eee;
  position:absolute; 
  left:30%; right:30%;
}

.header h2 {
  font-size:3em;
  font-weight:300;
  margin-bottom:0.2em;
}

.header p {
  font-size:14px;
}



#a-footer {
  margin: 20px 0;
}

.new-react-version {
  padding: 20px 20px;
  border: 1px solid #eee;
  border-radius: 20px;
  box-shadow: 0 2px 12px 0 rgba(0,0,0,0.1);
  
  text-align: center;
  font-size: 14px;
  line-height: 1.7;
}

.new-react-version .react-svg-logo {
  text-align: center;
  max-width: 60px;
  margin: 20px auto;
  margin-top: 0;
}





.success-box {
  margin:50px 0;
  padding:10px 10px;
  border:1px solid #eee;
  background:#f9f9f9;
}

.success-box img {
  margin-right:10px;
  display:inline-block;
  vertical-align:top;
}

.success-box > div {
  vertical-align:top;
  display:inline-block;
  color:#888;
}



/* Rating Star Widgets Style */
.rating-stars ul {
  list-style-type:none;
  padding:0;
  
  -moz-user-select:none;
  -webkit-user-select:none;
}
.rating-stars ul > li.star {
  display:inline-block;
  
}

/* Idle State of the stars */
.rating-stars ul > li.star > i.fa {
  font-size:2em; /* Change the size of the stars */
  color:#ccc; /* Color on idle state */
}

/* Hover state of the stars */
.rating-stars ul > li.star.hover > i.fa {
  color:#FFCC36;
}

/* Selected state of the stars */
.rating-stars ul > li.star.selected > i.fa {
  color:#FF912C;
}

</style>
@section('content')
	@include('common.spacer')
	<div class="main-container">
		<div class="container">
			<div class="row">
				<div class="col-sm-3 page-sidebar">
					@include('account.inc.sidebar')
				</div>
				<!--/.page-sidebar-->

				<div class="col-sm-9 page-content">

					@include('flash::message')

					@if (isset($errors) and $errors->any())
						<div class="alert alert-danger">
							<button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
							<h5><strong>{{ t('Oops ! An error has occurred. Please correct the red fields in the form') }}</strong></h5>
							<ul class="list list-check">
								@foreach ($errors->all() as $error)
									<li>{{ $error }}</li>
								@endforeach
							</ul>
						</div>
					@endif

					<div class="inner-box">
						<div class="row">
							<div class="col-md-5 col-xs-4 col-xxs-12">
								<h3 class="no-padding text-center-480 useradmin">
									<a href="">
										@if (!empty($user->avatar))
											<img class="userImg" src="{{ url($user->avatar) }}" alt="user">&nbsp;
										@else
											<img class="userImg" src="{{ url('images/user.jpg') }}" alt="user">
										@endif
										{{ $user->name }}
									</a>
								</h3>
							</div>
							<div class="col-md-7 col-xs-8 col-xxs-12">
								<div class="header-data text-center-xs">
									@if (isset($user) and in_array($user->user_type_id, [1, 2]))
									<!-- Traffic data -->
									<div class="hdata">
										<div class="mcol-left">
											<!-- Icon with red background -->
											<i class="fa fa-eye ln-shadow"></i>
										</div>
										<div class="mcol-right">
											<!-- Number of visitors -->
											<p>
												<a href="{{ lurl('account/my-posts') }}">
													<?php $totalPostsVisits = (isset($countPostsVisits) and $countPostsVisits->total_visits) ? $countPostsVisits->total_visits : 0 ?>
                                                    {{ \App\Helpers\Number::short($totalPostsVisits) }}
												    <em>{{ trans_choice('global.count_visits', getPlural($totalPostsVisits)) }}</em>
                                                </a>
											</p>
										</div>
										<div class="clearfix"></div>
									</div>
								
									<!-- Ads data -->
									<div class="hdata">
										<div class="mcol-left">
											<!-- Icon with green background -->
											<i class="icon-th-thumb ln-shadow"></i>
										</div>
										<div class="mcol-right">
											<!-- Number of ads -->
											<p>
												<a href="{{ lurl('account/my-posts') }}">
                                                    {{ \App\Helpers\Number::short($countPosts) }}
												    <em>{{ trans_choice('global.count_posts', getPlural($countPosts)) }}</em>
                                                </a>
											</p>
										</div>
										<div class="clearfix"></div>
									</div>
									@endif
                                    
                                    @if (isset($user) and in_array($user->user_type_id, [1, 3]))
									<!-- Favorites data -->
									<div class="hdata">
										<div class="mcol-left">
											<!-- Icon with blue background -->
											<i class="fa fa-user ln-shadow"></i>
										</div>
										<div class="mcol-right">
											<!-- Number of favorites -->
											<p>
												<a href="{{ lurl('account/favourite') }}">
                                                    {{ \App\Helpers\Number::short($countFavoritePosts) }}
												    <em>{{ trans_choice('global.count_favorites', getPlural($countFavoritePosts)) }} </em>
                                                </a>
											</p>
										</div>
										<div class="clearfix"></div>
									</div>
                                    @endif
								</div>
							</div>
						</div>
					</div>

					<div class="inner-box">
						<div class="welcome-msg">
							<h3 class="page-sub-header2 clearfix no-padding">{{ t('Hello') }} {{ $user->name }} ! </h3>
							<span class="page-sub-header-sub small">
                                {{ t('You last logged in at') }}: {{ $user->last_login_at->formatLocalized(config('settings.app.default_datetime_format')) }}
                            </span>
						</div>
						<div class="panel-group" id="accordion">
							<!-- USER -->
							<div class="panel panel-default">
								<div class="panel-heading">
									<h4 class="panel-title"><a href="#userPanel" data-toggle="collapse" data-parent="#accordion"> {{ t('My details') }} </a></h4>
								</div>
								<div class="panel-collapse collapse {{ (old('panel')=='' or old('panel')=='userPanel') ? 'in' : '' }}" id="userPanel">
									<div class="panel-body">
										<form name="details" class="form-horizontal" role="form" method="POST" action="{{ url()->current() }}" enctype="multipart/form-data">
											{!! csrf_field() !!}
											<input name="_method" type="hidden" value="PUT">
											<input name="panel" type="hidden" value="userPanel">
                                            
                                            @if (empty($user->user_type_id) or $user->user_type_id == 0)
                                                
                                                <!-- user_type_id -->
                                                <div class="form-group required <?php echo (isset($errors) and $errors->has('user_type_id')) ? 'has-error' : ''; ?>">
                                                    <label class="col-sm-3 control-label">{{ t('You are a') }} <sup>*</sup></label>
                                                    <div class="col-sm-9">
                                                        <select name="user_type_id" id="userTypeId" class="form-control selecter">
                                                            <option value="0"
																	@if (old('user_type_id')=='' or old('user_type_id')==0)
																		selected="selected"
																	@endif
															>
                                                                {{ t('Select') }}
                                                            </option>
                                                            @foreach ($userTypes as $type)
                                                                <option value="{{ $type->id }}"
																		@if (old('user_type_id', $user->user_type_id)==$type->id)
																			selected="selected"
																		@endif
																>
                                                                    {{ t($type->name) }}
                                                                </option>
                                                            @endforeach
                                                        </select>
                                                    </div>
                                                </div>
                                                    
                                            @else

                                                <!-- gender_id -->
                                                <!-- <div class="form-group required <?php echo (isset($errors) and $errors->has('gender_id')) ? 'has-error' : ''; ?>">
                                                    <label class="col-md-3 control-label">{{ t('Gender') }} <sup>*</sup></label>
                                                    <div class="col-md-9">
                                                        @if ($genders->count() > 0)
                                                            @foreach ($genders as $gender)
                                                                <label class="radio-inline" for="gender_id">
                                                                    <input name="gender_id" id="gender_id-{{ $gender->tid }}" value="{{ $gender->tid }}"
                                                                           type="radio" {{ (old('gender_id', $user->gender_id)==$gender->tid) ? 'checked="checked"' : '' }}>
                                                                    {{ $gender->name }}
                                                                </label>
                                                            @endforeach
                                                        @endif
                                                    </div>
                                                </div> -->
    
                                                <!-- name -->
                                                <div class="form-group required <?php echo (isset($errors) and $errors->has('name')) ? 'has-error' : ''; ?>">
                                                    <label class="col-sm-2">{{ t('Name') }} <sup>*</sup></label>
                                                    <div class="col-sm-10">
                                                        <input name="name" type="text" class="form-control" placeholder="" value="{{ old('name', $user->name) }}">
                                                    </div>
                                                </div>
	
												<!-- username -->
												<div class="form-group required <?php echo (isset($errors) and $errors->has('username')) ? 'has-error' : ''; ?>">
													<label class="col-sm-2" for="email">{{ t('Username') }} <sup>*</sup></label>
													<div class="col-sm-10">
														<div class="input-group">
															<span class="input-group-addon"><i class="icon-user"></i></span>
															<input id="username" name="username" type="text" class="form-control" placeholder="{{ t('Username') }}"
																   value="{{ old('username', $user->username) }}">
														</div>
													</div>
												</div>

												<!-- Avatar -->
												<div class="form-group">
	                                            	<label class="col-sm-2">{{ 'Upload Photo' }} </label>
	                                            	<div class="col-sm-10">
	                                            		{{ Form::file('avatar',array('class'=>'form-control')) }}
	                                            	</div>
	                                            </div>
    
                                                <!-- email -->
                                                <div class="form-group required <?php echo (isset($errors) and $errors->has('email')) ? 'has-error' : ''; ?>">
                                                    <label class="col-sm-2">{{ t('Email') }} <sup>*</sup></label>
                                                    <div class="col-sm-10">
														<div class="input-group">
															<span class="input-group-addon"><i class="icon-mail"></i></span>
															<input id="email" name="email" type="email" class="form-control" placeholder="{{ t('Email') }}" value="{{ old('email', $user->email) }}">
														</div>
                                                    </div>
                                                </div>
    
                                                <!-- country_code -->
                                                <?php
                                                /*
                                                <div class="form-group required <?php echo (isset($errors) and $errors->has('country_code')) ? 'has-error' : ''; ?>">
                                                    <label class="col-md-3 control-label" for="country_code">{{ t('Your Country') }} <sup>*</sup></label>
                                                    <div class="col-md-9">
                                                        <select name="country_code" class="form-control">
                                                            <option value="0" {{ (!old('country_code') or old('country_code')==0) ? 'selected="selected"' : '' }}>
                                                                {{ t('Select a country') }}
                                                            </option>
                                                            @foreach ($countries as $item)
                                                                <option value="{{ $item->get('code') }}" {{ (old('country_code', $user->country_code)==$item->get('code')) ? 'selected="selected"' : '' }}>
                                                                    {{ $item->get('name') }}
                                                                </option>
                                                            @endforeach
                                                        </select>
                                                    </div>
                                                </div>
                                                */
                                                ?>
                                                <input name="country_code" type="hidden" value="{{ $user->country_code }}">
												
                                                <!-- phone -->
                                                <div class="form-group required <?php echo (isset($errors) and $errors->has('phone')) ? 'has-error' : ''; ?>">
                                                    <label for="phone" class="col-sm-2">{{ t('Phone') }} <sup>*</sup></label>
                                                    <div class="col-sm-8">
                                                        <div class="input-group">
															<span id="phoneCountry" class="input-group-addon">{!! getPhoneIcon(old('country_code', $user->country_code)) !!}</span>
															
                                                            <input id="phone" name="phone" type="text" class="form-control"
																   placeholder="" value="{{ phoneFormat(old('phone', $user->phone), old('country_code', $user->country_code)) }}">
	
															<label class="input-group-addon">
																<input name="phone_hidden" id="phoneHidden" type="checkbox"
																	   value="1" {{ (old('phone_hidden', $user->phone_hidden)=='1') ? 'checked="checked"' : '' }}>
																{{ t('Hide') }}
															</label>
                                                        </div>
                                                    </div>
                                                </div>
                                                
                                            @endif


                                            <div class="form-group required <?php echo (isset($errors) and $errors->has('state')) ? 'has-error' : ''; ?>">
                                                    <div class="col-sm-4">
                                                    	<lable class="control-label">{{ t('State Name') }}</lable>
                                                    	{{ Form::select('state', array(0=>'Select')+$states->toArray(),$user->state,array('class'=>'form-control sselecter')) }}
                                                    </div>	
                                                    <div class="col-sm-4">
                                                    	<lable class="control-label">City</lable>
                                                    	{{ Form::select('city', arraY(0=>'Select city')+$cities->toArray(), $user->city,array('class'=>'form-control sselecter')) }}
                                                    </div>
                                                    <div class="col-sm-4">
                                                    	<lable class="control-label">District</lable>
                                                    	{{ Form::select('district', array(0=>'Select')+$districts->toArray(),$user->district,array('class'=>'form-control sselecter')) }}
                                                    </div>
                                            </div>


                                            <div class="form-group">
												<div class="col-sm-4">
													<label class="control-label"> {{ 'Desire Job Title' }} </label>
													{{ Form::text('job_title',$user->job_title,array('id'=>'job_title','class'=>'form-control')) }}
												</div><div class="col-sm-4">
													<label class="control-label"> {{ 'Current Career level' }} </label>
													{{ Form::text('career_level',$user->career_level,array('id'=>'career_level','class'=>'form-control')) }}
												</div><div class="col-sm-4">
													<label class="control-label"> {{ 'Prefer Location of Work' }} </label>
													
													{{ Form::select('work_location[]', arraY(0=>'Select Location')+$cities->toArray(), explode(',',$user->work_location),array('class'=>'form-control selecter','multiple'=>true)) }}
												</div>
											</div>

											<div class="form-group">
												<div class="col-sm-4">
													<label class="control-label"> {{ 'Category' }} </label>
													{{ Form::select('category_id', array(0=>'Select Category')+$categories->toArray(),$user->category_id,array('class'=>'form-control selecter')) }}
												</div>
												<div class="col-sm-4">
													<label class="control-label"> {{ 'Sub Category' }} </label>
													{{ Form::select('sub_category', array(0=>'Select Sub Category')+$subcategory->toArray(), $user->sub_category,array('class'=>'form-control selecter')) }}
												</div>
												<div class="col-sm-4">
													<label class="control-label"> {{ 'Willing to Travel' }} </label>
													{{ Form::select('willing_travel', array(''=>'Select', 'y'=>'Yes','n'=>'No'),$user->willing_travel,array('class'=>'form-control selecter')) }}
												</div>
											</div>

											<div class="form-group">
												<label class="control-label col-sm-4"> {{ 'Experience' }} </label>
												<div class="col-sm-4">
													<label class="control-label"> {{ 'Years' }} </label>
													{{ Form::select('years', range(0,10),$user->years,array('class'=>'form-control selecter')) }}
												</div>
												<div class="col-sm-4">
													<label class="control-label"> {{ 'Month' }} </label>
													{{ Form::select('month', range(0,10) ,$user->month,array('class'=>'form-control selecter')) }}
												</div>
											</div>

											<?php  
												$eduArr = explode(",", $user->education);
												$qualArr = explode(",", $user->qualification);
												$dateArr = explode(",", $user->start_end_date);
											?>
											
											@if(!empty($eduArr))
												<?php $i = 0; ?>
												@foreach($eduArr as $value)
													@if($i == 0)
														<div class="education-class">
													@endif
													<div class="form-group educationcount">
														<div class="col-sm-4">
															<label class="control-label hidelabel {{ ($i == 0) ? '':'hide' }}"> {{ 'Education' }} </label>
															{{ Form::text('education[]',$eduArr[$i],array('id'=>'education_'.$i,'class'=>'form-control education')) }}
														</div>
														<div class="col-sm-4">
															<label class="control-label hidelabel {{ ($i == 0) ? '':'hide' }}"> {{ 'Qualification' }} </label>
															{{ Form::text('qualification[]',$qualArr[$i],array('id'=>'qualification_'.$i,'class'=>'form-control qualification')) }}
														</div>
														<div class="col-sm-4">
															<label class="control-label hidelabel {{ ($i == 0) ? '':'hide' }}"> {{ 'Start date - End date' }} </label>
															{{ Form::text('start_end_date[]',$dateArr[$i],array('id'=>'start_end_date_'.$i,'class'=>'form-control start_end_date')) }}
														</div>
												</div>
												@if($i == 0)
													</div>
												@endif
												<?php $i++; ?>
												@endforeach

												@else
													<div class="education-class">
														<div class="form-group educationcount">
																<div class="col-sm-4">
																	<label class="control-label hidelabel"> {{ 'Education' }} </label>
																	{{ Form::text('education[]','',array('id'=>'education_0','class'=>'form-control education')) }}
																</div>
																<div class="col-sm-4">
																	<label class="control-label hidelabel"> {{ 'Qualification' }} </label>
																	{{ Form::text('qualification[]','',array('id'=>'qualification_0','class'=>'form-control qualification')) }}
																</div>
																<div class="col-sm-4">
																	<label class="control-label hidelabel"> {{ 'Start date - End date' }} </label>
																	{{ Form::text('start_end_date[]','',array('id'=>'start_end_date_0','class'=>'form-control start_end_date')) }}
																</div>
														</div>
													</div>

											@endif
											
											<div class="multiedu"></div>

											<!-- Add Education -->
											<div class="form-group">
												<label class="col-sm-12"><a href="javascript::void(0)" class="addedu">Add Education</a></label>
											</div>

											<?php 
												$langArr = explode(',',$user->lang_prof);
												$lanstarArr = explode(',',$user->lang_star);
											 	$i = 0;
											 ?>
											
											@if(!empty($langArr))
												@foreach($langArr as $value)
													@if($i == 0)<div class="langclass">@endif
															<div class="form-group">
																<div class="col-sm-6">
																	<label class="control-label hidelabel {{ ($i == 0) ? '':'hide' }}"> {{ 'Language Proficiency' }} *</label>
																	{{ Form::text('lang_prof[]',$value,array('id'=>'lang_prof','class'=>'form-control')) }}
																</div>
																<div class="col-sm-4">
																	<label class="hidelabel {{ ($i == 0) ? '':'hide' }}">&nbsp;</label>
																	<div class='rating-stars text-center'>
																	    <ul id="lang-star-{{ $i }}" class="langstar">
																	      <li class='star {{ ($lanstarArr[$i] >= 1) ? "selected" : "" }}' title='Poor' data-value='1'>
																	        <i class='fa fa-star fa-fw'></i>
																	      </li>
																	      <li class='star {{ ($lanstarArr[$i] >= 2) ? "selected" : "" }}' title='Fair' data-value='2'>
																	        <i class='fa fa-star fa-fw'></i>
																	      </li>
																	      <li class='star {{ ($lanstarArr[$i] >= 3) ? "selected" : "" }}' title='Good' data-value='3'>
																	        <i class='fa fa-star fa-fw '></i>
																	      </li>
																	      <li class='star {{ ($lanstarArr[$i] >= 4) ? "selected" : "" }}' title='Excellent' data-value='4'>
																	        <i class='fa fa-star fa-fw'></i>
																	      </li>
																	      <li class='star {{ ($lanstarArr[$i] >= 5) ? "selected" : "" }}' title='WOW!!!' data-value='5'>
																	        <i class='fa fa-star fa-fw'></i>
																	      </li>
																	    </ul>
																	    {{ Form::hidden('lang_star[]',$lanstarArr[$i],array('class'=>'lang_star','id'=>'hidden-lang-'.$i)) }}
																	  </div>
																</div>
														<div class="col-sm-2"></div>
													</div>
													@if($i == 0) </div> @endif

												<?php $i++; ?>
												@endforeach
											@else
												<div class="langclass">
													<div class="form-group">
														<div class="col-sm-6">
															<label class="control-label"> {{ 'Language Proficiency' }} *</label>
															{{ Form::text('lang_prof[]','',array('id'=>'lang_prof','class'=>'form-control')) }}
														</div>
														<div class="col-sm-4">
															<label class="hidelabel">&nbsp;</label>
															<div class='rating-stars text-center'>
															    <ul id='lang-star-0' class="langstar">
															      <li class='star' title='Poor' data-value='1'>
															        <i class='fa fa-star fa-fw'></i>
															      </li>
															      <li class='star' title='Fair' data-value='2'>
															        <i class='fa fa-star fa-fw'></i>
															      </li>
															      <li class='star' title='Good' data-value='3'>
															        <i class='fa fa-star fa-fw'></i>
															      </li>
															      <li class='star' title='Excellent' data-value='4'>
															        <i class='fa fa-star fa-fw'></i>
															      </li>
															      <li class='star' title='WOW!!!' data-value='5'>
															        <i class='fa fa-star fa-fw'></i>
															      </li>
															    </ul>
															    {{ Form::hidden('lang_star[]','',array('class'=>'lang_star','id'=>'hidden-lang-0')) }}
															  </div>
														</div>
														<div class="col-sm-2"></div>
													</div>
											</div>
											@endif
											
											<div class="multilang"></div>

											<div class="form-group">
												<label class="col-sm-12"><a href="javascript::void(0)" class="addlang">Add Language</a></label>
											</div>

											<!-- Multi Skills -->
											<?php 
												$skillArr = explode(',',$user->skill);
												$skillStarArr = explode(',',$user->skill_star);
											 	$i = 0;
											 ?>
											
											@if(!empty($skillArr))
												@foreach($skillArr as $value)
													@if($i == 0)<div class="skillclass">@endif
															<div class="form-group">
																<div class="col-sm-6">
																	<label class="control-label hidelabel {{ ($i == 0) ? '':'hide' }}"> {{ 'Add Your Skills' }} *</label>
																	{{ Form::text('skills[]',$value,array('class'=>'form-control')) }}
																</div>
																<div class="col-sm-4">
																	<label class="hidelabel {{ ($i == 0) ? '':'hide' }}">&nbsp;</label>
																	<div class='rating-stars text-center'>
																	    <ul id="skill-star-{{ $i }}" class="skillstar">
																	      <li class='star {{ ($skillStarArr[$i] >= 1) ? "selected" : "" }}' title='Poor' data-value='1'>
																	        <i class='fa fa-star fa-fw'></i>
																	      </li>
																	      <li class='star {{ ($skillStarArr[$i] >= 2) ? "selected" : "" }}' title='Fair' data-value='2'>
																	        <i class='fa fa-star fa-fw'></i>
																	      </li>
																	      <li class='star {{ ($skillStarArr[$i] >= 3) ? "selected" : "" }}' title='Good' data-value='3'>
																	        <i class='fa fa-star fa-fw '></i>
																	      </li>
																	      <li class='star {{ ($skillStarArr[$i] >= 4) ? "selected" : "" }}' title='Excellent' data-value='4'>
																	        <i class='fa fa-star fa-fw'></i>
																	      </li>
																	      <li class='star {{ ($skillStarArr[$i] >= 5) ? "selected" : "" }}' title='WOW!!!' data-value='5'>
																	        <i class='fa fa-star fa-fw'></i>
																	      </li>
																	    </ul>
																	    {{ Form::hidden('skill_star[]',$skillStarArr[$i],array('class'=>'skill_star','id'=>'hidden-skill-'.$i)) }}
																	  </div>
																</div>
														<div class="col-sm-2"></div>
													</div>
													@if($i == 0) </div> @endif

												<?php $i++; ?>
												@endforeach
											@else
												<div class="skillclass">
													<div class="form-group">
														<div class="col-sm-6">
															<label class="control-label hidelabel"> {{ 'Add Your Skills' }} *</label>
															{{ Form::text('skills[]','',array('class'=>'form-control')) }}
														</div>
														<div class="col-sm-4">
															<label class="hidelabel">&nbsp;</label>
															<div class='rating-stars text-center'>
															    <ul id='skill-star-0' class="skillstar">
															      <li class='star' title='Poor' data-value='1'>
															        <i class='fa fa-star fa-fw'></i>
															      </li>
															      <li class='star' title='Fair' data-value='2'>
															        <i class='fa fa-star fa-fw'></i>
															      </li>
															      <li class='star' title='Good' data-value='3'>
															        <i class='fa fa-star fa-fw'></i>
															      </li>
															      <li class='star' title='Excellent' data-value='4'>
															        <i class='fa fa-star fa-fw'></i>
															      </li>
															      <li class='star' title='WOW!!!' data-value='5'>
															        <i class='fa fa-star fa-fw'></i>
															      </li>
															    </ul>
															    {{ Form::hidden('skill_star[]','',array('class'=>'skill_star','id'=>'hidden-skill-0')) }}
															  </div>
														</div>
														<div class="col-sm-2"></div>
													</div>
											</div>
											@endif

											<div class="multiskill"></div>

											<div class="form-group">
												<label class="col-sm-12"><a href="javascript::void(0)" class="addskills">Add Skills/Keywords</a></label>
											</div>

											
											<?php 
												$recentjobArr =  explode(",", $user->recent_job);
												$recentEmpArr =  explode(",", $user->recent_employer);
												$jobDateArr =  explode(",", $user->job_start_end_date);
												$descriptionArr =  explode(",", $user->description);
												$jobYearArr =  explode(",", $user->job_year);
												$jobMonthArr =  explode(",", $user->job_month);
											?>

											@if(!empty($recentjobArr))
											<?php $i = 0; ?>
											@foreach($recentjobArr as $value)
													<div class="exp-class">
														<div class="form-group expcount">
															<div class="col-sm-4">
																<label class="control-label hidelabel"> {{ 'Most recent Job' }} *</label>
																{{ Form::text('recent_job[]',$value,array('id'=>'recent_job','class'=>'form-control')) }}
															</div>
															<div class="col-sm-4">
																<label class="control-label hidelabel"> {{ 'Most recent Employer' }} *</label>
																{{ Form::text('recent_employer[]',$recentEmpArr[$i],array('id'=>'recent_employer','class'=>'form-control')) }}
															</div>
															<div class="col-sm-4">
																<label class="control-label hidelabel"> {{ 'Start Date End Date' }} *</label>
																{{ Form::text('job_start_end_date[]',$jobDateArr[$i],array('id'=>'job_start_end_date','class'=>'form-control start_end_date')) }}
															</div>
														</div>

														<div class="form-group">
															<label class="col-sm-4"></label>
															<div class="col-sm-4">
																{{ Form::textarea('description[]', $descriptionArr[$i], array('class'=>'form-control','rows'=>5)) }}
															</div>
															<div class="col-sm-2">
																{{ Form::text('job_year[]', !empty($jobYearArr[$i]) ? $jobYearArr[$i] : '', array('class'=>'form-control', 'placeholder'=>'Year')) }}
															</div>
															<div class="col-sm-2">
																{{ Form::text('job_month[]', !empty($jobMonthArr[$i]) ? $jobMonthArr[$i] : '', array('class'=>'form-control','placeholder'=>'Month')) }}
															</div>
														</div>
											</div>
											<?php $i++; ?>
											@endforeach
											@else
												<div class="exp-class">
												<div class="form-group expcount">
													<div class="col-sm-4">
														<label class="control-label hidelabel"> {{ 'Most recent Job' }} *</label>
														{{ Form::text('recent_job[]',$user->recent_job,array('id'=>'recent_job','class'=>'form-control')) }}
													</div>
													<div class="col-sm-4">
														<label class="control-label hidelabel"> {{ 'Most recent Employer' }} *</label>
														{{ Form::text('recent_employer[]',$user->recent_employer,array('id'=>'recent_employer','class'=>'form-control')) }}
													</div>
													<div class="col-sm-4">
														<label class="control-label hidelabel"> {{ 'Start Date End Date' }} *</label>
														{{ Form::text('job_start_end_date[]',$user->job_start_end_date,array('id'=>'job_start_end_date','class'=>'form-control start_end_date')) }}
													</div>
												</div>

												<div class="form-group">
													<label class="col-sm-4"></label>
													<div class="col-sm-4">
														{{ Form::textarea('description[]', '', array('class'=>'form-control','rows'=>5)) }}
													</div>
													<div class="col-sm-2">
														{{ Form::text('job_year[]', '', array('class'=>'form-control', 'placeholder'=>'Year')) }}
													</div>
													<div class="col-sm-2">
														{{ Form::text('job_month[]', '', array('class'=>'form-control','placeholder'=>'Month')) }}
													</div>
												</div>
											</div>
											@endif

											

											<div class="multiexp"></div>

											<div class="form-group">
												<label class="col-sm-12"><a href="javascript::void(0)" class="addexp">Add experience</a></label>
											</div>

											<div class="form-group">
												<label class="col-sm-3">
													Differential Ability *
												</label>
												<div class="col-sm-3">
													<label class="radio-inline">
												     {{ Form::radio('diff_ability', 1, ($user->diff_ability == 1) ? true : false, array('class'=>'')) }} Yes
												    </label>
												    <label class="radio-inline">
												      {{ Form::radio('diff_ability', 0, ($user->diff_ability == 0) ? true : false, array('class'=>'')) }} No
												    </label>
												</div>
												<div class="col-sm-6"></div>
											</div>
											<div class="form-group">
												<div class="col-sm-4">
													Date of birth
													{{ Form::date('dob', $user->dob, array('class'=>'form-control','placeholder'=>'Date of Birth')) }}
												</div>
												<div class="col-sm-4">
													Birth Place
													{{ Form::text('birth_place', $user->birth_place, array('class'=>'form-control','placeholder'=>'Birth Place')) }}
												</div>
												<div class="col-sm-4">
													Nationality
													{{ Form::text('nationality', $user->nationality, array('class'=>'form-control','placeholder'=>'Nationality')) }}
												</div>
											</div>

											<div class="form-group">
												<div class="col-sm-4">
													<label>Desire Salary range</label>
													{{ Form::text('min_sal', $user->min_sal, array('class'=>'form-control','placeholder'=>'Minimum salary')) }}
												</div>
												<div class="col-sm-4">
													<label>&nbsp;</label>
													{{ Form::text('max_sal', $user->max_sal, array('class'=>'form-control','placeholder'=>'Maximum salary')) }}
												</div>
												<div class="col-sm-2">
													<label>&nbsp;</label>
													{{ Form::select('', array(''=>''), '', array('class'=>'form-control selecter')) }}
												</div>
												<div class="col-sm-2">
													<label>&nbsp;</label>
													{{ Form::select('per_year', range(1990,2018), $user->per_year, array('class'=>'form-control selecter')) }}
												</div>
											</div>

											<div class="form-group">
												<label class="col-sm-2">Job Type</label>
												<div class="col-sm-10">
													@foreach ($postTypes as $postType)
														{!! Form::radio('post_type_id', $postType->tid, ($user->post_type_id == $postType->tid) ? true : false , array('required'=>true)); !!}	{{ $postType->name }}
													@endforeach
												</div>
											</div>

											<div class="form-group">
												<div class="col-sm-6">
														<label>Type Contract</label>
														{{ Form::select('contract_type', array('0'=>'Select','market needs'=>'market needs', 'determined work'=>'determined work','increase activity'=>'increase activity'), $user->contract_type, array('class'=>'form-control selecter', 'id'=>'contract_type')) }}	
												</div>
												<div class="col-sm-3">
														<label>Military Service</label>
														<div>
															Yes {!! Form::radio('mili_serv', '1', ($user->mili_serv == 1) ? true : false , array('required'=>true)); !!}
															No {!! Form::radio('mili_serv', '0', ($user->mili_serv == 0) ? true : false , array('required'=>true)); !!}
														</div>	
												</div>
											</div>

											<div class="form-group">
												<label class="col-sm-1">Sex</label>
												<div class="col-sm-3">
													@if ($genders->count() > 0)
                                                            @foreach ($genders as $gender)
                                                                <label class="radio-inline" for="gender_id">
                                                                    <input name="gender_id" id="gender_id-{{ $gender->tid }}" value="{{ $gender->tid }}"
                                                                           type="radio" {{ (old('gender_id', $user->gender_id)==$gender->tid) ? 'checked="checked"' : '' }}>
                                                                    {{ $gender->name }}
                                                                </label>
                                                            @endforeach
                                                        @endif
												</div>
												<div class="col-sm-8"></div>
											</div>

											<div class="form-group">
												<div class="col-sm-12">
													<label>Address *</label>
													{{ Form::text('address', $user->address, array('class'=>'form-control','placeholder'=>'Address')) }}
												</div>
											</div>

											<div class="form-group">
												<div class="col-sm-12">
													{{ Form::textarea('declaration', $user->declaration, array('class'=>'form-control', 'placeholder'=>'Declaration')) }}
												</div>
											</div>

											<div class="form-group">
												<div class="col-sm-offset-3 col-sm-9"></div>
											</div>
											
											<!-- Button -->
											<div class="form-group">
												<div class="col-sm-offset-3 col-sm-9">
													<button type="submit" class="btn btn-primary">{{ t('Update') }}</button>
												</div>
											</div>
										</form>
									</div>
								</div>
							</div>
						
							<!-- SETTINGS -->
							<div class="panel panel-default">
								<div class="panel-heading">
									<h4 class="panel-title"><a href="#settingsPanel" data-toggle="collapse" data-parent="#accordion"> {{ t('Settings') }} </a></h4>
								</div>
								<div class="panel-collapse collapse {{ (old('panel')=='settingsPanel') ? 'in' : '' }}" id="settingsPanel">
									<div class="panel-body">
										<form name="settings" class="form-horizontal" role="form" method="POST" action="{{ lurl('account/settings') }}">
											{!! csrf_field() !!}
											<input name="_method" type="hidden" value="PUT">
											<input name="panel" type="hidden" value="settingsPanel">
											
											<!-- disable_comments -->
											<div class="form-group">
												<div class="col-sm-12">
													<div class="checkbox">
														<label>
															<input id="disable_comments" name="disable_comments" value="1"
																   type="checkbox" {{ ($user->disable_comments==1) ? 'checked' : '' }}>
															{{ t('Disable comments on my ads') }}
														</label>
													</div>
												</div>
											</div>
											
											<!-- password -->
											<div class="form-group <?php echo (isset($errors) and $errors->has('password')) ? 'has-error' : ''; ?>">
												<label class="col-sm-3 control-label">{{ t('New Password') }}</label>
												<div class="col-sm-9">
													<input id="password" name="password" type="password" class="form-control" placeholder="{{ t('Password') }}">
												</div>
											</div>
											
											<!-- password_confirmation -->
											<div class="form-group <?php echo (isset($errors) and $errors->has('password')) ? 'has-error' : ''; ?>">
												<label class="col-sm-3 control-label">{{ t('Confirm Password') }}</label>
												<div class="col-sm-9">
													<input id="password_confirmation" name="password_confirmation" type="password"
														   class="form-control" placeholder="{{ t('Confirm Password') }}">
												</div>
											</div>
											
											<!-- Button -->
											<div class="form-group">
												<div class="col-sm-offset-3 col-sm-9">
													<button type="submit" class="btn btn-primary">{{ t('Update') }}</button>
												</div>
											</div>
										</form>
									</div>
								</div>
							</div>

						</div>
						<!--/.row-box End-->

					</div>
				</div>
				<!--/.page-content-->
			</div>
			<!--/.row-->
		</div>
		<!--/.container-->
	</div>
	<!-- /.main-container -->
@endsection

@section('after_styles')
	<link href="{{ url('assets/plugins/bootstrap-fileinput/css/fileinput.min.css') }}" rel="stylesheet">
	@if (config('lang.direction') == 'rtl')
		<link href="{{ url('assets/plugins/bootstrap-fileinput/css/fileinput-rtl.min.css') }}" rel="stylesheet">
	@endif
	<style>
		.krajee-default.file-preview-frame:hover:not(.file-preview-error) {
			box-shadow: 0 0 5px 0 #666666;
		}
	</style>
@endsection

@section('after_scripts')
	<script src="{{ url('assets/plugins/bootstrap-fileinput/js/plugins/sortable.min.js') }}" type="text/javascript"></script>
	<script src="{{ url('assets/plugins/bootstrap-fileinput/js/fileinput.min.js') }}" type="text/javascript"></script>
	@if (file_exists(public_path() . '/assets/plugins/bootstrap-fileinput/js/locales/'.config('app.locale').'.js'))
		<script src="{{ url('assets/plugins/bootstrap-fileinput/js/locales/'.config('app.locale').'.js') }}" type="text/javascript"></script>
	@endif

{{-- <script type="text/javascript" src="https://cdn.jsdelivr.net/jquery/latest/jquery.min.js"></script> --}}
<script type="text/javascript" src="https://cdn.jsdelivr.net/momentjs/latest/moment.min.js"></script>
<script type="text/javascript" src="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.min.js"></script>
<link rel="stylesheet" type="text/css" href="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.css" />

	<script type="text/javascript">
		$(document).ready(function(){
  	$('.start_end_date').daterangepicker({ showDropdowns: true });
  	/*$('input[name="birthday"]').daterangepicker({
    singleDatePicker: true,
    showDropdowns: true,
    minYear: 1901,
    maxYear: parseInt(moment().format('YYYY'),10)
  }, function(start, end, label) {
    var years = moment().diff(start, 'years');
    alert("You are " + years + " years old!");
  });*/
  /* 1. Visualizing things on Hover - See next part for action on click */
  $('.langstar li').on('mouseover', function(){
    var onStar = parseInt($(this).data('value'), 10); // The star currently mouse on
   
    // Now highlight all the stars that's not after the current hovered star
    $(this).parent().children('li.star').each(function(e){
      if (e < onStar) {
        $(this).addClass('hover');
      }
      else {
        $(this).removeClass('hover');
      }
    });
    
  }).on('mouseout', function(){
    $(this).parent().children('li.star').each(function(e){
      $(this).removeClass('hover');
    });
  });
  
  
  /* 2. Action to perform on click */
  /*$('#lang-star-0 li').on('click', function(){
    var onStar = parseInt($(this).data('value'), 10); // The star currently selected
    var stars = $(this).parent().children('li.star');
    
    for (i = 0; i < stars.length; i++) {
      $(stars[i]).removeClass('selected');
    }
    
    for (i = 0; i < onStar; i++) {
      $(stars[i]).addClass('selected');
    }
    
    // JUST RESPONSE (Not needed)
    var ratingValue = parseInt($('#lang-star-0 li.selected').last().data('value'), 10);
    console.log(ratingValue);
    $('.lang_star').val(ratingValue);
    
  });*/

  $('#stars-2 li').on('click', function(){
    var onStar = parseInt($(this).data('value'), 10); // The star currently selected
    var stars = $(this).parent().children('li.star');
    
    for (i = 0; i < stars.length; i++) {
      $(stars[i]).removeClass('selected');
    }
    
    for (i = 0; i < onStar; i++) {
      $(stars[i]).addClass('selected');
    }
    
    // JUST RESPONSE (Not needed)
    var ratingValue = parseInt($('#stars-2 li.selected').last().data('value'), 10);
    var msg = "";
    if (ratingValue > 1) {
        msg = "Thanks! You rated this " + ratingValue + " stars.";
        console.log(msg);
    }
    else {
        msg = "We will improve ourselves. You rated this " + ratingValue + " stars.";
        console.log(msg);
    }
  });
  
  
});

// Multiple Language
$(".addlang").click(function(){
	 var num     = $('.langstar').length;
	 var newElem =  $('.langclass > div').clone();
	 newElem.find(".langstar").attr('id',  'lang-star-' + num);
	 newElem.find(".lang_star").attr('id',  'hidden-lang-' + num);
	 newElem.find(".hidelabel").hide();
	 $('.multilang').after(newElem);
	 starLangQuery(num);

});

function starLangQuery(num){
		  $('#lang-star-'+num+' li').on('click', function(){
		    var onStar = parseInt($(this).data('value'), 10); // The star currently selected
		    var stars = $(this).parent().children('li.star');
		    for (i = 0; i < stars.length; i++) {
		      $(stars[i]).removeClass('selected');
		    }
		    for (i = 0; i < onStar; i++) {
		      $(stars[i]).addClass('selected');
		    }
		    var ratingValue = parseInt($('#lang-star-'+num+' li.selected').last().data('value'), 10);
		    $('#hidden-lang-'+num).val(ratingValue);
		  });
	 }

	
	 for(var i=0 ; i <= $('.langstar').length ; i++){
			starLangQuery(i);
	 }


// Skill Star
$(".addskills").click(function(){
	 var num     = $('.skillstar').length;
	 var newElem =  $('.skillclass > div').clone();
	 newElem.find(".skillstar").attr('id',  'skill-star-' + num);
	 newElem.find(".skill_star").attr('id',  'hidden-skill-' + num);
	 newElem.find(".hidelabel").hide();
	 $('.multiskill').after(newElem);
	 starSkillQuery(num);
});

 function starSkillQuery(num){
 	console.log('skill function');
	  $('#skill-star-'+num+' li').on('click', function(){
	    var onStar = parseInt($(this).data('value'), 10); // The star currently selected
	    var stars = $(this).parent().children('li.star');
	    for (i = 0; i < stars.length; i++) {
	      $(stars[i]).removeClass('selected');
	    }
	    for (i = 0; i < onStar; i++) {
	      $(stars[i]).addClass('selected');
	    }
	    var ratingValue = parseInt($('#skill-star-'+num+' li.selected').last().data('value'), 10);
	    $('#hidden-skill-'+num).val(ratingValue);
	  });
 }


 for(var i=0 ; i <= $('.skillstar').length ; i++){
		starSkillQuery(i);
 }


$(".addedu").click(function(){
	 var num     = $('.educationcount').length;
	 var newElem =  $('.education-class > div').clone();
	 newElem.find(".education").attr('id',  'education_' + num);
	 newElem.find(".qualification").attr('id',  'qualification_' + num);
	 newElem.find(".start_end_date").attr('id',  'start_end_date_' + num);
	 newElem.find(".education").val('');
	 newElem.find(".qualification").val('');
	 newElem.find(".start_end_date").val('');
	 newElem.find(".hidelabel").hide();
	 $('.multiedu').after(newElem);
});

$(".addexp").click(function(){
	 var num     = $('.expcount').length;
	 var newElem =  $('.exp-class > div').clone();
	 /*newElem.find(".education").attr('id',  'education_' + num);
	 newElem.find(".qualification").attr('id',  'qualification_' + num);
	 newElem.find(".start_end_date").attr('id',  'start_end_date_' + num);
	 newElem.find(".education").val('');
	 newElem.find(".qualification").val('');
	 newElem.find(".start_end_date").val('');
	 newElem.find(".hidelabel").hide();*/
	 $('.multiexp').after(newElem);
});	 
</script>
@endsection
