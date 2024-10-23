@extends('layout.main')

@push('script')
    <script>
        $(document).on('click', '.btn-edit', function() {
            const id = $(this).data('id');
            $('#editModal form').attr('action', '{{ route('user.index') }}/' + id);
            $('#editModal input:hidden#id').val(id);
            $('#editModal input#nisn').val($(this).data('nisn'));
            $('#editModal input#email').val($(this).data('email'));
            if ($(this).data('active') == 1) {
                $('#editModal input#is_active').attr('checked', 1)
            } else {
                $('#editModal input#is_active').removeAttribute('checked');
            }
        });
    </script>
@endpush

@section('content')
    <x-breadcrumb :values="[__('menu.users')]">
        <div class="d-flex gap-2">
            <form action="{{ route('users.import') }}" method="POST" enctype="multipart/form-data">
                @csrf
                @method('POST')
                <div class="input-group">
                    <input type="file" class="form-control" id="file" name="file"
                        aria-describedby="inputGroupFileAddon04" aria-label="Upload">
                    <button class="btn btn-outline-primary" type="submit" id="file">Import Data User</button>
                </div>
            </form>
            <button type="button" class="btn btn-primary btn-create" data-bs-toggle="modal" data-bs-target="#createModal">
                {{ __('menu.general.create') }}
            </button>
        </div>
    </x-breadcrumb>

    <div class="card mb-4">
        <div class="table-responsive text-nowrap">
            <table class="table table-bordered ">
                <thead>
                    <tr>
                        <th>{{ __('model.user.name') }}</th>
                        <th>{{ __('model.user.class') }}</th>
                        <th>{{ __('model.user.nisn') }}</th>
                        <th>{{ __('model.user.place_of_birth') }}</th>
                        <th>{{ __('model.user.date_of_birth') }}</th>
                        <th>{{ __('model.user.school_year') }}</th>
                        <th>{{ __('model.user.gender') }}</th>
                        <th>{{ __('model.user.religion') }}</th>
                        <th>{{ __('model.user.email') }}</th>
                        <th>{{ __('model.user.phone') }}</th>
                        <th>{{ __('model.user.is_active') }}</th>
                        <th>{{ __('menu.general.action') }}</th>
                    </tr>
                </thead>
                @if ($data)
                    <tbody>
                        @foreach ($data as $user)
                            <tr>
                                <td>{{ $user->name }}</td>
                                <td>{{ $user->class }}</td>
                                <td>{{ $user->nisn }}</td>
                                <td>{{ $user->place_of_birth }}</td>
                                <td>{{ $user->date_of_birth }}</td>
                                <td>{{ $user->school_year }}</td>
                                <td>{{ $user->gender }}</td>
                                <td>{{ $user->religion }}</td>
                                <td>{{ $user->email }}</td>
                                <td>{{ $user->phone }}</td>
                                <td><span
                                        class="badge bg-label-primary me-1">{{ __('model.user.' . ($user->is_active ? 'active' : 'nonactive')) }}</span>
                                </td>
                                <td>
                                    <button class="btn btn-info btn-sm btn-edit" data-id="{{ $user->id }}"
                                        data-nisn="{{ $user->nisn }}" data-email="{{ $user->email }}"
                                        data-active="{{ $user->is_active }}" data-bs-toggle="modal"
                                        data-bs-target="#editModal">
                                        {{ __('menu.general.edit') }}
                                    </button>
                                    <form action="{{ route('user.destroy', $user) }}" class="d-inline" method="post">
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
    {{-- tombol hapus semua data laporan menu kelola pengguna --}}
    <div>
        <form action="{{ route('user.destroy.all') }}" class="d-inline" method="post">
            @csrf
            @method('DELETE')
            <button class="btn btn-secondary btn-sm btn-delete" type="button">Hapus Semua</button>
        </form>
    </div>

    {!! $data->appends(['search' => $search])->links() !!}

    <!-- Create Modal -->
    <div class="modal fade" id="createModal" data-bs-backdrop="static" tabindex="-1">
        <div class="modal-dialog">
            <form class="modal-content" method="post" action="{{ route('user.store') }}">
                @csrf
                <div class="modal-header">
                    <h5 class="modal-title" id="createModalTitle">{{ __('menu.general.create') }}</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <x-input-form name="nisn" :label="__('model.user.nisn')" />
                    <x-input-form name="email" :label="__('model.user.email')" type="email" />
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
                        <input type="hidden" name="id" id="id" value="">
                        <x-input-form name="nisn" :label="__('model.user.nisn')" />
                        <x-input-form name="email" :label="__('model.user.email')" type="email" />
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" name="is_active" value="true" id="is_active">
                            <label class="form-check-label" for="is_active"> {{ __('model.user.is_active') }} </label>
                        </div>
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" name="reset_password" value="true"
                                id="reset_password">
                            <label class="form-check-label" for="reset_password"> {{ __('model.user.reset_password') }}
                            </label>
                        </div>
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
