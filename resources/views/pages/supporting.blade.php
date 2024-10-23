@extends('layout.main')

@push('script')
    <script>
        $(document).on('click', '.btn-edit', function() {
            const id = $(this).data('id');
            $('#editModal form').attr('action', '{{ route('supporting.index') }}/' + id);
            $('#editModal input:hidden#id').val(id);
            $('#editModal input#mata_pelajaran').val($(this).data('mata_pelajaran'));
            $('#editModal input#mapel_pendukung').val($(this).data('mapel_pendukung'));
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
            .create(document.querySelector('#mapel_pendukung'))
            .catch(error => {
                console.error(error);
            });
        CKEDITOR.replace('mapel_pendukung');
    </script>
@endpush

@section('content')
    <x-breadcrumb :values="[__('menu.supporting.menu')]">
        @if (auth()->user()->role == 'admin')
            <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#createModal">
                {{ __('menu.general.create') }}
            </button>
        @endif
    </x-breadcrumb>

    <div class="card mb-5">
        <div class="table-responsive text-nowrap">
            <table class="table table-bordered" style="white-space: normal;">
                <thead>
                    <tr>
                        <th class="text-center" style="width: 30%">{{ __('model.supporting.mata_pelajaran') }}</th>
                        <th class="text-center" style="width: 45%">{{ __('model.supporting.mapel_pendukung') }}</th>
                        @if (auth()->user()->role == 'admin')
                            <th class="text-center" style="width: 25%">{{ __('menu.general.action') }}</th>
                        @endif
                    </tr>
                </thead>
                @if ($data)
                    <tbody>
                        @foreach ($data as $supporting)
                            <tr>
                                <td>{{ $supporting->mata_pelajaran }}</td>
                                <td>{!! html_entity_decode($supporting->mapel_pendukung) !!}</td>
                                @if (auth()->user()->role == 'admin')
                                    <td class="text-center">
                                        <button class="btn btn-info btn-sm btn-edit me-2" data-id="{{ $supporting->id }}"
                                            data-mata_pelajaran="{{ $supporting->mata_pelajaran }}"
                                            data-mapel_pendukung="{{ $supporting->mapel_pendukung }}" data-bs-toggle="modal"
                                            data-bs-target="#editModal">
                                            {{ __('menu.general.edit') }}
                                        </button>
                                        <form action="{{ route('supporting.destroy', $supporting) }}" class="d-inline"
                                            method="post">
                                            @csrf
                                            @method('DELETE')
                                            <button class="btn btn-danger btn-sm btn-delete"
                                                type="button">{{ __('menu.general.delete') }}</button>
                                        </form>
                                    </td>
                                @endif
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
            <form class="modal-content" method="post" action="{{ route('supporting.store') }}">
                @csrf
                <div class="modal-header">
                    <h5 class="modal-title" id="createModalTitle">{{ __('menu.general.create') }}</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <x-input-form name="mata_pelajaran" :label="__('model.supporting.mata_pelajaran')" />
                    {{-- <x-input-textarea-form name="mapel_pendukung" :label="__('model.supporting.mapel_pendukung')" /> --}}
                    <div class="mb-3">
                        <label for="mapel_pendukung"
                            class="form-label">{{ __('model.supporting.mapel_pendukung') }}</label>
                        <textarea class="form-control @error('mapel_pendukung') is-invalid @enderror" name="mapel_pendukung" rows="3"
                            id="editor">{{ old('mapel_pendukung') }}</textarea>
                        <span class="error invalid-feedback">{{ $errors->first('mapel_pendukung') }}</span>
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
                        <x-input-form name="mata_pelajaran" :label="__('model.supporting.mata_pelajaran')" />
                        {{-- <x-input-textarea-form-edit name="mapel_pendukung" :label="__('model.supporting.mapel_pendukung')" /> --}}
                        <div class="mb-3">
                            <label for="mapel_pendukung"
                                class="form-label">{{ __('model.supporting.mapel_pendukung') }}</label>
                            <textarea class="form-control @error('mapel_pendukung') is-invalid @enderror" name="mapel_pendukung" rows="3"
                                id="mapel_pendukung">{!! html_entity_decode(old('mapel_pendukung', $supporting->mapel_pendukung)) !!}</textarea>
                            <span class="error invalid-feedback">{{ $errors->first('mapel_pendukung') }}</span>
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
