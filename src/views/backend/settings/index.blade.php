@extends('chuckcms::backend.layouts.admin')

@section('title')
	Instellingen
@endsection

@section('content')
<!-- START CONTAINER FLUID -->
<div class=" container-fluid   container-fixed-lg">

<!-- START card -->
<form action="{{ route('dashboard.settings.save') }}" method="POST">
<div class="card card-transparent">
  <div class="card-header ">
    <div class="card-title">Pas instellingen aan
    </div>
  </div>
  <div class="card-block">
    <div class="row">
      <div class="col-md-12">
		{{-- <h5>Fade effect</h5> Add the class
        <code>fade</code> to the tab panes
        <br>
        <br> --}}
        @if ($errors->any())
          <div class="alert alert-danger">
              <ul>
                  @foreach ($errors->all() as $error)
                      <li>{{ $error }}</li>
                  @endforeach
              </ul>
          </div>
        @endif
        <div class="card card-transparent">
          <!-- Nav tabs -->
          <ul class="nav nav-tabs nav-tabs-linetriangle" data-init-reponsive-tabs="dropdownfx">
            <li class="nav-item">
              <a href="#" class="active" data-toggle="tab" data-target="#site_setup"><span>Site</span></a>
            </li>
            <li class="nav-item">
              <a href="#" data-toggle="tab" data-target="#social_setup"><span>Social Media</span></a>
            </li>
            <li class="nav-item">
              <a href="#" data-toggle="tab" data-target="#integrations_setup"><span>Integraties</span></a>
            </li>
            <li class="nav-item">
              <a href="#" data-toggle="tab" data-target="#logo_setup"><span>Logo</span></a>
            </li>
            <li class="nav-item">
              <a href="#" data-toggle="tab" data-target="#lang_setup"><span>Talen</span></a>
            </li>
          </ul>
          <!-- Tab panes -->
          <div class="tab-content">
            <div class="tab-pane fade show active" id="site_setup">
              <div class="row column-seperation">
                <div class="col-lg-12">
                      <div class="form-group form-group-default required ">
                        <label>Naam</label>
                        <input type="text" class="form-control" placeholder="Naam" name="site_name" value="{{ $site->name }}" required>
                      </div>
                      <div class="form-group form-group-default required ">
                        <label>Slug</label>
                        <input type="text" class="form-control" placeholder="slug" name="site_slug" value="{{ $site->slug }}" required>
                      </div>
                      <div class="form-group form-group-default required ">
                        <label>Domein</label>
                        <input type="text" class="form-control" placeholder="http://domain.com" name="site_domain" value="{{ $site->domain }}" required>
                      </div>
                </div>
              </div>
            </div>

            <div class="tab-pane fade" id="social_setup">
              <div class="row">
                <div class="col-lg-12">
                      <div class="form-group form-group-default ">
                        <label>Facebook</label>
                        <input type="text" class="form-control" placeholder="Facebook" name="socialmedia[facebook]" value="{{ $site->settings['socialmedia']['facebook'] }}">
                      </div>
                      <div class="form-group form-group-default ">
                        <label>Twitter</label>
                        <input type="text" class="form-control" placeholder="Twitter" name="socialmedia[twitter]" value="{{ $site->settings['socialmedia']['twitter'] }}">
                      </div>
                      <div class="form-group form-group-default ">
                        <label>Pinterest</label>
                        <input type="text" class="form-control" placeholder="Pinterest" name="socialmedia[pinterest]" value="{{ $site->settings['socialmedia']['pinterest'] }}">
                      </div>
                      <div class="form-group form-group-default ">
                        <label>Instagram</label>
                        <input type="text" class="form-control" placeholder="Instagram" name="socialmedia[instagram]" value="{{ $site->settings['socialmedia']['instagram'] }}">
                      </div>
                      <div class="form-group form-group-default ">
                        <label>Snapchat</label>
                        <input type="text" class="form-control" placeholder="Snapchat" name="socialmedia[snapchat]" value="{{ $site->settings['socialmedia']['snapchat'] }}">
                      </div>
                      <div class="form-group form-group-default ">
                        <label>Google Plus</label>
                        <input type="text" class="form-control" placeholder="Google Plus" name="socialmedia[googleplus]" value="{{ $site->settings['socialmedia']['googleplus'] }}">
                      </div>
                      <div class="form-group form-group-default ">
                        <label>Tumblr</label>
                        <input type="text" class="form-control" placeholder="Tumblr" name="socialmedia[tumblr]" value="{{ $site->settings['socialmedia']['tumblr'] }}">
                      </div>
                      <div class="form-group form-group-default ">
                        <label>YouTube</label>
                        <input type="text" class="form-control" placeholder="YouTube" name="socialmedia[youtube]" value="{{ $site->settings['socialmedia']['youtube'] }}">
                      </div>
                      <div class="form-group form-group-default ">
                        <label>Vimeo</label>
                        <input type="text" class="form-control" placeholder="Vimeo" name="socialmedia[vimeo]" value="{{ $site->settings['socialmedia']['vimeo'] }}">
                      </div>
                </div>
              </div>
            </div>

            <div class="tab-pane fade" id="logo_setup">
              <div class="row">
                <div class="col-lg-12">
                      <div class="form-group form-group-default ">
                        <label>Logo</label>
                        <div class="input-group">
                          <span class="input-group-btn">
                            <a id="lfm" data-input="thumbnail" data-preview="logoholder" class="btn btn-primary" style="color:#FFF">
                              <i class="fa fa-picture-o"></i> Kies
                            </a>
                          </span>
                          <input id="thumbnail" class="form-control" accept="image/x-png" type="text" name="logo[href]" value="{{ $site->settings['logo']['href'] }}">
                        </div>
                        <img id="logoholder" src="{{ URL::to('/') }}{{ $site->settings['logo']['href'] }}" style="margin-top:15px;max-height:100px;">
                      </div>
                </div>
              </div>
            </div>

            <div class="tab-pane fade" id="integrations_setup">
              <div class="row">
                <div class="col-lg-12">
                      <div class="form-group form-group-default ">
                        <label>Google Analytics ID</label>
                        <input type="text" class="form-control" placeholder="eg UA-01234567" name="integrations[ga-id]" value="{{ $site->settings['integrations']['ga-id'] }}">
                      </div>
                      <div class="form-group form-group-default ">
                        <label>Google Site Verification</label>
                        <input type="text" class="form-control" placeholder="Google Site Verification" name="integrations[g-site-verification]" value="{{ $site->settings['integrations']['g-site-verification'] }}">
                      </div>
                </div>
              </div>
            </div>

            <div class="tab-pane fade" id="lang_setup">
              <div class="row">
                <div class="col-lg-12">
                      <div class="form-group form-group-default form-group-default-select2">
                        <label>Website is beschikbaar in</label>
                        <select class="full-width" data-init-plugin="select2" multiple name="lang[]">
                          @foreach(config('lang.allLocales') as $langKey => $langValue)
                            <option value="{{$langKey}}" @if( array_key_exists($langKey, config('laravellocalization.supportedLocales')) ) selected @endif>{{ $langValue['native'] }}</option>
                          @endforeach
                        </select>
                      </div>
                </div>
              </div>
            </div>
          </div>
          <br>
          <p class="pull-right">
            <input type="hidden" name="site_id" value="{{ $site->id }}">
            <input type="hidden" name="_token" value="{{ Session::token() }}">
            <button type="submit"class="btn btn-success btn-cons pull-right">Opslaan</button>
          </p>
        </div>
      </div>
    </div>
  </div>
</div>
<!-- END card -->
</form>
</div>
<!-- END CONTAINER FLUID -->


@endsection

@section('css')
	
@endsection

@section('scripts')
  <script src="{{ URL::to('vendor/laravel-filemanager/js/lfm.js') }}"></script>
	<script>
		$( document ).ready(function() { 
			
      init();

      function init () {
        //init media manager inputs 
        var domain = "{{ URL::to('dashboard/media')}}";
        $('#lfm').filemanager('image', {prefix: domain});
      }

		});
	</script>
  @if (session('notification'))
      @include('chuckcms::backend.includes.notification')
  @endif
@endsection