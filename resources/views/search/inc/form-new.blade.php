<?php
// Keywords
$keywords = rawurldecode(request()->get('q'));

// Category
$qCategory = (isset($cat) and !empty($cat)) ? $cat->tid : request()->get('c');

// Location
if (isset($city) and !empty($city)) {
	$qLocationId = (isset($city->id)) ? $city->id : 0;
	$qLocation = $city->name;
    $qAdmin = request()->get('r');
} else {
	$qLocationId = request()->get('l');
    $qLocation = (request()->filled('r')) ? t('area:') . rawurldecode(request()->get('r')) : request()->get('location');
    $qAdmin = request()->get('r');
}
?>
<div class="container">
	{{-- <div class="search-row-wrapper"> --}}
	<div class="search-row-wrapper">
		<div class="container">
			<?php $attr = ['countryCode' => config('country.icode')]; ?>
			<form id="seach" name="search" action="{{ route('search-user') }}" method="GET">
			<?php 
					$category = array();
					foreach($cats->groupBy('parent_id')->get(0) as $itemCat){
							$category[$itemCat->tid] = $itemCat->name;
					}
			 ?>
			 <div class="">	
					<div class="form-group">
						<div class="col-lg-4 col-md-4 col-sm-4 col-xs-12">
							{{ Form::select('category',array(''=>'Category')+$category,request()->get('category'),array('class'=>'form-control sselecter')) }}
						</div>		
						<div class="col-lg-4 col-md-4 col-sm-4 col-xs-12">
							{{ Form::select('sub-category',array(''=>'Sub Category')+$companies->toArray(),request()->get('sub-category'),array('class'=>'form-control sselecter')) }}
						</div>
						<div class="col-lg-4 col-md-4 col-sm-4 col-xs-12">
							{{ Form::select('state',array(''=>'State')+$states->toArray(),request()->get('state'),array('class'=>'form-control sselecter')) }}
						</div>		
					</div>
					<div class="form-group">
						<div class="col-lg-4 col-md-4 col-sm-4 col-xs-12">
							<?php
								$locArr = array();
								foreach ($cities as $city) {
									$locArr[$city->id] = $city->name;
								}
							?>
							{{ Form::select('city',array(''=>'City')+$locArr,request()->get('city'),array('class'=>'form-control sselecter')) }}
						</div>
						<div class="col-lg-4 col-md-4 col-sm-4 col-xs-12">
							{{ Form::select('district',array(''=>'District')+$districts->toArray(),request()->get('district'),array('class'=>'form-control sselecter')) }}
						</div>
						<div class="col-lg-4 col-md-4 col-sm-4 col-xs-12">
							{{ Form::text('job-title-skills',request()->get('job-title-skills'),array('class'=>'form-control','placeholder'=>'Job Title / Skills')) }}
						</div>
					</div>
				</div>
				<div  class="">
					<div class="col-lg-5 col-md-5 col-sm-5 col-xs-12"></div>
					<div class="col-lg-2 col-md-2 col-sm-2 col-xs-12">
						<button class="btn btn-block btn-primary">
							<i class="fa fa-search"></i> <strong>{{ t('Search') }}</strong>
						</button>
					</div>
				</div>

				{!! csrf_field() !!}
			</form>
		</div>
	</div>
	<!-- /.search-row  width: 24.6%; -->
</div>