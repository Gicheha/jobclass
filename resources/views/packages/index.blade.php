@extends('layouts.master')

@section('search')
	@parent
    @include('pages.inc.page-intro')
@endsection

@section('content')
    @include('common.spacer')
    <!--Nav Tabs-->
    <ul class="nav nav-tabs" role="tablist">
        <li class="active"><a href="#home" role="tab" data-toggle="tab">Free Packages</a></li>
        <li><a href="#paid" role="tab" data-toggle="tab">Paid Packages</a></li>
        <li><a href="#package" role="tab" data-toggle="tab">Create Your Own Package</a></li>
    </ul>

    <div class="tab-content">
        <div class="tab-pane active" id="home">
            <div>
                <h2>Get the most relevant candidates auto-matched to your job openings</h2>
                <ul>
                    <li>Get <b>instant access to candidate</b> matching your job requirements. Don't wait for applications</li>
                    <li><b>2-way match:</b> Candidates will be matched not just on profile but also their preferences</li>
                    <li><b>Unlimited access</b> to applications(excel downloads, profile views, resumes).</li>
                    <li>Instant updating of database <b>Reach out to relevant candidates</b> the moment they register</li>
                </ul>
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
            
            </div>
            <div>
                <button>Get Free Demo</button>
            </div>
        </div>
        <div class="tab-pane" id="package">
            <form method="post" action="">
                <input type="text" name="Name" required />
                <input type="email" name="Email" required/>
                <input type="text" name="Mobile" required/>
                <select name="interest">
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
                <input type="submit" class="btn btn-primary" value="submit"/>
            </form>
        </div>
    </div>
@endsection


