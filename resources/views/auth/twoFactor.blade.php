@extends('layouts.app')
@section('content')
<div class="row justify-content-center">
    <div class="col-md-9">
        <div class="card-group">
            <div class="card p-4">
                <div class="card-body">
                    @if(session()->has('message'))
                        <p class="alert alert-info">
                            {{ session()->get('message') }}
                        </p>
                    @endif
                    <form method="POST" action="{{ route('twoFactor.check') }}">
                        @csrf
                        <h1>{{ __('global.two_factor.title') }}</h1>
                        <p class="text-muted">
                            {{ __('global.two_factor.sub_title', ['minutes' => 15]) }}
                        </p>

                        <div class="input-group mb-3">
                            <div class="input-group-prepend">
                                <span class="input-group-text">
                                    <i class="fa fa-lock"></i>
                                </span>
                            </div>
                            <input name="two_factor_code" type="text" class="form-control{{ $errors->has('two_factor_code') ? ' is-invalid' : '' }}" required autofocus placeholder="{{ trans('global.two_factor.code') }}">
                            @if($errors->has('two_factor_code'))
                                <div class="invalid-feedback">
                                    {{ $errors->first('two_factor_code') }}
                                </div>
                            @endif
                        </div>

                        <div class="row">
                            <div class="col-6">
                                <button type="submit" class="btn btn-primary px-4">
                                    {{ trans('global.two_factor.verify') }}
                                </button>
                            </div>
                            <div class="col-6 text-right">
                                <a class="btn btn-secondary px-4" href="{{ route('twoFactor.resend') }}">{{ __('global.two_factor.resend') }}</a>
                                <a class="btn btn-danger px-4" href="#" onclick="event.preventDefault(); document.getElementById('logoutform').submit();">
                                    {{ trans('global.logout') }}
                                </a>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<form id="logoutform" action="{{ route('logout') }}" method="POST" style="display: none;">
    {{ csrf_field() }}
</form>
@endsection