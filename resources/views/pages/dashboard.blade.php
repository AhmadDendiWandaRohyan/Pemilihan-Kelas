@extends('layout.main')

@push('style')
    <link rel="stylesheet" href="{{ asset('sneat/vendor/libs/apex-charts/apex-charts.css') }}" />
@endpush

@push('script')
    <script src="{{ asset('sneat/vendor/libs/apex-charts/apexcharts.js') }}"></script>
@endpush

@section('content')
    <div class="row">
        <div class="col-lg-12 mb-2 order-0">
            <div class="card mb-4">
                <div class="d-flex align-items-end row">
                    <div class="col-sm-6">
                        <div class="card-body">
                            <h4 class="card-title text-primary">{{ $greeting }}</h4>
                            <p class="mb-4">
                                {{ $currentDate }}
                            </p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-lg-7 mb-2 order-0">
            <div class="card mb-4">
                <div class="card-body">
                    <div class="text-wrap">
                        <h4 class="card-title text-primary">Pengumuman</h4>

                        @if (auth()->user()->role == 'siswa')
                            @if (auth()->user()->name == '' ||
                                    auth()->user()->class == '' ||
                                    auth()->user()->religion == '' ||
                                    auth()->user()->school_year == '' ||
                                    auth()->user()->phone == '')
                                <div style="color: red">Silahkan lengkapi data diri terlebih dahulu di halaman <a
                                        href="{{ route('profile.show') }}">profil</a>.</div>
                            @endif
                        @endif
                        @if ($announcements)
                            @foreach ($announcements as $announcement)
                                <div>{!! html_entity_decode($announcement->pengumuman) !!}</div>
                            @endforeach
                        @else
                            <div>{{ __('menu.general.empty') }}</div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
        <div class="col-lg-5 mb-2 order-0">
            <div class="card mb-4">
                <div class="d-flex align-items-end row">
                    <div class="col-sm-12">
                        <div class="card-body">
                            <div class="text-nowrap" style=" overflow: auto;">
                                <h4 class="card-title text-primary">Rekapitulasi pemilihan paket siswa </h4>
                                <div class="d-flex">
                                    <div class="d-flex me-3">
                                        <div
                                            style="width: 15px; height: 15px; background-color: blue; box-shadow: rgba(50, 50, 93, 0.25) 0px 6px 12px -2px, rgba(0, 0, 0, 0.3) 0px 3px 7px -3px;">
                                        </div>
                                        <p class="px-2">Jumlah Siswa</p>
                                    </div>
                                    <div class="d-flex me-3">
                                        <div
                                            style="width: 15px; height: 15px; background-color: green; box-shadow: rgba(50, 50, 93, 0.25) 0px 6px 12px -2px, rgba(0, 0, 0, 0.3) 0px 3px 7px -3px;">
                                        </div>
                                        <p class="px-2">Sudah Memilih</p>
                                    </div>
                                    <div class="d-flex me-3">
                                        <div
                                            style="width: 15px; height: 15px; background-color: red; box-shadow: rgba(50, 50, 93, 0.25) 0px 6px 12px -2px, rgba(0, 0, 0, 0.3) 0px 3px 7px -3px;">
                                        </div>
                                        <p class="px-2">Belum Memilih</p>
                                    </div>
                                </div>
                                <div class="d-flex" style="margin-left: 5px;">
                                    <div class="card-body py-5 me-2" style="background-color: blue; padding-left: 50px; padding-right: 50px;">

                                        <h3 class="card-title mb-1 text-center text-white">{{ $sumStudents }}</h3>
                                    </div>

                                    <div class="resize-triggers">
                                        <div class="expand-trigger">
                                            <div style="width: 145px; height: 130px;"></div>
                                        </div>
                                        <div class="contract-trigger"></div>
                                    </div>
                                    <div class="card-body py-5 me-2" style="background-color: green; padding-left: 50px; padding-right: 50px;">

                                        <h3 class="card-title mb-1 text-center text-white">{{ $sumStudentsPick }}</h3>
                                    </div>

                                    <div class="resize-triggers">
                                        <div class="expand-trigger">
                                            <div style="width: 145px; height: 130px;"></div>
                                        </div>
                                        <div class="contract-trigger"></div>
                                    </div>
                                    <div class="card-body py-5 me-2" style="background-color: red; padding-left: 50px; padding-right: 50px;">

                                        <h3 class="card-title mb-1 text-center text-white">
                                            {{ $sumStudents - $sumStudentsPick }}</h3>
                                    </div>

                                    <div class="resize-triggers">
                                        <div class="expand-trigger">
                                            <div style="width: 145px; height: 10px;"></div>
                                        </div>
                                        <div class="contract-trigger"></div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    </div>
@endsection
