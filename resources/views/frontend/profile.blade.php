@extends('layouts.frontend')
@section('content')
    {{-- <div class="container">
    <div class="row">
        <div class="col-md-6">
            <div class="card">
                <div class="card-header">
                    {{ trans('global.my_profile') }}
                </div>
                <div class="card-body">
                    <form method="POST" action="{{ route("frontend.profile.update") }}">
                        @csrf
                        <div class="form-group">
                            <label class="required" for="name">{{ trans('cruds.user.fields.name') }}</label>
                            <input class="form-control {{ $errors->has('name') ? 'is-invalid' : '' }}" type="text" name="name" id="name" value="{{ old('name', auth()->user()->name) }}" required>
                            @if ($errors->has('name'))
                                <div class="invalid-feedback">
                                    {{ $errors->first('name') }}
                                </div>
                            @endif
                        </div>
                        <div class="form-group">
                            <label class="required" for="title">{{ trans('cruds.user.fields.email') }}</label>
                            <input class="form-control {{ $errors->has('email') ? 'is-invalid' : '' }}" type="text" name="email" id="email" value="{{ old('email', auth()->user()->email) }}" required>
                            @if ($errors->has('email'))
                                <div class="invalid-feedback">
                                    {{ $errors->first('email') }}
                                </div>
                            @endif
                        </div>
                        <div class="form-group">
                            <button class="btn btn-danger" type="submit">
                                {{ trans('global.save') }}
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
        <div class="col-md-6">
            <div class="card">
                <div class="card-header">
                    {{ trans('global.change_password') }}
                </div>
                <div class="card-body">
                    <form method="POST" action="{{ route("frontend.profile.password") }}">
                        @csrf
                        <div class="form-group {{ $errors->has('password') ? 'has-error' : '' }}">
                            <label class="required" for="password">New {{ trans('cruds.user.fields.password') }}</label>
                            <input class="form-control" type="password" name="password" id="password" required>
                            @if ($errors->has('password'))
                                <span class="help-block" role="alert">{{ $errors->first('password') }}</span>
                            @endif
                        </div>
                        <div class="form-group">
                            <label class="required" for="password_confirmation">Repeat New {{ trans('cruds.user.fields.password') }}</label>
                            <input class="form-control" type="password" name="password_confirmation" id="password_confirmation" required>
                        </div>
                        <div class="form-group">
                            <button class="btn btn-danger" type="submit">
                                {{ trans('global.save') }}
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <div class="row mt-4">
        <div class="col-md-6">
            <div class="card">
                <div class="card-header">
                    {{ trans('global.delete_account') }}
                </div>
                <div class="card-body">
                    <form method="POST" action="{{ route("frontend.profile.destroy") }}" onsubmit="return prompt('{{ __('global.delete_account_warning') }}') == '{{ auth()->user()->email }}'">
                        @csrf
                        <div class="form-group">
                            <button class="btn btn-danger" type="submit">
                                {{ trans('global.delete') }}
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
        @if (Route::has('frontend.profile.toggle-two-factor'))
            <div class="col-md-6">
                <div class="card">
                    <div class="card-header">
                        {{ trans('global.two_factor.title') }}
                    </div>

                    <div class="card-body">
                        <form method="POST" action="{{ route("frontend.profile.toggle-two-factor") }}">
                            @csrf
                            <div class="form-group">
                                <button class="btn btn-danger" type="submit">
                                    {{ auth()->user()->two_factor ? trans('global.two_factor.disable') : trans('global.two_factor.enable') }}
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        @endif
    </div>
</div> --}}
        @if (session('success'))
            <div class="container">
                <div class="alert alert-success alert-dismissible fade show">
                    <div class="d-flex align-items-center">
                        <div><strong>{{ session('success') }}</strong></div>
                        <div class="mt-0">
                            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                        </div>
                    </div>
                </div>
            </div>
        @endif
        <div class="container mt-4">
            <div class="card">
                <div class="card-body">
                    <h2 class="card-title">Profile</h2>
                    <form id="profileForm" method="POST" action="{{ route('profile.update') }}">
                        @csrf
                        <input type="hidden" name="user_id" value="{{ $user->id }}">
                        <div class="mb-3">
                            <label for="name" class="form-label">Name:</label>
                            <input type="text" class="form-control" id="name" name="name"
                                value="{{ $user->name }}" readonly>
                        </div>
                        <div class="mb-3">
                            <label for="email" class="form-label">Email:</label>
                            <input type="email" class="form-control" id="email" name="email"
                                value="{{ $user->email }}" readonly>
                        </div>

                        <button class="btn btn-success mt-2" id="modifyButton" type="button">
                            Modify
                        </button>
                        <button class="btn btn-primary mt-2" id="saveButton" type="submit" style="display: none;">
                            Save
                        </button>
                    </form>
                </div>
            </div>

            <div class="card">
                <div class="card-body">
                    <h2 class="card-title">Courses Progress</h2>
                    @forelse ($coursesprogression as $progression)
                        <div class="card m-0">
                            <div class="d-flex justify-content-between">
                                <div class="m-3">
                                    <p class="fw-bold mb-0">{{ $progression->cour_id }}</p>
                                    @if ($progression->est_complete)
                                        <small class="mt-0">Completed</small>
                                    @else
                                        <small class="mt-0">In Progress</small>
                                    @endif
                                </div>
                                <div class="align-self-center me-3">
                                    <div class="btn-group dropleft">
                                        <a class="text-decoration-none" id="dropdownMenuButton" data-toggle="dropdown"
                                            aria-haspopup="true" aria-expanded="false">
                                            <i class="fas fa-ellipsis-v"></i>
                                        </a>
                                        <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                                            <a class="dropdown-item" href="#">Visit Course</a>
                                            <a class="dropdown-item" href="#">Delete Course</a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @empty
                        <p class="fw-bold my-2">You did not enroll any course yet</p>
                    @endforelse
                </div>
            </div>
        </div>
    <script>
        let modifyButton = document.getElementById('modifyButton');
        let saveButton = document.getElementById('saveButton');
        let form = document.getElementById('profileForm');

        modifyButton.addEventListener('click', () => {
            let inputs = document.getElementsByTagName("input");
            for (let i = 0; i < inputs.length; i++) {
                let input = inputs[i];
                // Toggle the readonly property
                input.readOnly = !input.readOnly;
            }

            modifyButton.style.display = 'none';
            saveButton.style.display = 'block';
        });

        form.addEventListener('submit', (event) => {
            // Prevent the form from submitting normally
            event.preventDefault();

            // Submit the form
            form.submit();
        });
    </script>
@endsection
