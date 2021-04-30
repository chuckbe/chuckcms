@extends('chuckcms::backend.layouts.base')

@section('title')
	Instellingen
@endsection

@section('content')
<div class="container p-3 min-height">
  <div class="row">
    <div class="col-sm-12">
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb mt-3">
                <li class="breadcrumb-item active" aria-current="instellingen">Pas instellingen aan</li>
            </ol>
        </nav>
    </div>
  </div>
  @if ($errors->any())
    <div class="row bg-light shadow-sm rounded p-3 mb-3 mx-1">
      <div class="col">
        <div class="my-3">
          <div class="alert alert-danger">
            <ul>
              @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
              @endforeach
            </ul>
          </div>
        </div>
      </div>
    </div>
  @endif
  <div class="row">
    <div class="col">
      <div class="my-3">
        <ul class="nav nav-tabs justify-content-start" id="instellingenTab" role="tablist">
          <li class="nav-item" role="presentation">
            <a class="nav-link active" id="company_setup-tab" data-target="#tab_resource_company_setup" data-toggle="tab" href="#" role="tab" aria-controls="#company_setup" aria-selected="true">Bedrijf</a>
          </li>
          <li class="nav-item" role="presentation">
            <a class="nav-link" id="site_setup-tab" data-target="#tab_resource_site_setup" data-toggle="tab" href="#" role="tab" aria-controls="#site_setup" aria-selected="false">Site</a>
          </li>
          <li class="nav-item" role="presentation">
            <a class="nav-link" id="social_setup-tab" data-target="#tab_resource_social_setup" data-toggle="tab" href="#" role="tab" aria-controls="#social_setup" aria-selected="false">Social Media</a>
          </li>
          <li class="nav-item" role="presentation">
            <a class="nav-link" id="integrations_setup-tab" data-target="#tab_resource_integrations_setup" data-toggle="tab" href="#" role="tab" aria-controls="#integrations_setup" aria-selected="false">Integraties</a> 
          </li>
          <li class="nav-item" role="presentation">
            <a class="nav-link" id="logo_setup-tab" data-target="#tab_resource_logo_setup" data-toggle="tab" href="#" role="tab" aria-controls="#logo_setup" aria-selected="false">Logo & Favicon</a> 
          </li>
          <li class="nav-item" role="presentation">
            <a class="nav-link" id="lang_setup-tab" data-target="#tab_resource_lang_setup" data-toggle="tab" href="#" role="tab" aria-controls="#lang_setup" aria-selected="false">Talen</a> 
          </li>
        </ul>
      </div>
    </div>
  </div>
  <form action="{{ route('dashboard.settings.save') }}" method="POST">
    <div class="row tab-content bg-light shadow-sm rounded p-3 mb-3 mx-1" id="instellingenTabContent">
      {{-- Bedrijf-tab-starts --}}
      <div class="col-sm-12 tab-pane fade show active" id="tab_resource_company_setup" role="tabpanel" aria-labelledby="company_setup-tab">
        <div class="row column-seperation">
          <div class="col">
            <div class="form-group form-group-default required ">
              <label>Bedrijfsnaam *</label>
              <input type="text" class="form-control" placeholder="Bedrijfsnaam" name="company[name]" value="{{ array_key_exists('company', $site->settings) ? $site->settings['company']['name'] : '' }}" required>
            </div>
          </div>
          <div class="col">
            <div class="form-group form-group-default required ">
              <label>BTW-nummer *</label>
              <input type="text" class="form-control" placeholder="BTW-nummer" name="company[vat]" value="{{ array_key_exists('company', $site->settings) ? $site->settings['company']['vat'] : '' }}" required>
            </div>
          </div>
        </div>
        <div class="row column-seperation">
          <div class="col-8">
            <div class="form-group form-group-default required ">
              <label>Straat *</label>
              <input type="text" class="form-control" placeholder="Straat" name="company[street]" value="{{ array_key_exists('company', $site->settings) ? $site->settings['company']['street'] : '' }}" required>
            </div>
          </div>
          <div class="col-4">
            <div class="form-group form-group-default required ">
              <label>Huisn° *</label>
              <input type="text" class="form-control" placeholder="Huisn°" name="company[housenumber]" value="{{ array_key_exists('company', $site->settings) ? $site->settings['company']['housenumber'] : '' }}" required>
            </div>
          </div>
        </div>
        <div class="row column-seperation">
          <div class="col-5">
            <div class="form-group form-group-default required ">
              <label>Postcode *</label>
              <input type="text" class="form-control" placeholder="Postcode" name="company[postalcode]" value="{{ array_key_exists('company', $site->settings) ? $site->settings['company']['postalcode'] : '' }}" required>
            </div>
          </div>
          <div class="col-7">
            <div class="form-group form-group-default required ">
              <label>Gemeente *</label>
              <input type="text" class="form-control" placeholder="Gemeente" name="company[city]" value="{{ array_key_exists('company', $site->settings) ? $site->settings['company']['city'] : '' }}" required>
            </div>
          </div>
        </div>
        <div class="row column-seperation">
          <div class="col">
            <div class="form-group form-group-default required ">
              <label>E-mailadres *</label>
              <input type="email" class="form-control" placeholder="E-mailadres" name="company[email]" value="{{ array_key_exists('company', $site->settings) ? $site->settings['company']['email'] : '' }}" required>
            </div>
          </div>
          <div class="col">
            <div class="form-group form-group-default required ">
              <label>Telefoonnummer *</label>
              <input type="text" class="form-control" placeholder="Telefoonnummer" name="company[tel]" value="{{ array_key_exists('company', $site->settings) ? $site->settings['company']['tel'] : '' }}" required>
            </div>
          </div>
        </div>
      </div>{{-- Bedrijf-tab-ends --}}
      {{-- site tab starts --}}
      <div class="col-sm-12 tab-pane fade" id="tab_resource_site_setup" role="tabpanel" aria-labelledby="site_setup-tab">
        <div class="row column-seperation">
          <div class="col">
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
      </div>{{-- site tab ends --}}
      {{-- social tab starts --}}
      <div class="col-sm-12 tab-pane fade" id="tab_resource_social_setup" role="tabpanel" aria-labelledby="social_setup-tab">
        <div class="row column-seperation">
          <div class="col">
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
      </div>{{-- social tab ends --}}
      {{-- integrations tab starts --}}
      <div class="col-sm-12 tab-pane fade" id="tab_resource_integrations_setup" role="tabpanel" aria-labelledby="integrations_setup-tab">
        <div class="row column-seperation">
          <div class="col-lg-12">
            <div class="form-group form-group-default ">
              <label>Google Analytics ID</label>
              <input type="text" class="form-control" placeholder="eg UA-01234567" name="integrations[ga-id]" value="{{ $site->settings['integrations']['ga-id'] }}">
            </div>
            <div class="form-group form-group-default ">
              <label>Google Site Verification</label>
              <input type="text" class="form-control" placeholder="Google Site Verification" name="integrations[g-site-verification]" value="{{ $site->settings['integrations']['g-site-verification'] }}">
            </div>
            {{--  to add matomo  --}}
            <div class="form-group form-group-default ">
              <label>Matomo Site ID</label>
              <input type="text" class="form-control" placeholder="Matomo Site Id" name="integrations[matomo-site-id]" value="{{ array_key_exists('matomo-site-id', $site->settings['integrations']) ? $site->settings['integrations']['matomo-site-id'] : null }}">
            </div>
            <div class="form-group form-group-default ">
              <label>Matomo Auth Key</label>
              <input type="text" class="form-control" placeholder="Matomo Auth Token" name="integrations[matomo-auth-key]" value="{{ array_key_exists('matomo-auth-key', $site->settings['integrations']) ? $site->settings['integrations']['matomo-auth-key'] : null }}">
            </div>
          </div>
        </div>
      </div>{{-- integrations tab ends --}}
      {{-- logo tab starts --}}
      <div class="col-sm-12 tab-pane fade" id="tab_resource_logo_setup" role="tabpanel" aria-labelledby="logo_setup-tab">
        <div class="row column-seperation">
          <div class="col">
            <div class="form-group form-group-default ">
              <label>Favicon</label>
              <div class="input-group">
                <span class="input-group-btn">
                  <a id="lfmFavi" data-input="thumbnailFavicon" data-preview="faviholder" class="btn btn-primary" style="color:#FFF">
                    <i class="fa fa-picture-o"></i> Kies
                  </a>
                </span>
                <input id="thumbnailFavicon" class="form-control" accept="image/x-png" type="text" name="favicon[href]" value="{{ array_key_exists('favicon', $site->settings) ? $site->settings['favicon']['href'] : '/chuckbe/chuckcms/favicon.ico' }}">
              </div>
              <img id="faviholder" src="{{ URL::to('/') }}{{ array_key_exists('favicon', $site->settings) ? $site->settings['favicon']['href'] : '/chuckbe/chuckcms/favicon.ico' }}" style="margin-top:15px;max-height:100px;">
            </div>
          </div>
        </div>
        <div class="row column-seperation">
          <div class="col">
            <div class="form-group form-group-default ">
              <label>Logo</label>
              <div class="input-group">
                <span class="input-group-btn">
                  <a id="lfmLogo" data-input="thumbnailLogo" data-preview="logoholder" class="btn btn-primary" style="color:#FFF">
                    <i class="fa fa-picture-o"></i> Kies
                  </a>
                </span>
                <input id="thumbnailLogo" class="form-control" accept="image/x-png" type="text" name="logo[href]" value="{{ array_key_exists('logo', $site->settings) ? $site->settings['logo']['href'] : '/chuckbe/chuckcms/chuckcms-logo.png' }}">
              </div>
              <img id="logoholder" src="{{ URL::to('/') }}{{ array_key_exists('logo', $site->settings) ? $site->settings['logo']['href'] : '/chuckbe/chuckcms/chuckcms-logo.png' }}" style="margin-top:15px;max-height:100px;">
            </div>
          </div>
        </div>
      </div>{{-- logo tab ends --}}
      {{-- lang tab starts --}}
      <div class="col-sm-12 tab-pane fade" id="tab_resource_lang_setup" role="tabpanel" aria-labelledby="lang_setup-tab">
        <div class="row column-seperation">
          <div class="col">
            <div class="form-group form-group-default form-group-default-select2">
              <label>Website is beschikbaar in</label>
              <br>
              <select style="width: 100%" class="full-width mt-1 selectjs" data-init-plugin="select2" multiple name="lang[]">
                @foreach(config('lang.allLocales') as $langKey => $langValue)
                  <option value="{{$langKey}}" @if( array_key_exists($langKey, config('laravellocalization.supportedLocales')) ) selected @endif>{{ $langValue['native'] }}</option>
                @endforeach
              </select>
            </div>
          </div>
        </div>
      </div>{{-- lang tab ends --}}
    </div>
    <div class="row">
      <div class="col">
        <p class="pull-right">
          <input type="hidden" name="site_id" value="{{ $site->id }}">
          <input type="hidden" name="_token" value="{{ Session::token() }}">
          <button type="submit"class="btn btn-success btn-cons pull-right m-1">Opslaan</button>
        </p>
      </div>
    </div>
  </form>
</div>

@endsection

@section('css')
	
@endsection

@section('scripts')
  <script src="{{ URL::to('/vendor/laravel-filemanager/js/lfm.js') }}"></script>
	<script>
		$( document ).ready(function() { 
      init();
      function init () {
        //init media manager inputs 
        var domain = "{{ URL::to('dashboard/media')}}";
        $('#lfmFavi').filemanager('image', {prefix: domain});
        $('#lfmLogo').filemanager('image', {prefix: domain});
      }

      $(".selectjs").select2();
		});
	</script>
  @if (session('notification'))
      @include('chuckcms::backend.includes.notification')
  @endif
@endsection