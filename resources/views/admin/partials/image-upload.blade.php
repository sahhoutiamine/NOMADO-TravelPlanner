{{-- Dual-mode Image Upload: URL + Local File --}}
{{-- Usage: @include('admin.partials.image-upload', ['currentImage' => $model->image ?? null]) --}}

@if(isset($currentImage) && $currentImage)
<div class="mb-4 flex items-center gap-4 p-4 bg-slate-50 rounded-2xl">
    <img src="{{ $currentImage }}" alt="Current" class="w-20 h-20 rounded-xl object-cover shadow-md">
    <div>
        <p class="text-xs font-bold text-slate-500 uppercase tracking-widest">Current Image</p>
        <p class="text-sm text-slate-400 mt-1 truncate max-w-xs">{{ $currentImage }}</p>
    </div>
</div>
@endif

<div class="flex items-center gap-2 mb-4">
    <button type="button" onclick="switchImageMode('url', this)" class="image-mode-btn active px-5 py-2 rounded-xl text-sm font-bold transition-all">
        🔗 URL
    </button>
    <button type="button" onclick="switchImageMode('file', this)" class="image-mode-btn px-5 py-2 rounded-xl text-sm font-bold transition-all">
        📁 Upload File
    </button>
</div>

<div id="image-url-mode">
    <input type="url" name="image" id="image" value="{{ old('image', $currentImage ?? '') }}" placeholder="https://..."
           class="w-full bg-slate-50 border-none rounded-2xl py-4 px-6 text-lg font-bold text-slate-900 focus:ring-4 focus:ring-primary-500/10 transition-all">
</div>

<div id="image-file-mode" class="hidden">
    <label for="image_file" class="relative block cursor-pointer group">
        <div id="drop-zone" class="w-full bg-slate-50 border-2 border-dashed border-slate-200 rounded-2xl py-10 px-6 text-center transition-all hover:border-primary-400 hover:bg-primary-50/30 group-hover:shadow-lg group-hover:shadow-primary-500/5">
            <div id="upload-placeholder" class="space-y-3">
                <div class="w-16 h-16 mx-auto bg-gradient-to-br from-primary-100 to-primary-200 rounded-2xl flex items-center justify-center">
                    <svg class="w-8 h-8 text-primary-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                    </svg>
                </div>
                <p class="text-sm font-bold text-slate-500">Drop your image here or <span class="text-primary-600 underline">browse</span></p>
                <p class="text-xs text-slate-400">JPEG, PNG, GIF, WebP • Max 5MB</p>
            </div>
            <div id="upload-preview" class="hidden">
                <img id="preview-img" src="" alt="Preview" class="max-h-40 mx-auto rounded-xl shadow-lg">
                <p id="preview-name" class="mt-3 text-sm font-bold text-slate-600"></p>
            </div>
        </div>
        <input type="file" name="image_file" id="image_file" accept="image/*" class="sr-only" onchange="handleFilePreview(this)">
    </label>
</div>

<x-input-error :messages="$errors->get('image')" />
<x-input-error :messages="$errors->get('image_file')" />

@push('styles')
<style>
.image-mode-btn { background: #f1f5f9; color: #94a3b8; }
.image-mode-btn.active { background: linear-gradient(135deg, #0ea5e9, #6366f1); color: white; box-shadow: 0 4px 15px rgba(99,102,241,.25); }
</style>
@endpush

@push('scripts')
<script>
function switchImageMode(mode, btn) {
    const urlMode = document.getElementById('image-url-mode');
    const fileMode = document.getElementById('image-file-mode');
    const urlInput = document.getElementById('image');
    const fileInput = document.getElementById('image_file');
    document.querySelectorAll('.image-mode-btn').forEach(b => b.classList.remove('active'));
    btn.classList.add('active');
    if (mode === 'url') {
        urlMode.classList.remove('hidden');
        fileMode.classList.add('hidden');
        fileInput.value = '';
        resetPreview();
    } else {
        urlMode.classList.add('hidden');
        fileMode.classList.remove('hidden');
        urlInput.value = '';
    }
}
function handleFilePreview(input) {
    if (input.files && input.files[0]) {
        const file = input.files[0];
        const reader = new FileReader();
        reader.onload = function(e) {
            document.getElementById('preview-img').src = e.target.result;
            document.getElementById('preview-name').textContent = file.name + ' (' + (file.size / 1024 / 1024).toFixed(2) + ' MB)';
            document.getElementById('upload-placeholder').classList.add('hidden');
            document.getElementById('upload-preview').classList.remove('hidden');
        };
        reader.readAsDataURL(file);
    }
}
function resetPreview() {
    document.getElementById('upload-placeholder').classList.remove('hidden');
    document.getElementById('upload-preview').classList.add('hidden');
}
document.addEventListener('DOMContentLoaded', function() {
    const dropZone = document.getElementById('drop-zone');
    if (dropZone) {
        ['dragenter', 'dragover'].forEach(evt => {
            dropZone.addEventListener(evt, e => { e.preventDefault(); dropZone.classList.add('border-primary-400', 'bg-primary-50/50'); });
        });
        ['dragleave', 'drop'].forEach(evt => {
            dropZone.addEventListener(evt, e => { e.preventDefault(); dropZone.classList.remove('border-primary-400', 'bg-primary-50/50'); });
        });
        dropZone.addEventListener('drop', e => {
            const fileInput = document.getElementById('image_file');
            fileInput.files = e.dataTransfer.files;
            handleFilePreview(fileInput);
        });
    }
});
</script>
@endpush
