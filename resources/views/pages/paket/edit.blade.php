@extends('layout.main')

@push('script')
    {{-- delete model --}}
    <script>
        $(document).on('click', '.delete_study', function() {
            var _this = $(this).parents('tr');
            $('.e_id').val(_this.find('.ids').text());
        });
    </script>

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
                    {{-- {{ dd($study) }} --}}
                    @foreach ($studies as $item)
                        <option value="{{ $item->nama_pelajaran }}"
                            @selected(old('nama_pelajaran') == $item->nama_pelajaran)>
                            {{ $item->nama_pelajaran }}
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
                    @foreach ($studies as $item)
                        <option value="{{ $item->nama_pelajaran }}"
                            @selected(old('nama_pelajaran') == $item->nama_pelajaran)>
                            {{ $item->nama_pelajaran }}
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
    <x-breadcrumb :values="[__('menu.paket.menu'), __('menu.general.edit')]">
    </x-breadcrumb>

    <div class="card mb-4">
        <form action="{{ route('paket.paket-pelajaran.update', $packages->id) }}" method="POST">
            @csrf
            @method('PUT')
            <div class="card-body row">
                <input class="form-control" type="hidden" id="id" name="id" value="{{ $packages->id }}">
                <input class="form-control" type="hidden" id="package_number" name="package_number"
                    value="{{ $packages->package_number }}">
                
                <div class="col-sm-12 col-12 col-md-12 col-lg-12" style="margin-bottom:5pt;"  >
                    <div><b>GENERAL</b></div>
                </div>
                <div class="col-sm-12 col-12 col-md-6 col-lg-6">
                    <div class="mb-3">
                        <label for="title" class="form-label">{{__('model.paket.title')}}</label>
                        <input type="text" class="form-control @error('title') is-invalid @enderror" id="title"
                            name="title" value="{{ old('title', $packagesJoin[0]->title) }}"
                            placeholder="{{ $packagesJoin[0]->title }}" />
                        <span class="error invalid-feedback">{{ $errors->first('title') }}</span>
                    </div>
                </div>
                <div class="col-sm-12 col-12 col-md-4 col-lg-4">
                    <div class="mb-3">
                        <label for="description" class="form-label">{{__('model.paket.description')}}</label>
                        <input type="text" class="form-control @error('description') is-invalid @enderror"
                            id="description" name="description"
                            value="{{ old('description', $packagesJoin[0]->description) }}"
                            placeholder="{{ $packagesJoin[0]->description }}" />
                        <span class="error invalid-feedback">{{ $errors->first('description') }}</span>
                    </div>
                </div>
                <div class="col-sm-12 col-12 col-md-2 col-lg-2">
                    <div class="mb-3">
                        <label for="maximum" class="form-label">{{__('model.paket.maximum')}}</label>
                        <input type="text" class="form-control @error('maximum') is-invalid @enderror"
                            id="maximum" name="maximum"
                            value="{{ old('maximum', $packagesJoin[0]->maximum) }}"
                            placeholder="{{ $packagesJoin[0]->maximum }}" />
                        <span class="error invalid-feedback">{{ $errors->first('maximum') }}</span>
                    </div>
                </div>
                <div class="col-sm-12 col-12 col-md-3 col-lg-3">
                    <div class="mb-3">
                        <label for="time_open" class="form-label">{{__('model.paket.time_open')}}</label>
                        <input type="time" class="form-control @error('time_open') is-invalid @enderror" id="time_open"
                            name="time_open" value="{{ old('time_open', $packagesJoin[0]->time_open) }}"
                            placeholder="{{ $packagesJoin[0]->time_open }}" />
                        <span class="error invalid-feedback">{{ $errors->first('time_open') }}</span>
                    </div>
                </div>
                <div class="col-sm-12 col-12 col-md-2 col-lg-2">
                    <div class="mb-3">
                        <label for="date_open" class="form-label">{{__('model.paket.date_open')}}</label>
                        <input type="date" class="form-control @error('date_open') is-invalid @enderror" id="date_open"
                            name="date_open" value="{{ old('date_open', $packagesJoin[0]->date_open) }}"
                            placeholder="{{ $packagesJoin[0]->date_open }}" />
                        <span class="error invalid-feedback">{{ $errors->first('date_open') }}</span>
                    </div>
                </div>
                <div class="col-sm-12 col-12 col-md-2 col-lg-2">
                    <div class="mb-3">
                        <label for="date_expired" class="form-label">{{__('model.paket.date_expired')}}</label>
                        <input type="date" class="form-control @error('date_expired') is-invalid @enderror"
                            id="date_expired" name="date_expired"
                            value="{{ old('date_expired', $packagesJoin[0]->date_expired) }}"
                            placeholder="{{ $packagesJoin[0]->date_expired }}" />
                        <span class="error invalid-feedback">{{ $errors->first('date_expired') }}</span>
                    </div>
                </div>

                <div class="col-sm-12 col-12 col-md-12 col-lg-12" style="margin-top: 10pt; margin-bottom:5pt;"  >
                    <div><b>PARAMETER/SYARAT NILAI</b></div>
                </div>
                <div class="col-sm-12 col-12 col-md-2 col-lg-2">
                    <div class="mb-3">
                        <label for="nilai_mtk" class="form-label">{{__('model.paket.nilai_mtk')}}</label>
                        <input type="text" class="form-control @error('nilai_mtk') is-invalid @enderror"
                            id="nilai_mtk" name="nilai_mtk"
                            value="{{ old('nilai_mtk', $packagesJoin[0]->nilai_mtk) }}"
                            placeholder="{{ $packagesJoin[0]->nilai_mtk }}" />
                        <span class="error invalid-feedback">{{ $errors->first('nilai_mtk') }}</span>
                    </div>
                </div>
                <div class="col-sm-12 col-12 col-md-2 col-lg-2">
                    <div class="mb-3">
                        <label for="nilai_fisika" class="form-label">{{__('model.paket.nilai_fisika')}}</label>
                        <input type="text" class="form-control @error('nilai_fisika') is-invalid @enderror"
                            id="nilai_fisika" name="nilai_fisika"
                            value="{{ old('nilai_fisika', $packagesJoin[0]->nilai_fisika) }}"
                            placeholder="{{ $packagesJoin[0]->nilai_fisika }}" />
                        <span class="error invalid-feedback">{{ $errors->first('nilai_fisika') }}</span>
                    </div>
                </div>
                <div class="col-sm-12 col-12 col-md-2 col-lg-2">
                    <div class="mb-3">
                        <label for="nilai_kimia" class="form-label">{{__('model.paket.nilai_kimia')}}</label>
                        <input type="text" class="form-control @error('nilai_kimia') is-invalid @enderror"
                            id="nilai_kimia" name="nilai_kimia"
                            value="{{ old('nilai_kimia', $packagesJoin[0]->nilai_kimia) }}"
                            placeholder="{{ $packagesJoin[0]->nilai_kimia }}" />
                        <span class="error invalid-feedback">{{ $errors->first('nilai_kimia') }}</span>
                    </div>
                </div>
                <div class="col-sm-12 col-12 col-md-2 col-lg-2">
                    <div class="mb-3">
                        <label for="nilai_biologi" class="form-label">{{__('model.paket.nilai_biologi')}}</label>
                        <input type="text" class="form-control @error('nilai_biologi') is-invalid @enderror"
                            id="nilai_biologi" name="nilai_biologi"
                            value="{{ old('nilai_biologi', $packagesJoin[0]->nilai_biologi) }}"
                            placeholder="{{ $packagesJoin[0]->nilai_biologi }}" />
                        <span class="error invalid-feedback">{{ $errors->first('nilai_biologi') }}</span>
                    </div>
                </div>
                <div class="col-sm-12 col-12 col-md-2 col-lg-2">
                    <div class="mb-3">
                        <label for="nilai_sosiologi" class="form-label">{{__('model.paket.nilai_sosiologi')}}</label>
                        <input type="text" class="form-control @error('nilai_sosiologi') is-invalid @enderror"
                            id="nilai_sosiologi" name="nilai_sosiologi"
                            value="{{ old('nilai_sosiologi', $packagesJoin[0]->nilai_sosiologi) }}"
                            placeholder="{{ $packagesJoin[0]->nilai_sosiologi }}" />
                        <span class="error invalid-feedback">{{ $errors->first('nilai_sosiologi') }}</span>
                    </div>
                </div>
                <div class="col-sm-12 col-12 col-md-2 col-lg-2">
                    <div class="mb-3">
                        <label for="nilai_ekonomi" class="form-label">{{__('model.paket.nilai_ekonomi')}}</label>
                        <input type="text" class="form-control @error('nilai_ekonomi') is-invalid @enderror"
                            id="nilai_ekonomi" name="nilai_ekonomi"
                            value="{{ old('nilai_ekonomi', $packagesJoin[0]->nilai_ekonomi) }}"
                            placeholder="{{ $packagesJoin[0]->nilai_ekonomi }}" />
                        <span class="error invalid-feedback">{{ $errors->first('nilai_ekonomi') }}</span>
                    </div>
                </div>
                <div class="col-sm-12 col-12 col-md-2 col-lg-2">
                    <div class="mb-3">
                        <label for="nilai_sejarah" class="form-label">{{__('model.paket.nilai_sejarah')}}</label>
                        <input type="text" class="form-control @error('nilai_sejarah') is-invalid @enderror"
                            id="nilai_sejarah" name="nilai_sejarah"
                            value="{{ old('nilai_sejarah', $packagesJoin[0]->nilai_sejarah) }}"
                            placeholder="{{ $packagesJoin[0]->nilai_sejarah }}" />
                        <span class="error invalid-feedback">{{ $errors->first('nilai_sejarah') }}</span>
                    </div>
                </div>
                <div class="col-sm-12 col-12 col-md-2 col-lg-2">
                    <div class="mb-3">
                        <label for="nilai_geografi" class="form-label">{{__('model.paket.nilai_geografi')}}</label>
                        <input type="text" class="form-control @error('nilai_geografi') is-invalid @enderror"
                            id="nilai_geografi" name="nilai_geografi"
                            value="{{ old('nilai_geografi', $packagesJoin[0]->nilai_geografi) }}"
                            placeholder="{{ $packagesJoin[0]->nilai_geografi }}" />
                        <span class="error invalid-feedback">{{ $errors->first('nilai_geografi') }}</span>
                    </div>
                </div>
                
                <div class="col-sm-12 col-12 col-md-12 col-lg-12">
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
                                @php
                                    $i = 0;
                                @endphp
                                @foreach ($packagesJoin as $item)
                                    @if ($item->type == 'general')
                                        @php
                                            $i++;
                                        @endphp
                                        <tr>
                                            <td>{{ $i }}</td>
                                            <td>
                                                <input type="hidden" name="packages_studies[]"
                                                    value="{{ $item->id }}">
                                                <input type="hidden" class="ids" value="{{ $item->id }}">
                                                <input type="hidden" name="type[]" value="general">
                                                <select class="form-select" id="study" name="study[]">
                                                    <option value="{{ $item->study }}">
                                                        {{ $item->study }}</option>
                                                    @foreach ($studies as $k)
                                                        <option value="{{ $k->nama_pelajaran }}"
                                                            @selected(old('nama_pelajaran') == $k->nama_pelajaran)>
                                                            {{ $k->nama_pelajaran }}
                                                        </option>
                                                    @endforeach
                                                </select>
                                            </td>
                                            @if ($i == '1')
                                                <td><a href="javascript:void(0)" class="text-success font-18"
                                                        title="Add" id="addBtn"><i class="fa fa-plus"></i></a></td>
                                            @endif
                                            @if ($item->id == !null)
                                                <td><a href="javascript:void(0)" class="text-danger font-18 remove"
                                                        title="Remove"><i class="fas fa-trash-alt"></i></a></td>
                                            @else
                                                <td><a href="javascript:void(0)" class="text-danger font-18 remove"
                                                        title="Remove"><i class="fas fa-trash-alt"></i></a></td>
                                            @endif
                                        </tr>
                                    @endif
                                @endforeach
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
                                @php
                                    $i = 0;
                                @endphp
                                @foreach ($packagesJoin as $item)
                                    @if ($item->type == 'specialization')
                                        @php
                                            $i++;
                                        @endphp
                                        <tr>
                                            <td>{{ $i }}</td>
                                            <td>
                                                <input type="hidden" name="packages_studies[]"
                                                    value="{{ $item->id }}">
                                                <input type="hidden" name="type[]" value="specialization">
                                                <select class="form-select" id="study" name="study[]">
                                                    <option value="{{ $item->study }}">
                                                        {{ $item->study }}</option>
                                                    {{-- {{ dd($study) }} --}}
                                                    @foreach ($studies as $item)
                                                        <option value="{{ $item->nama_pelajaran }}"
                                                            @selected(old('nama_pelajaran') == $item->nama_pelajaran)>
                                                            {{ $item->nama_pelajaran }}
                                                        </option>
                                                    @endforeach
                                                </select>
                                            </td>
                                            @if ($i == '1')
                                                <td><a href="javascript:void(0)" class="text-success font-18"
                                                        title="Add" id="addBtn2"><i class="fa fa-plus"></i></a></td>
                                            @endif
                                            @if ($item->id == !null)
                                                <td><a href="javascript:void(0)" class="text-danger font-18 remove"
                                                        title="Remove"><i class="fas fa-trash-alt"></i></a></td>
                                            @else
                                                <td><a href="javascript:void(0)" class="text-danger font-18 remove"
                                                        title="Remove"><i class="fas fa-trash-alt"></i></a></td>
                                            @endif
                                        </tr>
                                    @endif
                                @endforeach
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


    <!-- Delete Estimate Modal -->
    <div class="modal custom-modal fade" id="delete_study" role="dialog">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-body">
                    <div class="form-header">
                        <h3>Delete Study</h3>
                        <p>Are you sure want to remove column?</p>
                    </div>
                    <form action="" method="POST">
                        @csrf
                        <input type="hidden" name="id" class="e_id" value="">
                        <div class="row">
                            <div class="col-6">
                                <button type="submit" class="btn btn-primary continue-btn submit-btn">Delete</button>
                            </div>
                            <div class="col-6">
                                <a href="javascript:void(0);" data-dismiss="modal"
                                    class="btn btn-primary cancel-btn">Cancel</a>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <!-- /Delete Estimate Modal -->
@endsection
