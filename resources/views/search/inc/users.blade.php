<?php
if (!isset($cacheExpiration)) {
    $cacheExpiration = (int)config('settings.other.cache_expiration');
}
?>

@if(!empty($users))
 @foreach ($users as $user)
 <div class="item-list job-item">
			<div class="col-sm-1 col-xs-2 no-padding photobox">
				<div class="add-image">
					@if(!empty($user->avatar))
					<a href="#">
						<img class="thumbnail no-margin" src="{{ url($user->avatar) }}" alt="{{ $user->name }}">
					</a>
					@else
					<a href="#">
						<img class="thumbnail no-margin" src="{{ url('images/user.jpg') }}" alt="{{ $user->name }}">
					</a>
					@endif
				</div>
			</div>

			<div class="col-sm-5 col-xs-5 add-desc-box">
				<div class="add-details jobs-item">
					<h5 class="company-title">
						 {{ $user->name }}
					</h5>
					<h4 class="job-title">
						{{ explode(',', $user->education)[0] }}
					</h4>
					<span class="info-row">
						{!! explode(',', $user->description)[0] !!}
					</span>
					<strong>Prefer Location :</strong>
					<?php $city = App\Models\City::find($user->work_location); ?>
					<div> <span style="border: 1px solid gray;padding: 3px;">{{ (!is_null($city)) ? $city->name : 'NA' }}</span> </div>
					<br>
					<div> 
						<?php 
							$skills =  explode(',', $user->skill);
							foreach ($skills as  $value) {
								echo "<span style='border: 1px solid gray;padding: 3px;margin-right: 1px;'>$value</span>";
							}
					 	?>
					 	
					 </div>
				</div>
			</div>
			<div class="col-sm-5 col-xs-5 add-desc-box">
					<?php 
						$resume = \DB::table('resumes')
							->where('user_id','=',$user->id)
							->orderBy('id','DESC')
							->first(); 
						$resumedate = 0;
						if(!is_null($resume->updated_at)){
							$date1 = new DateTime(); 
							$date2 = new DateTime($resume->updated_at); 
							$interval = $date1->diff($date2); 
							$resumedate = $interval->days;
						}
						

					?>
					<div><strong>Resume updated {{ $resumedate }} days ago </strong> </div>
					<?php $livein = App\Models\City::find($user->city); ?>
					<div><strong>Live In :</strong> {{  (!is_null($livein)) ? $livein->name : 'NA' }}</div>
					<div><strong>Experience :</strong> {{ $user->years }} years {{ $user->month }} month</div>
					<div><strong>age :</strong>  {{ (date('Y') - date('Y',strtotime($user->dob))) }} years old{{-- {{ $user->dob }} --}}</div>
					<div><strong>Desired salary :</strong> {{ $user->min_sal }} - {{ $user->max_sal }} / year</div>
					<br/>
					<div>
						<a href="#" class="btn btn-primary">View Details</a>
					</div>
				</div>
		</div>
       
 @endforeach
@else
	<div class="item-list">
		{{ t('Users Not Found !!') }}
	</div>
@endif

@section('modal_location')
	@parent
	@include('layouts.inc.modal.send-by-email')
@endsection

@section('after_scripts')
	@parent
	<script>
		/* Favorites Translation */
		var lang = {
			labelSavePostSave: "{!! t('Save Job') !!}",
			labelSavePostRemove: "{{ t('Saved Job') }}",
			loginToSavePost: "{!! t('Please log in to save the Ads.') !!}",
			loginToSaveSearch: "{!! t('Please log in to save your search.') !!}",
			confirmationSavePost: "{!! t('Post saved in favorites successfully !') !!}",
			confirmationRemoveSavePost: "{!! t('Post deleted from favorites successfully !') !!}",
			confirmationSaveSearch: "{!! t('Search saved successfully !') !!}",
			confirmationRemoveSaveSearch: "{!! t('Search deleted successfully !') !!}"
		};
		
		$(document).ready(function ()
		{
			/* Get Post ID */
			$('.email-job').click(function(){
				var postId = $(this).attr("data-id");
				$('input[type=hidden][name=post]').val(postId);
			});

			@if (isset($errors) and $errors->any())
				@if (old('sendByEmailForm')=='1')
					$('#sendByEmail').modal();
				@endif
			@endif
		})
	</script>
@endsection
