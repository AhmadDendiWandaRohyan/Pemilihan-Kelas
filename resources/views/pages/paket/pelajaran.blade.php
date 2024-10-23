@extends('layout.main')

@push('script')
    <script>
        $(document).on('click', '.btn-edit', function() {
            const id = $(this).data('id');
            $('#editModal form').attr('action', '{{ route('paket.pelajaran.index') }}/' + id);
            $('#editModal input:hidden#id').val(id);
            $('#editModal input#nama_pelajaran').val($(this).data('nama_pelajaran'));
        });
    </script>
@endpush

@section('content')
    <x-breadcrumb :values="[__('menu.paket.menu'), __('menu.paket.pelajaran')]">
        <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#createModal">
            {{ __('menu.general.create') }}
        </button>
    </x-breadcrumb>

    <div class="card mb-5">
        <div class="table-responsive text-nowrap">
            <table class="table table-bordered ">
                <thead>
                    <tr>
                        <th class="text-center" style="width: 60%;">
                            {{ __('model.pelajaran.nama_pelajaran') }}</th>
                        <th class="text-center" style="width: 20%">{{ __('menu.general.action') }}</th>
                    </tr>
                </thead>
                @if ($data)
                    <tbody>
                        @foreach ($data as $pelajaran)
                            <tr>
                                <td>{{ $pelajaran->nama_pelajaran }}</td>
                                <td style="display: flex; justify-content: center;">
                                    <button class="btn btn-info btn-sm btn-edit me-2" data-id="{{ $pelajaran->id }}"
                                        data-nama_pelajaran="{{ $pelajaran->nama_pelajaran }}" data-bs-toggle="modal"
                                        data-bs-target="#editModal">
                                        {{ __('menu.general.edit') }}
                                    </button>
                                    <form action="{{ route('paket.pelajaran.destroy', $pelajaran) }}" class="d-inline"
                                        method="post">
                                        @csrf
                                        @method('DELETE')
                                        <button  class="btn btn-danger btn-sm btn-delete"
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
            <form class="modal-content" method="post" action="{{ route('paket.pelajaran.store') }}">
                @csrf
                <div class="modal-header">
                    <h5 class="modal-title" id="createModalTitle">{{ __('menu.general.create') }}</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <x-input-form name="nama_pelajaran" :label="__('model.pelajaran.nama_pelajaran')" />
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
