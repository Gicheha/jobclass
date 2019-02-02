@extends('layouts.master')

@section('search')
	@parent
    @include('pages.inc.page-intro')
@endsection

@section('content')
    <!--Nav Tabs-->
    <div class="pagination-centered">
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
                            <button>Get Free Demo</button>
                        </div>
                    </div>
                    @include('common.spacer')
                    <div class="row">
                        <div class="col-md-2 col-md-offset-5">
                        @foreach($packages as $key => $package)
                            <div class="card mx-auto" style="width: 18rem;">
                                <div class="card-body">
                                    <h5 class="card-title">{{$package->name}}</h5>
                                    <h6 class="card-subtitle mb-2 text-muted">{{$package->price}}</h6>
                                    <p class="card-text">{{$package->description}}</p>
                                    <a href="#" class="card-link">$package->duration</a>
                                    <a href="#" class="card-link">Another link</a>
                                </div>
                            </div>
                        @endforeach
                    </div>
                    </div>    
                </div>    
            </div>    
        </div>
        <div class="tab-pane" id="paid">
            <div>
                <h2>Find relevant candidates with the World's most advanced keyword-search engine*</h2>
                <ul>
                    <li>Perform Keyword Searches with 11 filters to <b>get accurate results</b></li>
                    <li>Sort and Filter candidates based on their skills, relevance and qualifications</li>
                    <li><b>Download Candidate information</b> directly from the search page with a single click</li>
                    <li>Simplified way to <b>convert search into job postings</b> and receive applications</li>
                </ul>
                
            </div>
            <div>
                @foreach($packages as $key => $package)
                    <div class="card mx-auto" style="width: 18rem;">
                        <div class="card-body">
                            <h5 class="card-title">{{$package->name}}</h5>
                            <h6 class="card-subtitle mb-2 text-muted">Card subtitle</h6>
                            <p class="card-text">Some quick example text to build on the card title and make up the bulk of the card's content.</p>
                            <a href="#" class="card-link">Card link</a>
                            <a href="#" class="card-link">Another link</a>
                        </div>
                    </div>
                @endforeach
            </div>
            <div>
                <button>Get Free Demo</button>
            </div>
        </div>
        <div class="tab-pane" id="package">
            <form method="post" action="" role="form" class="pagination-centered">
                <div class="form-group text-center">
                    <div class="form-group mb-2"><input type="text" name="Name" required placeholder="Name" /></div>
                    <div class="form-group mb-2"><input type="email" name="Email" required placeholder="Email"/></div>
                    <div class="form-group mb-2"><input type="text" name="Mobile" required placeholder="Mobile No"/></div>
                    <select name="interest"  >
                    <option></option>
                    <option></option>
                    <option></option>
                    <option></option>
                </select>
                    <select name="interest">
                    <option></option>
                    <option></option>
                    <option></option>
                    <option></option>
                </select>
                    <input type="hidden" name="_token" id="crsf-token" value="{{Session::token()}}"/>
                    <div class="form-group mb-2"><input type="submit" class="btn btn-primary" value="submit"/></div>
                </div>    
            </form>
        </div>
    </div>
@endsection


