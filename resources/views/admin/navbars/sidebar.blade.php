@if (in_array(config('app.locale'),['ar','he','fa','ur']))
    <nav class="navbar navbar-vertical fixed-right navbar-expand-md navbar-light bg-white" id="sidenav-main">
@else
    <nav class="navbar navbar-vertical fixed-left navbar-expand-md navbar-light bg-white" id="sidenav-main">
@endif

    <div class="container-fluid">
        <!-- Toggler -->
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#sidenav-collapse-main" aria-controls="sidenav-main" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <!-- Brand -->
        <a class="navbar-brand pt-0" >
            <!-- <img src="{{ config('settings.logo') }}" class="navbar-brand-img" alt="...">   --> 
            @php
                $user = auth()->user();
                if ($user->hasRole('admin') && empty($user->company)) {
                    $logo = env('LOGO_URL', '/uploads/settings/logo.jpg');
                } elseif (!empty($user->company)) {
                    $logo = env('LOGO_URL' . $user->company->id, env('LOGO_URL', '/uploads/settings/logo.jpg'));
                } else {
                    $logo = env('LOGO_URL', '/uploads/settings/logo.jpg');
                }
            @endphp

                <img src="{{ $logo }}"  class="navbar-brand-img" alt="...">
 

        </a>
        <!-- User -->
        <ul class="nav align-items-center d-md-none">
            <li class="nav-item dropdown">
                <a class="nav-link" href="#" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                    {{-- <div class="media align-items-center">
                        <span class="avatar avatar-sm rounded-circle">
                            
                            
                            <img alt="..." src="{{'https://www.gravatar.com/avatar/'.md5(auth()->user()->email) }}">
                        </span>
                    </div> --}}

                    <div class="media align-items-center">
                          <!-- Avatar con iniciales -->
                          <div class="avatar-circle">
                              <span class="avatar-initials">
                                  {{ strtoupper(substr(auth()->user()->name, 0, 1)) }}{{ strtoupper(substr(explode(' ', auth()->user()->name)[1] ?? '', 0, 1)) }}
                              </span>
                          </div>
                          
                         
                      </div>


                </a>
                <div class="dropdown-menu dropdown-menu-arrow dropdown-menu-right">
                    <div class=" dropdown-header noti-title">
                        <h6 class="text-overflow m-0">{{ __('Bienvenido') }}</h6>
                    </div>

                    @if (auth()->user()->hasRole('owner'))
                        <a href="{{ route('profile.show') }}" class="dropdown-item">
                            <i class="ni ni-single-02"></i>
                            <span>{{ __('Mi Perfil') }}</span>
                        </a>
                    @endif

                    @if (config('settings.app_code_name','')=="wpbox"&&auth()->user()->hasRole('owner'))
                      <a href="{{ route('whatsapp.setup') }}" class="dropdown-item">
                          <i class="ni ni-support-16"></i>
                          <span>{{ __('Whatsapp Cloud API Setup') }}</span>
                      </a>
                  @endif    
                    <div class="dropdown-divider"></div>
                    <a href="{{ route('logout') }}" class="dropdown-item" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                        <i class="ni ni-user-run"></i>
                        <span>{{ __('Logout') }}</span>
                    </a>
                </div>
            </li>
        </ul>
        <!-- Collapse -->
        <div class="collapse navbar-collapse" id="sidenav-collapse-main">
            <!-- Collapse header -->
            <div class="navbar-collapse-header d-md-none">
                <div class="row">
                    <div class="col-6 collapse-brand">

                              @php
                                    $user = auth()->user();
                                    if ($user->hasRole('admin') && empty($user->company)) {
                                        $logo = env('LOGO_URL', '/uploads/settings/logo.jpg');
                                    } elseif (!empty($user->company)) {
                                        $logo = env('LOGO_URL' . $user->company->id, env('LOGO_URL', '/uploads/settings/logo.jpg'));
                                    } else {
                                        $logo = env('LOGO_URL', '/uploads/settings/logo.jpg');
                                    }
                                @endphp

                         
                           <img src="{{ $logo }}"  class="navbar-brand-img" alt="...">
                       
                            
                       


                    </div>
                    <div class="col-6 collapse-close">
                        <button type="button" class="navbar-toggler" data-toggle="collapse" data-target="#sidenav-collapse-main" aria-controls="sidenav-main" aria-expanded="false" aria-label="Toggle sidenav">
                            <span></span>
                            <span></span>
                        </button>
                    </div>
                </div>
            </div>
            <!-- Navigation -->
            @if(Auth::user()->isImpersonating())
                <hr class="my-3">
                <ul class="navbar-nav ">
                    <li class="nav-item">
                      <a class="nav-link active active-pro" href="{{ route('admin.companies.stopImpersonate') }}">
                        <i class="ni ni-button-power text-red"></i>
                        <span class="nav-link-text">{{ __('Back to your account')}}</span>
                      </a>
                    </li>
                  </ul>
                <hr class="my-3">
            @endif
            @if(auth()->user()->hasRole('admin'))
                @include('admin.navbars.menus.admin')
            @else
                <span></span>
            @endif



            @if(auth()->user()->hasRole('owner'))
                @include('admin.navbars.menus.owner')
            @else
                <span></span>
            @endif

            @if(auth()->user()->hasRole('staff'))
                @include('admin.navbars.menus.staff')
            @else
                <span></span>
            @endif

            @if(auth()->user()->hasRole('client'))
                @include('admin.navbars.menus.client')
            @else
                <span></span>
            @endif

           

            <!-- Divider -->
            <hr class="my-3">
            <!-- Heading -->
            @if(auth()->user()->hasRole('admin'))
            <h6 class="navbar-heading text-muted">{{ __('Version')}} {{ config('version.version')}}   <span id="uptodate" class="badge badge-success" style="display:none;">{{ __('latest') }}</span></h6>
                <h6>{{ \Carbon\Carbon::now() }} </h6>
                
                <hr class="my-3">
                <div id="update_notification" style="display:none;" class="alert alert-info">
                    <button type="button" style="margin-left: 20px" class="close" data-dismiss="alert" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div> 
                <div id="uptodate_notification" style="display:none;" class="alert alert-success">
                    <button type="button" style="margin-left: 20px" class="close" data-dismiss="alert" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div> 
                
            @endif
            
        </div>
    </div>
</nav>
