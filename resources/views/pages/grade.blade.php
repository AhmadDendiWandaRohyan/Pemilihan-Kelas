@extends('layout.main')

@push('script')
    <script>
        $(document).on('click', '.btn-edit', function() {
            const id = $(this).data('id');
            $('#editModal form').attr('action', '{{ route('grade.index') }}/' + id);
            $('#editModal input:hidden#id').val(id);
            $('#editModal input#user_id').val($(this).data('user_id'));
            $('#editModal input#mtk').val($(this).data('mtk'));
            $('#editModal input#fisika').val($(this).data('fisika'));
            $('#editModal input#kimia').val($(this).data('kimia'));
            $('#editModal input#biologi').val($(this).data('biologi'));
            $('#editModal input#sosiologi').val($(this).data('sosiologi'));
            $('#editModal input#ekonomi').val($(this).data('ekonomi'));
            $('#editModal input#sejarah').val($(this).data('sejarah'));
            $('#editModal input#geografi').val($(this).data('geografi'));
        });
    </script>
@endpush

@section('content')
    <x-breadcrumb :values="[__('menu.paket.grade')]">
        <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#createGradeModal">
            {{ __('menu.general.create') }}
        </button>
    </x-breadcrumb>

    <div class="card mb-4">
        <div class="table-responsive text-nowrap">
            <table class="table table-bordered ">
                <thead>
                    <tr>
                        <th>{{ __('model.grade.nama_siswa') }}</th>
                        <th>{{ __('model.grade.nisn') }}</th>
                        <th>{{ __('model.grade.nilai_mtk') }}</th>
                        <th>{{ __('model.grade.nilai_fisika') }}</th>
                        <th>{{ __('model.grade.nilai_kimia') }}</th>
                        <th>{{ __('model.grade.nilai_biologi') }}</th>
                        <th>{{ __('model.grade.nilai_sosiologi') }}</th>
                        <th>{{ __('model.grade.nilai_ekonomi') }}</th>
                        <th>{{ __('model.grade.nilai_sejarah') }}</th>
                        <th>{{ __('model.grade.nilai_geografi') }}</th>
                        <th class="text-center">{{ __('menu.general.action') }}</th>
                    </tr>
                </thead>
                @if ($data)
                    <tbody>
                        @foreach ($data as $grade)
                            <tr>
                                <td>{{ $grade->user->name }}</td>
                                <td>{{ $grade->user->nisn }}</td>
                                <td>{{ $grade->mtk }}</td>
                                <td>{{ $grade->fisika }}</td>
                                <td>{{ $grade->kimia }}</td>
                                <td>{{ $grade->biologi }}</td>
                                <td>{{ $grade->sosiologi }}</td>
                                <td>{{ $grade->ekonomi }}</td>
                                <td>{{ $grade->sejarah }}</td>
                                <td>{{ $grade->geografi }}</td>
                                <td>
                                    <button class="btn btn-info btn-sm btn-edit" data-id="{{ $grade->id }}"
                                        data-user_id="{{ $grade->user_id }}" data-mtk="{{ $grade->mtk }}"
                                        data-fisika="{{ $grade->fisika }}" data-kimia="{{ $grade->kimia }}"
                                        data-biologi="{{ $grade->biologi }}" data-sejarah="{{ $grade->sejarah }}"
                                        data-sosiologi="{{ $grade->sosiologi }}" data-ekonomi="{{ $grade->ekonomi }}"
                                        data-bs-toggle="modal" data-geografi="{{ $grade->geografi }}"
                                        data-bs-target="#editModal">
                                        {{ __('menu.general.edit') }}
                                    </button>
                                    <form action="{{ route('grade.destroy', $grade) }}" class="d-inline" method="post">
                                        @csrf
                                        @method('DELETE')
                                        <button class="btn btn-danger btn-sm btn-delete"
                                            type="button">{{ __('menu.general.delete') }}</button>
                                    </form>
                                </td>
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

    {!! $data->appends(['search' => $search])->links() !!}

    <!-- Create Grade Modal -->
    <div class="modal fade" id="createGradeModal" data-bs-backdrop="static" tabindex="-1">
        <div class="modal-dialog">
            <form class="modal-content" method="post" action="{{ route('grade.store') }}">
                @csrf
                <div class="modal-header">
                    <h5 class="modal-title" id="createGradeModalTitle">Tambah Data Nilai</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <!-- Dropdown Nama -->
                    <div class="mb-3">
                        <label for="user_id" class="form-label">Nama</label>
                        <select id="user_id" name="user_id" class="form-select" required>
                            <option value="" disabled selected>Pilih salah satu</option>
                            @foreach ($users as $user)
                                <option value="{{ $user->id }}">{{ $user->name }}</option>
                            @endforeach
                        </select>
                    </div>

                    <!-- Nilai Mata Pelajaran -->
                    <x-input-form name="mtk" :label="'Matematika'" type="number" />
                    <x-input-form name="fisika" :label="'Fisika'" type="number" />
                    <x-input-form name="kimia" :label="'Kimia'" type="number" />
                    <x-input-form name="biologi" :label="'Biologi'" type="number" />
                    <x-input-form name="sosiologi" :label="'Sosiologi'" type="number" />
                    <x-input-form name="ekonomi" :label="'Ekonomi'" type="number" />
                    <x-input-form name="sejarah" :label="'Sejarah'" type="number" />
                    <x-input-form name="geografi" :label="'Geografi'" type="number" />
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">
                        {{ __('menu.general.cancel') }}
                    </button>
                    <button type="submit" class="btn btn-primary">{{ __('menu.general.save') }}</button>
                </div>
            </form>
        </div>
    </div>

    {{-- <!-- Script untuk mengisi otomatis nama dan user_id berdasarkan NISN -->
    <script>
        document.getElementById('nisn').addEventListener('change', function() {
            const selectedOption = this.options[this.selectedIndex];
            document.getElementById('user_id').value = selectedOption.getAttribute('data-user-id');
            document.getElementById('name').value = selectedOption.getAttribute('data-name');
        });
    </script> --}}



    @if ($data->isNotEmpty())
        <!-- Edit Modal -->
        <div class="modal fade" id="editModal" data-bs-backdrop="static" tabindex="-1">
            <div class="modal-dialog">
                <form class="modal-content" method="post" action="">
                    @csrf
                    @method('PUT')
                    <div class="modal-header">
                        <h5 class="modal-title" id="editModalTitle">{{ __('menu.general.edit') }}</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <!-- Dropdown Nama -->
                        <div class="mb-3">
                            <label for="user_id" class="form-label">Nama</label>
                            <select id="user_id" name="user_id" class="form-select" required>
                                {{-- <option value="{{ $grade->user_id }}">
                                    {{ $grade->user->name }}</option> --}}
                                @foreach ($users as $user)
                                    <option value="{{ $user->id }}" @selected(old('user_id') == $user->name)>
                                        {{ $user->name }}
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        <!-- Nilai Mata Pelajaran -->
                        <x-input-form name="mtk" :label="'Matematika'" type="number" />
                        <x-input-form name="fisika" :label="'Fisika'" type="number" />
                        <x-input-form name="kimia" :label="'Kimia'" type="number" />
                        <x-input-form name="biologi" :label="'Biologi'" type="number" />
                        <x-input-form name="sosiologi" :label="'Sosiologi'" type="number" />
                        <x-input-form name="ekonomi" :label="'Ekonomi'" type="number" />
                        <x-input-form name="sejarah" :label="'Sejarah'" type="number" />
                        <x-input-form name="geografi" :label="'Geografi'" type="number" />
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
    @endif
@endsection
