@extends('layout.main')

@section('content')
    @if (auth()->user()->role == 'admin')
        <x-breadcrumb :values="[__('menu.paket.menu')]">
            <a href="{{ route('paket.paket-pelajaran.create') }}" class="btn btn-primary">{{ __('menu.general.create') }}</a>
        </x-breadcrumb>
    @endif

    @foreach ($data as $package)
        <div class="card accordion-item active mb-3">
            <div
                class="card-header accordion-header d-flex justify-content-between align-items-center flex-column flex-sm-row">
                <div>
                    <h5 class="text-nowrap mb-0 fw-bold">
                        {{ $package->title }}
                    </h5>
                    <div>
                        <div>Kuota {{ $package->maximum }}</div>
                        @if (auth()->user()->role == 'siswa')
                            @php
                                $user = auth()->user();

                                if (
                                    $grade->mtk >= $package->nilai_mtk &&
                                    $grade->fisika >= $package->nilai_fisika &&
                                    $grade->kimia >= $package->nilai_kimia &&
                                    $grade->biologi >= $package->nilai_biologi &&
                                    $grade->sosiologi >= $package->nilai_sosiologi &&
                                    $grade->ekonomi >= $package->nilai_ekonomi &&
                                    $grade->sejarah >= $package->nilai_sejarah &&
                                    $grade->geografi >= $package->nilai_geografi
                                ) {
                                    echo '<div style="color: red;">Rekomendasi</div>';
                                } else {
                                    echo '';
                                }
                            @endphp
                        @endif
                    </div>
                </div>

                <div class="d-flex justify-content-between ">
                    <div class="d-flex flex-row align-items-center">
                        @php
                            $now = \Carbon\Carbon::now();
                            $dateOpen = \Carbon\Carbon::parse($package->date_open . ' ' . $package->time_open);
                            $dateExpired = \Carbon\Carbon::parse($package->date_expired);

                            // dd($grade->fisika);

                        @endphp

                        @if (auth()->user()->role == 'siswa' && $now->greaterThanOrEqualTo($dateOpen) && $now->lessThanOrEqualTo($dateExpired))
                            @if (
                                $grade->mtk >= $package->nilai_mtk &&
                                    $grade->fisika >= $package->nilai_fisika &&
                                    $grade->kimia >= $package->nilai_kimia &&
                                    $grade->biologi >= $package->nilai_biologi &&
                                    $grade->sosiologi >= $package->nilai_sosiologi &&
                                    $grade->ekonomi >= $package->nilai_ekonomi &&
                                    $grade->sejarah >= $package->nilai_sejarah &&
                                    $grade->geografi >= $package->nilai_geografi)
                                @if (DB::table('picks')->where(['package_number' => $package->package_number, 'user_id' => auth()->user()->id])->first())
                                    <form action="{{ route('paket.pick.destroy') }}" method="post">
                                        @csrf
                                        @method('POST')
                                        <input class="form-control" type="hidden" id="package_number" name="package_number"
                                            value="{{ $package->package_number }}">
                                        <div style="width: 90px">
                                            <button type="submit" class="btn btn-danger btn">Batal</button>
                                        </div>

                                    </form>
                                @endif
                                <form action="{{ route('paket.pick.store') }}" method="POST">
                                    @csrf
                                    @method('POST')
                                    <input class="form-control" type="hidden" id="user_id" name="user_id"
                                        value="{{ auth()->user()->id }}">
                                    <input class="form-control" type="hidden" id="package_number" name="package_number"
                                        value="{{ $package->package_number }}">
                                    <div class="mx-3" style="width: 150px">
                                        <button type="submit" class="btn btn-primary btn">Pilih
                                            <span>
                                                (Sisa
                                                {{ $package->maximum -DB::table('picks')->where('package_number', $package->package_number)->count() }})
                                            </span></button>
                                    </div>
                                </form>
                            @endif
                        @endif
                        @if (auth()->user()->role == 'admin')
                            <form action="{{ route('paket.pick.store') }}" method="POST">
                                @csrf
                                @method('POST')
                                <input class="form-control" type="hidden" id="user_id" name="user_id"
                                    value="{{ auth()->user()->id }}">
                                <input class="form-control" type="hidden" id="package_number" name="package_number"
                                    value="{{ $package->package_number }}">
                                <div class="mx-3" style="width: 150px">
                                    <button type="submit" class="btn btn-primary btn">Pilih
                                        <span>
                                            (Sisa
                                            {{ $package->maximum -DB::table('picks')->where('package_number', $package->package_number)->count() }})
                                        </span></button>
                                </div>
                            </form>
                            <div class="dropdown d-inline-block d-flex m-0 p-0">
                                <button class="btn p-0" type="button" id="dropdown-{{ $package->id }}"
                                    data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                    <i class="bx bx-dots-vertical-rounded"></i>
                                </button>
                                <div class="dropdown-menu dropdown-menu-end"
                                    aria-labelledby="dropdown-{{ $package->id }}">
                                    <a class="dropdown-item"
                                        href="{{ route('paket.paket-pelajaran.edit', $package->package_number) }}">{{ __('menu.general.edit') }}</a>

                                    <form action="{{ route('paket.paket-pelajaran.destroy') }}" method="POST">
                                        @csrf
                                        @method('POST')
                                        <input class="form-control" type="hidden" id="package_number" name="package_number"
                                            value="{{ $package->package_number }}">
                                        <input class="form-control" type="hidden" id="id" name="id"
                                            value="{{ $package->id }}">
                                        <span
                                            class="dropdown-item cursor-pointer btn-delete">{{ __('menu.general.delete') }}</span>
                                    </form>
                                </div>
                            </div>
                        @endif
                    </div>
                    <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse"
                        data-bs-target="#accordionPayment-{{ $package->id }}"
                        aria-controls="accordionPayment-{{ $package->id }}">
                    </button>
                </div>
            </div>
            <div id="accordionPayment-{{ $package->id }}" class="accordion-collapse collapse" style="">
                <div class="accordion-body">
                    <div class="d-flex flex-column flex-sm-row justify-content-evenly">
                        <div>
                            <table class="table table-borderless">
                                <thead>
                                    <tr>
                                        <th scope="col">#</th>
                                        <th scope="col">Mata Pelajaran Umum</th>
                                    </tr>
                                </thead>
                                @if ($data)
                                    <tbody>
                                        @php
                                            $i = 0;
                                        @endphp
                                        @foreach ($packagesJoin as $item)
                                            @if ($item->type == 'general' && $package->package_number == $item->package_number)
                                                @php
                                                    $i++;
                                                @endphp
                                                <tr>
                                                    <th scope="row">{{ $i }}</th>
                                                    <td>{{ $item->study }}</td>
                                                </tr>
                                            @endif
                                        @endforeach
                                    </tbody>
                                @else
                                    <tbody>
                                        <tr>
                                            <td colspan="4" class="text-center">
                                                {{ __('menu.general.empty') }}
                                            </td>
                                        </tr>
                                    </tbody>
                                @endif
                            </table>
                        </div>
                        <div>
                            <table class="table table-borderless">
                                <thead>
                                    <tr>
                                        <th scope="col">#</th>
                                        <th scope="col">Mata Pelajaran Minat</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @php
                                        $x = 0;
                                    @endphp
                                    @foreach ($packagesJoin as $item)
                                        @if ($item->type == 'specialization' && $package->package_number == $item->package_number)
                                            @php
                                                $x++;
                                            @endphp
                                            <tr>
                                                <input type="hidden" name="packages_studies[]"
                                                    value="{{ $item->id }}">
                                                <th scope="row">{{ $x }}</th>
                                                <td>{{ $item->study }}</td>
                                            </tr>
                                        @endif
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    @endforeach

    {!! $data->appends(['search' => $search])->links() !!}

    <!-- Choice Modal -->
    <div class="modal fade" id="choiceModal" data-bs-backdrop="static" tabindex="-1">
        <div class="modal-dialog">
            <form class="modal-content" method="post" action="">
                @csrf
                @method('PUT')
                <div class="modal-header">
                    <h5 class="modal-title" id="editModalTitle">{{ __('menu.general.edit') }}</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <input type="hidden" name="id" id="id" value="">
                    <x-input-form name="nama_pelajaran" :label="__('model.pelajaran.nama_pelajaran')" />
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">
                        {{ __('menu.general.cancel') }}
                    </button>
                    <button type="submit" class="btn btn-primary">{{ __('menu.general.update') }}</button>
                </div>
            </form>
        </div>
    </div>
@endsection
