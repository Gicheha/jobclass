@extends('layouts.master')

@section('search')
	@parent
    @include('pages.inc.page-intro')
@endsection

@section('content')
    <!--Nav Tabs-->
    <div class="text-center">
        <ul class="nav nav-tabs" role="tablist">
            <li class="active"><a href="#home" role="tab" data-toggle="tab">Free Packages</a></li>
            <li><a href="#paid" role="tab" data-toggle="tab">Paid Packages</a></li>
            <li><a href="#package" role="tab" data-toggle="tab">Create Your Own Package</a></li>
        </ul>
    </div>

    <div class="tab-content">
        <div class="tab-pane active" id="home">
            <div class="container">
                <div class="row">
                    <div class="column-66">
                        <h2 class="text-center">Get the most relevant candidates auto-matched to your job openings</h2>
                        <ul class="text-center">
                            <li>Get <b>instant access to candidate</b> matching your job requirements. Don't wait for applications</li>
                            <li><b>2-way match:</b> Candidates will be matched not just on profile but also their preferences</li>
                            <li><b>Unlimited access</b> to applications(excel downloads, profile views, resumes).</li>
                            <li>Instant updating of database <b>Reach out to relevant candidates</b> the moment they register</li>
                        </ul>
                    </div>
                    @include('common.spacer')
                    <div class="row">
                        <div class="column-33 col-md-2 col-md-offset-5">
                            <button class="btn btn-large" style="background:#9C27B0;">Get Free Demo</button>
                        </div>
                    </div>
                    @include('common.spacer')
                    <div class="row">
                        <div>
                        @foreach($packages as $key => $package)
                                <div class="border-black" style="border-style:solid; border-radius:2em;border-width:medium;border-color:#03A9F4">    
                                    <div class="card text-primary border-black" >
                                        <div class="card-body">
                                            <h5 class="card-title logo text-center">{{$package->name}}</h5>
                                            <h6 class="card-subtitle mb-2 text-center" style="font-size:1.75em"> $ {{$package->price}}</h6>
                                            <p class="card-text text-center">{{$package->description}}</p>
                                            <p class="card-text text-center"> Valid for {{$package->duration}} Days </p>
                                        </div>
                                    </div>    
                                </div>
                            @include('common.spacer')
                        @endforeach
                        </div>
                    </div>    
                </div>    
            </div>    
        </div>
        <div class="tab-pane" id="paid">
            <div class="column-66">
                <h2 class="text-center">Get the most relevant candidates auto-matched to your job openings</h2>
                    <ul class="text-center">
                        <li>Perform Keyword Searches with 11 filters to <b>get accurate results</b></li>
                        <li>Sort and Filter candidates based on their skills, relevance and qualifications</li>
                        <li><b>Download Candidate information</b> directly from the search page with a single click.</li>
                        <li>implified way to <b>convert search into job postings</b> and receive applicationsr</li>
                    </ul>
            </div>
            @include('common.spacer')
            <div class="row">
                <div class="column-33 col-md-2 col-md-offset-5">
                    <button class="btn btn-large" style="background:#9C27B0;">Get Free Demo</button>
                </div>
            </div>
            @include('common.spacer')
            <div>
                @foreach($packages as $key => $package)
                    <div class="border-black" style="border-style:solid; border-radius:2em;border-width:medium;border-color:#03A9F4">
                        <div class="card text-primary border-black">
                            <div class="card-body">
                                <h5 class="card-title logo text-center">{{$package->name}}</h5>
                                <h6 class="card-subtitle mb-2 text-center">$ {{$package->price}}</h6>
                                <p class="card-text text-center">{{$package->description}}</p>
                                <p class="card-text text-center">Valid for {{$package->duration}} Days</p>
                            </div>
                        </div>    
                    </div>
                @include('common.spacer')
                @endforeach
            </div>
        </div>
        <div class="tab-pane" id="package">
            @include('common.spacer')
            <form method="post" action="" role="form" class="pagination-centered">
                <div class="row">    
                    <div class="form-group text-center">
                        <div class="form-group mb-2"><input type="text" class="form-control" name="Name" required placeholder="Name" /></div>
                        <div class="form-group mb-2"><input type="email" class="form-control" name="Email" required placeholder="Email"/></div>
                        <div class="form-group mb-2"><input type="text" class="form-control input-normal" name="Mobile" required placeholder="Mobile No"/></div>
                        <div class="form-group mb-2"><select name="interest" class="form-control">
                            @foreach($packages as $key => $package)
                                <option value="{{$package->name}}">{{$package->name}}</option>
                            @endforeach
                        </select>
                        </div>    
                        <input type="hidden" name="_token" id="crsf-token" value="{{Session::token()}}"/>
                        <div class="form-group mb-2"><input type="submit" class="btn btn-primary" value="submit"/></div>
                    </div>
                </div>    
            </form>
        </div>
    </div>
@endsection


