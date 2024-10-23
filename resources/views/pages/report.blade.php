@extends('layout.main')
@push('style')
    <link rel="stylesheet" href="{{ asset('sneat/vendor/libs/apex-charts/apex-charts.css') }}" />
    <style>
        #example_filter {
            float: right;
            margin-top: 10%;
            margin-bottom: 3%;
        }

        #example_paginate {
            float: right;
            margin-top: 7%;
        }
    </style>
@endpush

@push('script')
    <script src="//cdnjs.cloudflare.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
    <!------ Include the above in your HEAD tag ---------->

    <script src="https://cdn.datatables.net/1.10.16/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/1.10.16/js/dataTables.bootstrap4.min.js"></script>

    <script>
        $(document).ready(function() {
            $('#example').DataTable(

                {

                    "aLengthMenu": [
                        [5, 10, 25, -1],
                        [5, 10, 25, "All"]
                    ],
                    "iDisplayLength": 10
                }
            );
        });
    </script>
@endpush
@section('content')
    <x-breadcrumb :values="[__('menu.report.menu')]">
        @if (auth()->user()->role == 'admin')
            <form action="{{ route('rekap.pdf') }}" method="POST">
                @csrf
                @method('POST')
                <div class="mx-3" style="width: 150px">
                    <button type="submit" class="btn btn-dark btn">Unduh</button>
                </div>
            </form>
        @endif
    </x-breadcrumb>

    {{-- view unduh paket di siswa --}}
    @if (auth()->user()->role == 'siswa')
        @if (DB::table('picks')->where(['user_id' => auth()->user()->id])->first())
            @foreach ($data as $package)
                <div class="card accordion-item active mb-3">
                    <div
                        class="card-header accordion-header d-flex justify-content-between align-items-center flex-column flex-sm-row">
                        <h5 class="text-nowrap mb-0 fw-bold">
                            {{ $package->title }}
                        </h5>

                        <div class="d-flex justify-content-between flex-sm-row">
                            <div class="d-flex flex-row align-items-center">
                                <form action="{{ route('print.pdf') }}" method="POST">
                                    @csrf
                                    @method('POST')
                                    <input class="form-control" type="hidden" id="package_number" name="package_number"
                                        value="{{ $package->package_number }}">
                                    <div class="mx-3" style="width: 150px">
                                        <button type="submit" class="btn btn-dark btn">Unduh</button>
                                    </div>
                                </form>
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
        @else
            <tbody>
                <td colspan="4">
                    <div style="display: flex; justify-content: center; align-items: center; margin-top: 150px;">
                        {{ __('menu.general.empty0') }}
                    </div><div style="display: flex; justify-content: center; align-items: center; margin-top: 15px;">
                        {{ __('menu.general.should') }}
                    </div>
                </td>
                
            </tbody>
        @endif
    @endif


    @if (auth()->user()->role == 'admin')
        @if (DB::table('picks')->first())
            @if ($packagesJoin)
                <div class="card mb-4">
                    <div class="table-responsive text-nowrap">
                        <table class="table table-bordered " id="example">
                            <thead>
                                <tr>
                                    <th>No</th>
                                    <th>{{ __('model.user.name') }}</th>
                                    <th>{{ __('model.user.nisn') }}</th>
                                    <th>{{ __('model.user.class') }}</th>
                                    <th>{{ __('model.paket.package') }}</th>
                                </tr>
                            </thead>
                            @if ($data)
                                <tbody>
                                    @php
                                        $i = 0;
                                    @endphp
                                    @foreach ($packagesJoin as $package)
                                        @php
                                            $i++;
                                        @endphp
                                        <tr>
                                            <th scope="row">{{ $i }}</th>
                                            <td>{{ $package->name }}</td>
                                            <td>{{ $package->nisn }}</td>
                                            <td>{{ $package->class }}</td>
                                            <td>{{ $package->title }}</td>
                                        </tr>
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
                </div>
                <div>
                    <form action="{{ route('paket.paket-pelajaran.reset') }}" method="POST">
                        @csrf
                        @method('POST')
                        <button class="btn btn-secondary btn-sm btn-delete" type="button">Hapus Semuaaa</button>
                    </form>
                </div>
            @else
            
                <tbody>
                    <tr>
                        <td colspan="4" class="text-center">
                            {{ __('menu.general.empty') }}
                        </td>
                    </tr>
                </tbody>
            @endif
        @else
            <tbody>
                <tr>
                    <td colspan="4" class="text-center">
                        {{ __('menu.general.empty') }}
                    </td>
                </tr>
            </tbody>
        @endif
    @endif
@endsection
