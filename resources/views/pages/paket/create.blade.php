@extends('layout.main')

@push('script')
    <script>
        var rowIdx = 1;
        $("#addBtn").on("click", function() {
            // Adding a row inside the tbody.
            $("#tableStudies tbody").append(`
        <tr id="R${++rowIdx}">
            <td class="row-index text-center"><p> ${rowIdx}</p></td>
            <td>
                <input type="hidden" name="type[]" value="general">
                <select class="form-select" id="study" name="study[]">
                    @foreach ($studies as $study)
                        <option value="{{ $study->nama_pelajaran }}" @selected(old('nama_pelajaran') == $study->nama_pelajaran)>
                            {{ $study->nama_pelajaran }}
                        </option>
                    @endforeach
                </select>
            </td>
            <td><a href="javascript:void(0)" class="text-danger font-18 remove" title="Remove"><i class="fas fa-trash-alt"></i></a></td>
        </tr>`);
        });
        $("#tableStudies tbody").on("click", ".remove", function() {
            // Getting all the rows next to the row
            // containing the clicked button
            var child = $(this).closest("tr").nextAll();
            // Iterating across all the rows
            // obtained to change the index
            child.each(function() {
                // Getting <tr> id.
                var id = $(this).attr("id");

                // Getting the <p> inside the .row-index class.
                var idx = $(this).children(".row-index").children("p");

                // Gets the row number from <tr> id.
                var dig = parseInt(id.substring(1));

                // Modifying row index.
                idx.html(`${dig - 1}`);

                // Modifying row id.
                $(this).attr("id", `R${dig - 1}`);
            });

            // Removing the current row.
            $(this).closest("tr").remove();

            // Decreasing total number of rows by 1.
            rowIdx--;
        });
    </script>

    <script>
        var rowIdx = 1;
        $("#addBtn2").on("click", function() {
            // Adding a row inside the tbody.
            $("#tableStudies2 tbody").append(`
        <tr id="R${++rowIdx}">
            <td class="row-index text-center"><p> ${rowIdx}</p></td>
            <td>
                <input type="hidden" name="type[]" value="specialization">
                <select class="form-select" id="study" name="study[]">
                    @foreach ($studies as $study)
                        <option value="{{ $study->nama_pelajaran }}" @selected(old('nama_pelajaran') == $study->nama_pelajaran)>
                            {{ $study->nama_pelajaran }}
                        </option>
                    @endforeach
                </select>
            </td>
            <td><a href="javascript:void(0)" class="text-danger font-18 remove" title="Remove"><i class="fas fa-trash-alt"></i></a></td>
        </tr>`);
        });
        $("#tableStudies2 tbody").on("click", ".remove", function() {
            // Getting all the rows next to the row
            // containing the clicked button
            var child = $(this).closest("tr").nextAll();
            // Iterating across all the rows
            // obtained to change the index
            child.each(function() {
                // Getting <tr> id.
                var id = $(this).attr("id");

                // Getting the <p> inside the .row-index class.
                var idx = $(this).children(".row-index").children("p");

                // Gets the row number from <tr> id.
                var dig = parseInt(id.substring(1));

                // Modifying row index.
                idx.html(`${dig - 1}`);

                // Modifying row id.
                $(this).attr("id", `R${dig - 1}`);
            });

            // Removing the current row.
            $(this).closest("tr").remove();

            // Decreasing total number of rows by 1.
            rowIdx--;
        });
    </script>
    <script>
        $(document).on('click', '.btn-delete', function(req) {
            Swal.fire({
                title: '{{ __('menu.general.delete_confirm') }}',
                text: "{{ __('menu.general.delete_warning') }}",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#696cff',
                confirmButtonText: '{{ __('menu.general.delete') }}',
                cancelButtonText: '{{ __('menu.general.cancel') }}'
            }).then((result) => {
                if (result.isConfirmed) {
                    $(this).parent('form').submit();
                }
            })
        });
    </script>
@endpush

@section('content')
    <x-breadcrumb :values="[__('menu.paket.menu'), __('menu.general.create')]">
    </x-breadcrumb>

    <div class="card mb-4">
        <form action="{{ route('paket.paket-pelajaran.store') }}" method="POST">
            @csrf
            <div class="card-body row">
                <div class="col-sm-12 col-12 col-md-12 col-lg-12" style="margin-bottom:5pt;"  >
                    <div><b>GENERAL</b></div>
                </div>
                <div class="col-sm-12 col-12 col-md-6 col-lg-6">
                    <x-input-form name="title" :label="__('model.paket.title')" />
                </div>
                <div class="col-sm-12 col-12 col-md-4 col-lg-4">
                    <x-input-form name="description" :label="__('model.paket.description')" />
                </div>
                <div class="col-sm-12 col-12 col-md-2 col-lg-2">
                    <x-input-form name="maximum" :label="__('model.paket.maximum')" />
                </div>
                <div class="col-sm-12 col-12 col-md-3 col-lg-3">
                    <x-input-form name="time_open" :label="__('model.paket.time_open')" type="time" />
                </div>
                <div class="col-sm-12 col-12 col-md-2 col-lg-2">
                    <x-input-form name="date_open" :label="__('model.paket.date_open')" type="date" />
                </div>
                <div class="col-sm-12 col-12 col-md-2 col-lg-2">
                    <x-input-form name="date_expired" :label="__('model.paket.date_expired')" type="date" />
                </div>
                <div class="col-sm-12 col-12 col-md-12 col-lg-12" style="margin-top: 10pt; margin-bottom:5pt;"  >
                    <div><b>PARAMETER/SYARAT NILAI</b></div>
                </div>
                <div class="col-sm-12 col-12 col-md-2 col-lg-2">
                    <x-input-form name="nilai_mtk" :label="__('model.paket.nilai_mtk')"/>
                </div>
                <div class="col-sm-12 col-12 col-md-2 col-lg-2">
                    <x-input-form name="nilai_fisika" :label="__('model.paket.nilai_fisika')"/>
                </div>
                <div class="col-sm-12 col-12 col-md-2 col-lg-2">
                    <x-input-form name="nilai_kimia" :label="__('model.paket.nilai_kimia')"/>
                </div>
                <div class="col-sm-12 col-12 col-md-2 col-lg-2">
                    <x-input-form name="nilai_biologi" :label="__('model.paket.nilai_biologi')"/>
                </div>
                <div class="col-sm-12 col-12 col-md-2 col-lg-2">
                    <x-input-form name="nilai_sosiologi" :label="__('model.paket.nilai_sosiologi')"/>
                </div>
                <div class="col-sm-12 col-12 col-md-2 col-lg-2">
                    <x-input-form name="nilai_ekonomi" :label="__('model.paket.nilai_ekonomi')"/>
                </div>
                <div class="col-sm-12 col-12 col-md-2 col-lg-2">
                    <x-input-form name="nilai_sejarah" :label="__('model.paket.nilai_sejarah')"/>
                </div>
                <div class="col-sm-12 col-12 col-md-2 col-lg-2">
                    <x-input-form name="nilai_geografi" :label="__('model.paket.nilai_geografi')"/>
                </div>
                
                <div class="col-sm-12
                            col-12 col-md-12 col-lg-12">
                    <div class="table-responsive mb-4">
                        <table class="table table-hover table-white" id="tableStudies">
                            <thead>
                                <tr>
                                    <th style="width: 20px">#</th>
                                    <th>Mata Pelajaran Umum</th>
                                    <th> </th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td>1</td>
                                    <td>
                                        <input type="hidden" name="type[]" value="general">
                                        <select class="form-select" id="study" name="study[]">
                                            @foreach ($studies as $study)
                                                <option value="{{ $study->nama_pelajaran }}" @selected(old('nama_pelajaran') == $study->nama_pelajaran)>
                                                    {{ $study->nama_pelajaran }}
                                                </option>
                                            @endforeach
                                        </select>
                                    </td>
                                    <td><a href="javascript:void(0)" class="text-success font-18" title="Add"
                                            id="addBtn"><i class="fa fa-plus"></i></a></td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                    <div class="table-responsive mb-4">
                        <table class="table table-hover table-white" id="tableStudies2">
                            <thead>
                                <tr>
                                    <th style="width: 20px">#</th>
                                    <th>Mata Pelajaran Minat</th>
                                    <th> </th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td>1</td>
                                    <td>
                                        <input type="hidden" name="type[]" value="specialization">
                                        <select class="form-select" id="study" name="study[]">
                                            @foreach ($studies as $study)
                                                <option value="{{ $study->nama_pelajaran }}" @selected(old('nama_pelajaran') == $study->nama_pelajaran)>
                                                    {{ $study->nama_pelajaran }}
                                                </option>
                                            @endforeach
                                        </select>
                                    </td>
                                    <td><a href="javascript:void(0)" class="text-success font-18" title="Add"
                                            id="addBtn2"><i class="fa fa-plus"></i></a></td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
            <div class="card-footer pt-0">
                <button class="btn btn-primary" type="submit">{{ __('menu.general.save') }}</button>
            </div>
        </form>
    </div>
@endsection
