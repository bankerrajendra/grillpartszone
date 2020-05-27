@extends('layouts.app')
@section('template_title'){{$metafields['title']}}@endsection
@section('meta_description'){{$metafields['description']}}@endsection
@section('meta_keyword'){{$metafields['keyword']}}@endsection
@section('navclasses')background-black outer-nav  @endsection


@section('template_fastload_css')
    .invalid-feedback {
        display: none;
        width: 100%;
        margin-top: 0.25rem;
        font-size: 80%;
        color: #dc3545;
    }
@endsection

{!! NoCaptcha::renderJs() !!}
@section('content')

    <div class="search-item hidden-md hidden-lg" style="margin-top: 56px;">
        <div class="container">
            <div class="row">
                <div class="col-xs-12">
                    <form>
                        <div class="input-group stylish-input-group">
                            <input type="text" class="form-control" placeholder="Search by Brand, Model or Part Number">
                            <span class="input-group-addon">
							<button type="submit">
								<span class="fa fa-search"></span>
							</button>
						</span>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <div class="search-manual-item hidden-md hidden-lg">
        <div class="container">
            <div class="row">
                <div class="col-sm-12 text-center">
                    <h4>Find Parts For Your Grill</h4>
                    <p>Use our BBQ parts finger to get the perfect match for your BBQ Grill </p>
                </div>
                <div class="col-lg-5 col-md-3 col-sm-12">
                    <label>Brand</label>
                    <select class="form-control search-slt" id="exampleFormControlSelect1">
                        <option>Select Brand</option>
                        <option>Example one</option>
                        <option>Example one</option>
                        <option>Example one</option>
                        <option>Example one</option>
                        <option>Example one</option>
                        <option>Example one</option>
                    </select>
                </div>
                <div class="col-lg-5 col-md-3 col-sm-12">
                    <label>Modal</label>
                    <select class="form-control search-slt" id="exampleFormControlSelect1">
                        <option>Select Modal</option>
                        <option>Example one</option>
                        <option>Example one</option>
                        <option>Example one</option>
                        <option>Example one</option>
                        <option>Example one</option>
                        <option>Example one</option>
                    </select>
                </div>
                <div class="col-lg-2 col-md-3 col-sm-12">
                    <button type="button" class="btn btn-search btn-block">Search</button>
                </div>
            </div>
        </div>
    </div>
    <div class="product-cat product-parts">
        <div class="container">
            <div class="row">
                <div class="col-sm-8 col-sm-offset-2 text-justify">
                    <h3 class="text-center">Contact Us</h3>
                    @if(session('success'))
                        <div class="alert alert-success" role="alert">
                            {{session('success')}}
                        </div>
                    @endif
                    @if ($errors->any())
                        <div class="alert alert-danger">
                            <ul>
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif

                    {!! Form::open(array('route' => 'send-contact', 'method' => 'post', 'role' => 'form', 'class' => 'needs-validation', 'style' => 'display:inline')) !!}

                    <div class="form-group">
                        <label for="name">Order Number</label>
                        <input type="text" name="orderno" id="orderno" class="form-control" value="{{old('orderno')}}"  >
                    </div>

                    <div class="form-group">
                        <label for="name">Name</label>
                        <input type="text" name="name" id="name" class="form-control" value="{{old('name')}}"  >
                    </div>
                    <div class="form-group">
                        <label for="email">Email</label>
                        <input class="form-control" id="email" name="email" type="email" value="{{old('email')}}" >
                    </div>
                    <div class="form-group">
                        <label for="name">Subject</label>
                        <input class="form-control" id="subject" name="subject" type="text" value="{{old('subject')}}" >
                    </div>
                    <div class="form-group">
                        <label for="name">Phone</label>
                        <input class="form-control" id="mobile" name="mobile" maxlength="16" type="text" value="{{old('mobile')}}" >
                    </div>

                    <div class="form-group">
                        <label for="name">Comments or Concerns</label>
                        <textarea class="form-control" id="message" name="message" rows="5"  style="height:auto!important" >{{old('message')}}</textarea>
                    </div>

                    {!! NoCaptcha::display() !!}

                    <br>
                    <button class="btn btn-success" name="submitContact"  type="submit">Submit</button>
                    </form>

                </div>
            </div>
        </div>
    </div>

@endsection
@section('footer_scripts')
    <script type="text/javascript" src="{{ asset('vendor/jsvalidation/js/jsvalidation.js')}}"></script>
    {!! $validator !!}
@endsection
