@extends('layout.main')

@push('script')
    <script>
        $(document).on('click', '.btn-edit', function() {
            const id = $(this).data('id');
            $('#editModal form').attr('action', '{{ route('announcement.index') }}/' + id);
            $('#editModal input:hidden#id').val(id);
            $('#editModal input#pengumuman').val($(this).data('pengumuman'));
        });
    </script>
    <script src="https://cdn.ckeditor.com/ckeditor5/41.4.2/classic/ckeditor.js"></script>
    <script>
        ClassicEditor
            .create(document.querySelector('#editor'))
            .catch(error => {
                console.error(error);
            });
        ClassicEditor
            .create(document.querySelector('#pengumuman'))
            .catch(error => {
                console.error(error);
            });
        CKEDITOR.replace('pengumuman');
    </script>
@endpush

@section('content')
    <x-breadcrumb :values="[__('menu.announcement.menu')]">
        @if (DB::table('announcements')->count() == 0)
            <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#createModal">
                {{ __('menu.general.create') }}
            </button>
        @endif
    </x-breadcrumb>

    <div class="card mb-4">
        <div class="table-responsive text-nowrap">
            <table class="table table-bordered" style="white-space: normal;">
                <thead>
                    <tr>
                        <th class="text-center" style="width: 70%;">{{ __('model.announcement.pengumuman') }}</th>
                        <th class="text-center" >{{ __('menu.general.action') }}</th>
                    </tr>
                </thead>
                @if ($data)
                    <tbody>
                        @foreach ($data as $announcement)
                            <tr>
                                <td>{!! html_entity_decode($announcement->pengumuman) !!}</td>
                                <td class="text-center">
                                    <button class="btn btn-info btn-sm btn-edit me-2" data-id="{{ $announcement->id }}"
                                        data-pengumuman="{!! html_entity_decode($announcement->pengumuman) !!}" data-bs-toggle="modal"
                                        data-bs-target="#editModal">
                                        {{ __('menu.general.edit') }}
                                    </button>
                                    <form action="{{ route('announcement.destroy', $announcement) }}" class="d-inline"
                                        method="post">
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

    <!-- Create Modal -->
    <div class="modal fade" id="createModal" data-bs-backdrop="static" tabindex="-1">
        <div class="modal-dialog">
            <form class="modal-content" method="post" action="{{ route('announcement.store') }}">
                @csrf
                <div class="modal-header">
                    <h5 class="modal-title" id="createModalTitle">{{ __('menu.general.create') }}</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="mb-3">
                        <label for="pengumuman" class="form-label">{{ __('model.announcement.pengumuman') }}</label>
                        <textarea class="form-control @error('pengumuman') is-invalid @enderror" name="pengumuman" rows="3"
                            id="editor">{{ old('pengumuman') }}</textarea>
                        <span class="error invalid-feedback">{{ $errors->first('pengumuman') }}</span>
                    </div>
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

    <!-- Edit Modal -->
    @if ($data->isNotEmpty())
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
                        <div class="mb-3">
                            <label for="pengumuman" class="form-label">{{ __('model.announcement.pengumuman') }}</label>
                            <textarea class="form-control @error('pengumuman') is-invalid @enderror" name="pengumuman" rows="3"
                                id="pengumuman">{{ old('pengumuman', $announcement->pengumuman) }}</textarea>
                            <span class="error invalid-feedback">{{ $errors->first('pengumuman') }}</span>
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
