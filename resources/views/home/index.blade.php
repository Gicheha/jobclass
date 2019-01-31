{{--
 *  Geolocalized Job Board Script
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

@section('search')
	@parent
@endsection

@section('content')
	<div class="main-container" id="homepage">
		
		@if (Session::has('message'))
			@include('common.spacer')
			<?php $paddingTopExists = true; ?>
			<div class="container">
				<div class="row">
					<div class="alert alert-danger">
					
						{{ session('message') }}
					</div>
				</div>
			</div>
		@endif
		
		@if (Session::has('flash_notification'))
			@include('common.spacer')
			<?php $paddingTopExists = true; ?>
			<div class="container">
				<div class="row">
					<div class="col-lg-12">
						@include('flash::message')
					</div>
				</div>
			</div>
		@endif
		
		@if (isset($sections) and $sections->count() > 0)
			@foreach($sections as $section)
				@if (view()->exists($section->view))
					@include($section->view, ['firstSection' => $loop->first])
				@endif
			@endforeach
		@endif
		
	</div>
@endsection

@section('after_scripts')
@endsection
