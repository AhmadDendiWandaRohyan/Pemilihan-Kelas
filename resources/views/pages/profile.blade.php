@extends('layout.main')

@push('script')
    <script>
        $('input#accountActivation').on('change', function() {
            $('button.deactivate-account').attr('disabled', !$(this).is(':checked'));
        });

        document.addEventListener('DOMContentLoaded', function(e) {
            (function() {
                // Update/reset user image of account page
                let accountUserImage = document.getElementById('uploadedAvatar');
                const fileInput = document.querySelector('.account-file-input'),
                    resetFileInput = document.querySelector('.account-image-reset');

                if (accountUserImage) {
                    const resetImage = accountUserImage.src;
                    fileInput.onchange = () => {
                        if (fileInput.files[0]) {
                            accountUserImage.src = window.URL.createObjectURL(fileInput.files[0]);
                        }
                    };
                    resetFileInput.onclick = () => {
                        fileInput.value = '';
                        accountUserImage.src = resetImage;
                    };
                }
            })();
        });
    </script>
@endpush

@section('content')
    <x-breadcrumb :values="[__('navbar.profile.profile')]">
    </x-breadcrumb>

    <div class="row">
        <div class="col">
            {{-- Tab --}}
            @if (auth()->user()->role == 'admin')
                <ul class="nav nav-pills flex-column flex-md-row mb-3">
                    <li class="nav-item">
                        <a class="nav-link active" href="javascript:void(0);">{{ __('navbar.profile.profile') }}</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('settings.show') }}">{{ __('navbar.profile.settings') }}</a>
                    </li>
                </ul>
            @endif

            <div class="card mb-4">
                <form action="{{ route('profile.update') }}" method="post" enctype="multipart/form-data">
                    @csrf
                    @method('PUT')
                    <!-- Account -->
                    <div class="card-body">
                        <div class="d-flex align-items-start align-items-sm-center gap-4">
                            <img src="{{ $data->profile_picture }}" alt="user-avatar" class="d-block rounded" height="100"
                                width="100" id="uploadedAvatar">
                            <div class="button-wrapper">
                                <label for="upload" class="btn btn-primary me-2 mb-4" tabindex="0">
                                    <span class="d-none d-sm-block">{{ __('menu.general.upload') }}</span>
                                    <i class="bx bx-upload d-block d-sm-none"></i>
                                    <input type="file" name="profile_picture" id="upload" class="account-file-input"
                                        hidden="" accept="image/png, image/jpeg">
                                </label>
                                <button type="button" class="btn btn-outline-secondary account-image-reset mb-4">
                                    <i class="bx bx-reset d-block d-sm-none"></i>
                                    <span class="d-none d-sm-block">{{ __('menu.general.cancel') }}</span>
                                </button>

                                <p class="text-muted mb-0">
                                    < 800K (JPG, GIF, PNG)</p>
                            </div>
                        </div>
                    </div>
                    <hr class="my-0">
                    <div class="card-body">
                        <div class="row">
                            <input type="hidden" name="id" value="{{ $data->id }}">
                            <div class="col-md-6 col-lg-12">
                                {{-- <x-input-form name="name" :label="__('model.user.name')" :value="$data->name" /> --}}
                                <div class="mb-3">
                                    <label for="name" class="form-label">{{ __('model.user.name') }}</label>
                                    <input type="text" class="form-control @error('name') is-invalid @enderror"
                                        id="name" name="name" value="{{ old('name', $data->name) }}" />
                                    <span class="error invalid-feedback">{{ $errors->first('name') }}</span>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="nisn" class="form-label">{{ __('model.user.nisn') }}</label>
                                    <input type="text" class="form-control @error('nisn') is-invalid @enderror"
                                        id="nisn" name="nisn" value="{{ old('nisn', $data->nisn) }}" />
                                    <span class="error invalid-feedback">{{ $errors->first('nisn') }}</span>
                                </div>
                            </div>
                            @if (auth()->user()->role == 'siswa')
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label for="religion" class="form-label">{{ __('model.user.religion') }}</label>
                                        <select name="religion" class="form-select"
                                            aria-label="{{ __('model.user.religion') }}">
                                            <option value="{{ old('religion', $data->religion) }}" selected>
                                                {{ old('religion', $data->religion) }}</option>
                                            <option value="Islam">Islam</option>
                                            <option value="Kristen">Kristen</option>
                                            <option value="Katolik">Katolik</option>
                                            <option value="Hindu">Hindu</option>
                                            <option value="Buddha">Buddha </option>
                                            <option value="Khonghucu">Khonghucu</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label for="class" class="form-label">{{ __('model.user.class') }}</label>
                                        <input type="text" class="form-control @error('class') is-invalid @enderror"
                                            id="class" name="class" value="{{ old('class', $data->class) }}" />
                                        <span class="error invalid-feedback">{{ $errors->first('class') }}</span>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label for="school_year"
                                            class="form-label">{{ __('model.user.school_year') }}</label>
                                        <input type="text"
                                            class="form-control @error('school_year') is-invalid @enderror" id="school_year"
                                            name="school_year" value="{{ old('school_year', $data->school_year) }}" />
                                        <span class="error invalid-feedback">{{ $errors->first('school_year') }}</span>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label for="nilai_ips"
                                            class="form-label">{{ __('model.user.nilai_ips') }}</label>
                                        <input type="text"
                                            class="form-control @error('nilai_ips') is-invalid @enderror" id="nilai_ips"
                                            name="nilai_ips" value="{{ old('nilai_ips', $data->nilai_ips) }}" />
                                        <span class="error invalid-feedback">{{ $errors->first('nilai_ips') }}</span>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label for="nilai_ipa"
                                            class="form-label">{{ __('model.user.nilai_ipa') }}</label>
                                        <input type="text"
                                            class="form-control @error('nilai_ipa') is-invalid @enderror" id="nilai_ipa"
                                            name="nilai_ipa" value="{{ old('nilai_ipa', $data->nilai_ipa) }}" />
                                        <span class="error invalid-feedback">{{ $errors->first('nilai_ipa') }}</span>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="mb-3">
                                        <label for="place_of_birth"
                                            class="form-label">{{ __('model.user.place_of_birth') }}</label>
                                        <input type="text"
                                            class="form-control @error('place_of_birth') is-invalid @enderror"
                                            id="place_of_birth" name="place_of_birth"
                                            value="{{ old('place_of_birth', $data->place_of_birth) }}" />
                                        <span class="error invalid-feedback">{{ $errors->first('place_of_birth') }}</span>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="mb-3">
                                        <label for="date_of_birth"
                                            class="form-label">{{ __('model.user.date_of_birth') }}</label>
                                        <input type="date"
                                            class="form-control @error('date_of_birth') is-invalid @enderror"
                                            id="date_of_birth" name="date_of_birth"
                                            value="{{ old('date_of_birth', $data->date_of_birth) }}" />
                                        <span class="error invalid-feedback">{{ $errors->first('date_of_birth') }}</span>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="mb-3">
                                        <label for="gender" class="form-label">{{ __('model.user.gender') }}</label>
                                        <select name="gender" class="form-select"
                                            aria-label="{{ __('model.user.gender') }}">
                                            <option value="{{ old('gender', $data->gender) }}" selected>
                                                {{ old('gender', $data->gender) }}</option>
                                            <option value="Laki-laki">Laki-laki</option>
                                            <option value="Perempuan">Perempuan</option>
                                        </select>
                                    </div>
                                </div>
                            @endif
                            <div class="col-md-6">
                                {{-- <x-input-form name="email" :label="__('model.user.email')" :value="$data->email" /> --}}
                                <div class="mb-3">
                                    <label for="email" class="form-label">{{ __('model.user.email') }}</label>
                                    <input type="text" class="form-control @error('email') is-invalid @enderror"
                                        id="email" name="email" value="{{ old('email', $data->email) }}" />
                                    <span class="error invalid-feedback">{{ $errors->first('email') }}</span>
                                </div>
                            </div>
                            <div class="col-md-6">
                                {{-- <x-input-form name="phone" :label="__('model.user.phone')" :value="$data->phone ?? ''" /> --}}
                                <div class="mb-3">
                                    <label for="phone" class="form-label">{{ __('model.user.phone') }}</label>
                                    <input type="text" class="form-control @error('phone') is-invalid @enderror"
                                        id="phone" name="phone" value="{{ old('phone', $data->phone) }}" />
                                    <span class="error invalid-feedback">{{ $errors->first('phone') }}</span>
                                </div>
                            </div>
                            <div class="col-md-6">
                                {{-- <x-input-form name="password" :label="__('model.user.v')" :value="$data->password ?? ''" /> --}}
                                <div class="mb-3">
                                    <label for="password" class="form-label">{{ __('model.user.password') }}</label>
                                    <input type="password" class="form-control @error('password') is-invalid @enderror"
                                        id="password" name="password" value="{{ old('password', $data->password) }}" />
                                    <span class="error invalid-feedback">{{ $errors->first('password') }}</span>
                                </div>
                            </div>
                        </div>
                        <div class="mt-2">
                            <button type="submit" class="btn btn-primary me-2">{{ __('menu.general.update') }}</button>
                            <button type="reset"
                                class="btn btn-outline-secondary">{{ __('menu.general.cancel') }}</button>
                        </div>
                    </div>
                    <!-- /Account -->
                </form>
            </div>

        </div>
    </div>
@endsection


{{-- @if (auth()->user()->role == 'staff')
    <div class="card">
        <h5 class="card-header">{{ __('navbar.profile.deactivate_account') }}</h5>
        <div class="card-body">
            <div class="mb-3 col-12 mb-0">
                <div class="alert alert-warning">
                    <h6 class="alert-heading fw-bold mb-1">
                        {{ __('navbar.profile.deactivate_confirm_message') }}</h6>
                </div>
            </div>
            <form id="formAccountDeactivation" action="{{ route('profile.deactivate') }}" method="post">
                @csrf
                @method('PUT')
                <div class="form-check mb-3">
                    <input class="form-check-input" type="checkbox" name="accountActivation" id="accountActivation">
                    <label class="form-check-label"
                        for="accountActivation">{{ __('navbar.profile.deactivate_confirm') }}</label>
                </div>
                <button type="submit" class="btn btn-danger deactivate-account"
                    disabled>{{ __('navbar.profile.deactivate_account') }}</button>
            </form>
        </div>
    </div>
@endif --}}
