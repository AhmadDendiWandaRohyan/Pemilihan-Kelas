@push('script')
    <script src="https://cdn.ckeditor.com/ckeditor5/41.4.2/classic/ckeditor.js"></script>
    <script>
        ClassicEditor
            .create(document.querySelector('#editor2'))
            .catch(error => {
                console.error(error);
            });
    </script>
@endpush

<div class="mb-3">
    <label for="{{ $name }}" class="form-label">{{ $label }}</label>
    <textarea id="editor2" class="form-control @error($name) is-invalid @enderror" id="{{ $name }}"
        name="{{ $name }}" rows="3">{{ old($name, $value) }}</textarea>
    <span class="error invalid-feedback">{{ $errors->first($name) }}</span>
</div>
