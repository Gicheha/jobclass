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

@section('wizard')
	@include('post.inc.wizard')
@endsection

@section('content')
	@include('common.spacer')
	<div class="main-container">
		<div class="container">
			<div class="row">
				
				@include('post.inc.notification')

				<div class="col-md-9 page-content">
					<div class="inner-box category-content">
						<h2 class="title-2" style="border-bottom: 0;">
							<strong> <i class="icon-docs"></i> {{ t('Post a Job') }}</strong>
						</h2>
						<div class="row">
							<div class="col-sm-12">

								<form class="form-horizontal" id="postForm" method="POST" action="{{ url()->current() }}" enctype="multipart/form-data">
									{!! csrf_field() !!}
									<fieldset>
										<!-- COMPANY -->
										<div class=" hide content-subheading" style="margin-top: 0;">
											<i class="icon-town-hall fa"></i>
											<strong>{{ t('Company Information') }}</strong>
										</div>
										
										<!-- company_id -->
										<div class="form-group hide required <?php echo (isset($errors) and $errors->has('category_id')) ? 'has-error' : ''; ?>">
											<label class="col-md-3 control-label">{{ t('Select a Company') }} <sup>*</sup></label>
											<div class="col-md-8">
												<select id="companyId" name="company_id" class="form-control selecter">
													<option value="0" data-logo=""
															@if (old('company_id', 0)==0)
																selected="selected"
															@endif
													>
														[+] {{ t('New Company') }}
													</option>
													@if (isset($companies) and $companies->count() > 0)
														@foreach ($companies as $item)
															<option value="{{ $item->id }}" data-logo="{{ resize($item->logo, 'small') }}"
																	@if (old('company_id', (isset($postCompany) ? $postCompany->id : 0))==$item->id)
																		selected="selected"
																	@endif
															>
																{{ $item->name }}
															</option>
														@endforeach
													@endif
												</select>
											</div>
										</div>
										
										<!-- logo -->
										<div id="logoField" class="form-group hide">
											<label class="col-md-3 control-label">&nbsp;</label>
											<div class="col-md-8">
												<div class="mb10">
													<div id="logoFieldValue"></div>
												</div>
												<p class="help-block">
													<a id="companyFormLink" href="{{ lurl('account/companies/0/edit') }}" class="btn btn-default">
														<i class="fa fa-pencil-square-o"></i>
														{{ t('Edit the Company') }}
													</a>
												</p>
											</div>
										</div>
										
										{{-- @include('account.company._form', ['originForm' => 'post']) --}}
										
									
										<!-- POST -->
										<div class="content-subheading">
											<i class="icon-town-hall fa"></i>
											<strong>{{ t('Job Details') }}</strong>
										</div>
										
										<!-- parent_id -->
										<!-- <div class="form-group required <?php echo (isset($errors) and $errors->has('parent_id')) ? 'has-error' : ''; ?>">
											<label class="col-md-3 control-label">{{ t('Category') }} <sup>*</sup></label>
											<div class="col-md-8">
												<select name="parent_id" id="parentId" class="form-control selecter">
													<option value="0" data-type=""
															@if (old('parent_id')=='' or old('parent_id')==0)
																selected="selected"
															@endif
													> {{ t('Select a category') }} </option>
													@foreach ($categories as $cat)
														<option value="{{ $cat->tid }}" data-type="{{ $cat->type }}"
																@if (old('parent_id')==$cat->tid)
																	selected="selected"
																@endif
														> {{ $cat->name }} </option>
													@endforeach
												</select>
												<input type="hidden" name="parent_type" id="parent_type" value="{{ old('parent_type') }}">
											</div>
										</div> -->
										
										<!-- category_id -->
										<div id="subCatBloc" class="form-group hide required <?php echo (isset($errors) and $errors->has('category_id')) ? 'has-error' : ''; ?>">
											<label class="col-md-3 control-label">{{ t('Sub-Category') }} <sup>*</sup></label>
											<div class="col-md-8">
												<select name="category_id" id="categoryId" class="form-control selecter">
													<option value="0"
															@if (old('category_id')=='' or old('category_id')==0)
																selected="selected"
															@endif
													> {{ t('Select a sub-category') }} </option>
												</select>
											</div>
										</div>

										<!-- title -->
										<div class="form-group required <?php echo (isset($errors) and $errors->has('title')) ? 'has-error' : ''; ?>">
											<div class="col-md-12">
												<label class="control-label" for="title">{{ t('Job Title') }} <sup>*</sup></label>
												<input id="title" name="title" placeholder="{{ t('Job title') }}" class="form-control input-md"
													   type="text" value="{{ old('title') }}">
												<span class="help-block">{{ t('A great title needs at least 60 characters.') }} </span>
											</div>
										</div>

										<!-- description -->
										<div class="form-group required <?php echo (isset($errors) and $errors->has('description')) ? 'has-error' : ''; ?>">
                                            <div class="col-md-12" style="position: relative; float: right; padding-top: 10px;">
                                            	<label class="control-label" for="description">{{ t('Description') }} <sup>*</sup></label>
                                                <?php $ckeditorClass = (config('settings.single.ckeditor_wysiwyg')) ? 'ckeditor' : ''; ?>
												<textarea class="form-control" id="description" name="description" rows="10">{{ old('description') }}</textarea>
												<p class="help-block">{{ t('Describe what makes your ad unique') }}</p>
											</div>
										</div>

										<!-- skill required -->
										<div class="form-group required <?php echo (isset($errors) and $errors->has('required_skill')) ? 'has-error' : ''; ?>">
                                            <div class="col-md-12">
                                            	<label class="control-label" for="description">{{ 'Skill required' }} <sup>*</sup> (Enter skill by comma separater)</label>
												<input id="required_skill" name="required_skill" placeholder="{{ 'Add skills by Comma Separater' }}" class="form-control input-md"
													   type="text" value="{{ old('required_skill') }}">
											</div>
										</div>

										<!-- Experience -->
										<div class="form-group required <?php echo (isset($errors) and $errors->has('exp_year')) ? 'has-error' : ''; ?>">
											<div class="col-md-6">
												<label class="control-label">{{ t('Experience') }} <sup>*</sup></label>
												<select name="exp_year" id="exp_year" class="form-control selecter">
													<option value="">Select Years</option>
													@foreach (range(0,10) as $years)
														<option value="{{ $years }}"
																@if (old('exp_year')==$years)
																	selected="selected"
																@endif
														> {{ $years }} </option>
													@endforeach
												</select>
											</div>
											<div class="col-md-6">
												<label class="control-label"></label>
												<select name="exp_month" id="exp_month" class="form-control selecter">
													<option value="">Select Months</option>
													@foreach (range(0,11) as $month)
														<option value="{{ $month }}"
																@if (old('exp_month')==$month)
																	selected="selected"
																@endif
														> {{ $month }} </option>
													@endforeach
												</select>
											</div>
										</div>


										<!-- Category and Subcategory -->
										<div class="form-group required <?php echo (isset($errors) and $errors->has('category_id')) ? 'has-error' : ''; ?>">
											
											<div class="col-md-6">
												<label class="control-label">{{ t('Category') }} <sup>*</sup></label>
												<select name="category_id" id="parentId" class="form-control selecter">
													<option value="0" data-type=""
															@if (old('category_id')=='' or old('category_id')==0)
																selected="selected"
															@endif
													> {{ t('Select a category') }} </option>
													@foreach ($categories as $cat)
														<option value="{{ $cat->tid }}" data-type="{{ $cat->type }}"
																@if (old('category_id')==$cat->tid)
																	selected="selected"
																@endif
														> {{ $cat->name }} </option>
													@endforeach
												</select>
												<input type="hidden" name="parent_type" id="parent_type" value="{{ old('parent_type') }}">
											</div>

											<div class="col-md-6">
												<label class="control-label">{{ 'Sub Category' }}</label>
												<select name="sub_category_id" id="subcategoryId" class="form-control selecter">
													<option value="0"
															@if (old('sub_category_id')=='' or old('sub_category_id')==0)
																selected="selected"
															@endif
													> {{ t('Select a sub-category') }} </option>
												</select>
											</div>
										</div>
											

										<!-- Job Function -->
										<div id="postTypeBloc" class="form-group required <?php echo (isset($errors) and $errors->has('job_function')) ? 'has-error' : ''; ?>">
											<div class="col-md-12">
												<label class="control-label">{{ t('Job Function') }} <sup>*</sup></label>
												<select name="job_function" id="postTypeId" class="form-control selecter">
													@foreach ($postTypes as $postType)
														<option value="{{ $postType->tid }}"
																@if (old('post_type_id')==$postType->tid)
																	selected="selected"
																@endif
														> {{ $postType->name }} </option>
													@endforeach
												</select>
											</div>
										</div>


										<!-- Qualification -->
										<div class="form-group required <?php echo (isset($errors) and $errors->has('qualification')) ? 'has-error' : ''; ?>">
                                            <div class="col-md-12">
                                            	<label class=" control-label" for="description">{{ 'Qualification' }} <sup>*</sup></label>
												<input id="qualification" name="qualification" placeholder="{{ 'Qualification' }}" class="form-control input-md"
													   type="text" value="{{ old('qualification') }}">
											</div>
										</div>

										<!-- salary_min & salary_max -->
										<div id="salaryBloc" class="form-group <?php echo (isset($errors) and $errors->has('salary_min')) ? 'has-error' : ''; ?>">
											
											<div class="col-md-6">
												<label class="control-label" for="price">{{ t('Salary') }}</label>
												<div class="input-group">
													@if (config('currency')['in_left'] == 1)
														<span class="input-group-addon">{!! config('currency')['symbol'] !!}</span>
													@endif
													<input id="salary_min" name="salary_min" class="form-control" placeholder="{{ t('Salary (min)') }}" type="text" value="{{ old('salary_min') }}">
													<!-- <input id="salary_max" name="salary_max" class="form-control" placeholder="{{ t('Salary (max)') }}" type="text" value="{{ old('salary_max') }}"> -->
													@if (config('currency')['in_left'] == 0)
														<!-- <span class="input-group-addon">{!! config('currency')['symbol'] !!}</span> -->
													@endif
												</div>
											</div>

											<div class="col-md-6">
												<label class="control-label" for="price">{{ 'Employment Type' }}</label>
												<div class="input-group">
													<input id="employment_type" name="employment_type" class="form-control" placeholder="{{ t('Employment Type') }}" type="text" value="{{ old('employment_type') }}">
												</div>
											</div>

											<!-- salary_type_id -->
											<!-- <div class="col-md-4">
												<select name="salary_type_id" id="salaryTypeId" class="form-control selecter">
													@foreach ($salaryTypes as $salaryType)
														<option value="{{ $salaryType->tid }}"
																@if (old('salary_type_id')==$salaryType->tid)
																	selected="selected"
																@endif
														>
															{{ 'per'.' '.$salaryType->name }}
														</option>
													@endforeach
												</select>
												<div class="checkbox">
													<label>
														<input id="negotiable" name="negotiable" type="checkbox" value="1" {{ (old('negotiable')=='1') ? 'checked="checked"' : '' }}>
														{{ t('Negotiable') }}
													</label>
												</div>
											</div> -->
										</div>

										<!-- start_date -->
										<div class="form-group hide <?php echo (isset($errors) and $errors->has('start_date')) ? 'has-error' : ''; ?>">
											<label class="col-md-3 control-label" for="start_date">{{ t('Start Date') }} </label>
											<div class="col-md-8">
												<input id="start_date" name="start_date" placeholder="{{ t('Start Date') }}" class="form-control input-md"
													   type="text" value="{{ old('start_date') }}">
											</div>
										</div>

										<!-- country_code -->
										@if (empty(config('country.code')))
											<div class="form-group required <?php echo (isset($errors) and $errors->has('country_code')) ? 'has-error' : ''; ?>">
												<label class="col-md-3 control-label" for="country_code">{{ t('Your Country') }} <sup>*</sup></label>
												<div class="col-md-8">
													<select id="countryCode" name="country_code" class="form-control sselecter">
														<option value="0" {{ (!old('country_code') or old('country_code')==0) ? 'selected="selected"' : '' }}> {{ t('Select a country') }} </option>
														@foreach ($countries as $item)
															<option value="{{ $item->get('code') }}" {{ (old('country_code', (!empty(config('ipCountry.code'))) ? config('ipCountry.code') : 0)==$item->get('code')) ? 'selected="selected"' : '' }}>{{ $item->get('name') }}</option>
														@endforeach
													</select>
												</div>
											</div>
										@else
											<input id="countryCode" name="country_code" type="hidden" value="{{ config('country.code') }}">
										@endif

										<?php
										/*
										@if (\Illuminate\Support\Facades\Schema::hasColumn('posts', 'address'))
										<!-- Address -->
										<div class="form-group required <?php echo (isset($errors) and $errors->has('address')) ? 'has-error' : ''; ?>">
											<label class="col-md-3 control-label" for="title">{{ t('Address') }} </label>
											<div class="col-md-8">
												<input id="address" name="address" placeholder="{{ t('Address') }}" class="form-control input-md"
													   type="text" value="{{ old('address') }}">
												<span class="help-block">{{ t('Fill an address to display on Google Maps.') }} </span>
											</div>
										</div>
										@endif
										*/
										?>

										<!-- contact_name -->
										@if (auth()->check())
											<input id="contact_name" name="contact_name" type="hidden" value="{{ auth()->user()->name }}">
										@else
											<div class="form-group required <?php echo (isset($errors) and $errors->has('contact_name')) ? 'has-error' : ''; ?>">
												<label class="col-md-2 control-label" for="contact_name">{{ t('Contact Name') }} <sup>*</sup></label>
												<div class="col-md-6">
													<div class="input-group">
														<span class="input-group-addon"><i class="icon-user"></i></span>
														<input id="contact_name" name="contact_name" placeholder="{{ t('Contact Name') }}"
														   class="form-control input-md" type="text" value="{{ old('contact_name') }}">
													</div>
												</div>
											</div>
										@endif
									
										<!-- email -->
										<div class="form-group hide required <?php echo (isset($errors) and $errors->has('email')) ? 'has-error' : ''; ?>">
											<label class="col-md-3 control-label" for="email"> {{ t('Contact Email') }} <sup>*</sup></label>
											<div class="col-md-8">
												<div class="input-group">
													<span class="input-group-addon">
														<i class="icon-mail"></i>
													</span>
													<input id="email" name="email" class="form-control"
														   placeholder="{{ t('Email') }}" type="text"
														   value="{{ old('email', ((auth()->check() and isset(auth()->user()->email)) ? auth()->user()->email : '')) }}">
												</div>
											</div>
										</div>
									
										<?php
											if (auth()->check()) {
												$formPhone = (auth()->user()->country_code == config('country.code')) ? auth()->user()->phone : '';
											} else {
												$formPhone = '';
											}
										?>
										<!-- phone -->
										<div class="form-group hide required <?php echo (isset($errors) and $errors->has('phone')) ? 'has-error' : ''; ?>">
											<label class="col-md-3 control-label" for="phone">{{ t('Phone Number') }}</label>
											<div class="col-md-8">
												<div class="input-group">
													<span id="phoneCountry" class="input-group-addon">{!! getPhoneIcon(config('country.code')) !!}</span>
													
													<input id="phone" name="phone"
														   placeholder="{{ t('Phone Number') }}"
														   class="form-control input-md" type="text"
														   value="{{ phoneFormat(old('phone', $formPhone), old('country', config('country.code'))) }}"
													>
													
													<label class="input-group-addon">
														<input name="phone_hidden" id="phoneHidden" type="checkbox"
															   value="1" {{ (old('phone_hidden')=='1') ? 'checked="checked"' : '' }}>
														{{ t('Hide') }}
													</label>
												</div>
											</div>
										</div>
									
										@if (config('country.admin_field_active') == 1 and in_array(config('country.admin_type'), ['1', '2']))
										<!-- admin_code -->
										<div id="locationBox" class="form-group required <?php echo (isset($errors) and $errors->has('admin_code')) ? 'has-error' : ''; ?>">
											<label class="col-md-3 control-label" for="admin_code">{{ t('Location') }} <sup>*</sup></label>
											<div class="col-md-8">
												<select id="adminCode" name="admin_code" class="form-control sselecter">
													<option value="0" {{ (!old('admin_code') or old('admin_code')==0) ? 'selected="selected"' : '' }}>
														{{ t('Select your Location') }}
													</option>
												</select>
											</div>
										</div>
										@endif
									
										<!-- city_id && District  -->
										<div id="cityBox" class="form-group required <?php echo (isset($errors) and $errors->has('city_id')) ? 'has-error' : ''; ?>">
											
											<div class="col-md-6">
												<label class="control-label">{{ t('City') }} <sup>*</sup></label>
												<select id="cityId" name="city_id" class="form-control sselecter">
													<option value="0" {{ (!old('city_id') or old('city_id')==0) ? 'selected="selected"' : '' }}>
														{{ t('Select a city') }}
													</option>
												</select>
											</div>
											<div class="col-md-6">
												<label class="control-label">District<sup>*</sup></label>
												<select id="districtId" name="district_id" class="form-control sselecter">
													<option value="0" {{ (!old('district_id') or old('district_id')==0) ? 'selected="selected"' : '' }}>
														{{ t('Select a District') }}
													</option>
												</select>
											</div>
										</div>

										<!-- Job Type && Type of contract -->
										<div id="job_type" class="form-group required <?php echo (isset($errors) and $errors->has('job_type')) ? 'has-error' : ''; ?>">
											
											<div class="col-md-6">
												<label class="control-label">{{ t('Job Type') }} <sup>*</sup> </label>
												<div>
													@foreach ($postTypes as $postType)
														{!! Form::radio('post_type_id', $postType->tid, false, array('required'=>true)); !!}	{{ $postType->name }}
													@endforeach

												</div>
												
											</div>
											<div class="col-md-6">
												<label class="control-label">Type Of Contract</label>	
												<select id="contract_type" name="contract_type" class="form-control selecter">
													<option value="0" {{ (!old('contract_type') or old('contract_type')==0) ? 'selected="selected"' : '' }}>
														{{ t('Select a Contract') }}
													</option>
													<option value="market needs">Market needs</option>
													<option value="determined work">Determined work</option>
													<option value="increase activity">Increase activity</option>
												</select>
											</div>
										</div>

										<!-- gender max age min age -->
										<div class="form-group required <?php echo (isset($errors) and $errors->has('job_type')) ? 'has-error' : ''; ?>">
											<div class="col-md-4">
												<label class="control-label">Job Gender</label>
												<select id="job_gender" name="job_gender" class="form-control selecter">
													<option value="0" {{ (!old('job_gender') or old('job_gender')==0) ? 'selected="selected"' : '' }}>
														{{ t('Select a Gender') }}
													</option>
													<option value="m">Male</option>
													<option value="f">Female</option>
													<option value="o">Others</option>
												</select>													
											</div>
											<div class="col-md-4">
												<lable class="control-label">Max Age</lable>
												{!! Form::select('max_age',range(16,60), '',array('class'=>'form-control selecter')) !!}
											</div>
											<div class="col-md-4">
												<lable class="control-label">Min Age</lable>
												{!! Form::select('min_age',range(16,60), '',array('class'=>'form-control selecter')) !!}
											</div>
										</div>


										{{-- Level Edu Degree School --}}
										<div class="form-group required <?php echo (isset($errors) and $errors->has('job_type')) ? 'has-error' : ''; ?>">

											<div class="col-md-4">
												<label class="control-label">Level Education</label>
												<select id="edu_level" name="edu_level" class="form-control selecter" multiple="multiple">
													{{-- <option value="0" {{ (!old('edu_level') or old('edu_level')==0) ? 'selected="selected"' : '' }}>
														{{ t('Select a Education Level') }}
													</option> --}}
													<option value="A">A</option>
													<option value="B">B</option>
													<option value="C">C</option>
												</select>													
											</div>
											<div class="col-md-4">
												<lable class="control-label">Degree</lable>
												{!! Form::select('degree',array(''=>'Select Degree','BE'=>'BE','BCOM'=>'bcom'), '',array('class'=>'form-control selecter','multiple'=>'multiple')) !!}
											</div>
											<div class="col-md-4">
												<lable class="control-label">School</lable>
												{!! Form::select('school',array(''=>'Select School','10'=>'10','12'=>'12'), '',array('class'=>'form-control selecter','multiple'=>'multiple')) !!}
											</div>
										</div>	

										<div class="form-group required <?php echo (isset($errors) and $errors->has('job_type')) ? 'has-error' : ''; ?>">
											<div class="col-md-12">
												{!! Form::checkbox('is_feature',1,false) !!}
												<label>Is Feature Job ?</label>
											</div>
										</div>

										<!-- application_url -->
										<div class="form-group hide <?php echo (isset($errors) and $errors->has('application_url')) ? 'has-error' : ''; ?>">
											<label class="col-md-3 control-label" for="title">{{ t('Application URL') }}</label>
											<div class="col-md-8">
												<div class="input-group">
													<span class="input-group-addon"><i class="icon-reply"></i></span>
													<input id="application_url" name="application_url"
														   placeholder="{{ t('Application URL') }}" class="form-control input-md" type="text"
														   value="{{ old('application_url') }}">
												</div>
												<span class="help-block">{{ t('Candidates will follow this URL address to apply for the job.') }}</span>
											</div>
										</div>
										
										<!-- tags -->
										<div class="form-group hide <?php echo (isset($errors) and $errors->has('tags')) ? 'has-error' : ''; ?>">
											<label class="col-md-3 control-label" for="title">{{ t('Tags') }}</label>
											<div class="col-md-8">
												<input id="tags" name="tags" placeholder="{{ t('Tags') }}" class="form-control input-md" type="text" value="{{ old('tags') }}">
												<span class="help-block">{{ t('Enter the tags separated by commas.') }}</span>
											</div>
										</div>
                                        
										@if (config('settings.security.recaptcha_activation'))
                                            <!-- g-recaptcha-response -->
											<div class="form-group required <?php echo (isset($errors) and $errors->has('g-recaptcha-response')) ? 'has-error' : ''; ?>">
												<label class="col-md-3 control-label" for="g-recaptcha-response"></label>
												<div class="col-md-8">
													{!! Recaptcha::render(['lang' => config('app.locale')]) !!}
												</div>
											</div>
										@endif

										<!-- term -->
										<div class="form-group required <?php echo (isset($errors) and $errors->has('term')) ? 'has-error' : ''; ?>">
											<label class="col-md-3 control-label"></label>
											<div class="col-md-8">
												<label class="checkbox-inline" for="term-0" style="margin-left: -20px;">
													{!! t('By continuing on this website, you accept our <a :attributes>Terms of Use</a>', ['attributes' => getUrlPageByType('terms')]) !!}
												</label>
											</div>
										</div>

										<!-- Button  -->
										<div class="form-group">
											<div class="col-md-12" style="text-align: center;">
												<button id="nextStepBtn" class="btn btn-primary"> {{ 'Post Job' }} </button>

												<button id="nextStepBtn1" class="btn btn-primary"> {{ 'Save Post Later' }} </button>
											</div>
										</div>

										<div style="margin-bottom: 30px;"></div>

									</fieldset>
								</form>


							</div>
						</div>
					</div>
				</div>
				<!-- /.page-content -->

				<div class="col-md-3 reg-sidebar hide">
					<div class="reg-sidebar-inner text-center">
						<div class="promo-text-box"><i class=" icon-picture fa fa-4x icon-color-1"></i>
							<h3><strong>{{ t('Post a Job') }}</strong></h3>
							<p>
								{{ t('Do you have a post to be filled within your company? Find the right candidate in a few clicks at :app_name', ['app_name' => config('app.name')]) }}
							</p>
						</div>

						<div class="panel sidebar-panel">
							<div class="panel-heading uppercase">
								<small><strong>{{ t('How to find quickly a candidate?') }}</strong></small>
							</div>
							<div class="panel-content">
								<div class="panel-body text-left">
									<ul class="list-check">
										<li> {{ t('Use a brief title and description of the ad') }} </li>
										<li> {{ t('Make sure you post in the correct category') }}</li>
										<li> {{ t('Add a logo to your ad') }}</li>
										<li> {{ t('Put a min and max salary') }}</li>
										<li> {{ t('Check the ad before publish') }}</li>
									</ul>
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
@endsection

@section('after_styles')
    @include('layouts.inc.tools.wysiwyg.css')
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
    @include('layouts.inc.tools.wysiwyg.js')
    
    <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.13.1/jquery.validate.min.js"></script>
    <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/jquery.payment/1.2.3/jquery.payment.min.js"></script>
	@if (file_exists(public_path() . '/assets/plugins/forms/validation/localization/messages_'.config('app.locale').'.min.js'))
		<script src="{{ url('assets/plugins/forms/validation/localization/messages_'.config('app.locale').'.min.js') }}" type="text/javascript"></script>
	@endif

	<script src="{{ url('assets/plugins/bootstrap-fileinput/js/plugins/sortable.min.js') }}" type="text/javascript"></script>
	<script src="{{ url('assets/plugins/bootstrap-fileinput/js/fileinput.min.js') }}" type="text/javascript"></script>
	@if (file_exists(public_path() . '/assets/plugins/bootstrap-fileinput/js/locales/'.config('app.locale').'.js'))
		<script src="{{ url('assets/plugins/bootstrap-fileinput/js/locales/'.config('app.locale').'.js') }}" type="text/javascript"></script>
	@endif
	
	<script>
		/* Translation */
		var lang = {
			'select': {
				'category': "{{ t('Select a category') }}",
                'subCategory': "{{ t('Select a sub-category') }}",
				'country': "{{ t('Select a country') }}",
				'admin': "{{ t('Select a location') }}",
				'city': "{{ t('Select a city') }}"
			},
			'price': "{{ t('Price') }}",
			'salary': "{{ t('Salary') }}",
            'nextStepBtnLabel': {
                'next': "{{ t('Next') }}",
                'submit': "{{ t('Submit') }}"
            }
		};
		
		/* Company */
		var postCompanyId = {{ old('company_id', (isset($postCompany) ? $postCompany->id : 0)) }};
		getCompany(postCompanyId);
		
		/* Categories */
        var category = {{ old('parent_id', 0) }};
        var categoryType = '{{ old('parent_type') }}';
        if (categoryType=='') {
            var selectedCat = $('select[name=parent_id]').find('option:selected');
            categoryType = selectedCat.data('type');
        }
        var subCategory = {{ old('category_id', 0) }};
		
		/* Locations */
        var countryCode = '{{ old('country_code', config('country.code', 0)) }}';
        var adminType = '{{ config('country.admin_type', 0) }}';
        var selectedAdminCode = '{{ old('admin_code', (isset($admin) ? $admin->code : 0)) }}';
        var cityId = '{{ old('city_id', (isset($post) ? $post->city_id : 0)) }}';
		
		/* Packages */
        var packageIsEnabled = false;
		@if (isset($packages) and isset($paymentMethods) and $packages->count() > 0 and $paymentMethods->count() > 0)
            packageIsEnabled = true;
        @endif
	</script>
	<script>
		$(document).ready(function() {
			/* Company */
			$('#companyId').bind('click, change', function() {
				postCompanyId = $(this).val();
				getCompany(postCompanyId);
			});
			
			$('#tags').tagit({
				fieldName: 'tags',
				placeholderText: '{{ t('add a tag') }}',
				caseSensitive: true,
				allowDuplicates: false,
				allowSpaces: false,
				tagLimit: {{ (int)config('settings.single.tags_limit', 15) }},
				singleFieldDelimiter: ','
			});
		});
	</script>
	<script src="{{ url('assets/js/app/d.select.category.js') . vTime() }}"></script>
	<script src="{{ url('assets/js/app/d.select.location.js') . vTime() }}"></script>
@endsection
