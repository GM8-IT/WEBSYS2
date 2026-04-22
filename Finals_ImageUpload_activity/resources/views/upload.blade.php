<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Upload Image Gallery</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        .animated-bg {
            background: linear-gradient(-45deg, #0f172a, #1e293b, #0f172a, #1e293b);
            background-size: 400% 400%;
            animation: gradient 15s ease infinite;
            position: fixed;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            width: 100%;
            height: 100vh;
            overflow: hidden;
            z-index: 0;
        }

        @keyframes gradient {
            0% { background-position: 0% 50%; }
            50% { background-position: 100% 50%; }
            100% { background-position: 0% 50%; }
        }

        .shape {
            position: fixed;
            opacity: 0.04;
            z-index: 1;
        }

        .shape-1 {
            width: 400px;
            height: 400px;
            background: linear-gradient(135deg, #3b82f6, #8b5cf6);
            border-radius: 40% 60% 70% 30% / 40% 50% 60% 50%;
            top: -150px;
            left: -100px;
            animation: float 25s infinite ease-in-out;
        }

        .shape-2 {
            width: 350px;
            height: 350px;
            background: linear-gradient(135deg, #06b6d4, #3b82f6);
            border-radius: 20% 80% 30% 70% / 70% 20% 80% 30%;
            bottom: -100px;
            right: -50px;
            animation: float 30s infinite ease-in-out reverse;
        }

        .shape-3 {
            width: 300px;
            height: 300px;
            background: linear-gradient(135deg, #ec4899, #f43f5e);
            border-radius: 60% 40% 30% 70% / 60% 30% 70% 40%;
            top: 50%;
            right: 5%;
            animation: float 27s infinite ease-in-out;
        }

        @keyframes float {
            0%, 100% { transform: translateY(0) rotate(0deg); }
            50% { transform: translateY(-40px) rotate(15deg); }
        }

        .particles {
            position: fixed;
            width: 100%;
            height: 100%;
            overflow: hidden;
            pointer-events: none;
            top: 0;
            left: 0;
            z-index: 1;
        }

        .particle {
            position: fixed;
            width: 4px;
            height: 4px;
            background: rgba(255, 255, 255, 0.5);
            border-radius: 50%;
            animation: particle-float linear infinite;
            pointer-events: none;
        }

        @keyframes particle-float {
            0% {
                opacity: 0;
                transform: translateY(100vh) translateX(0);
            }
            10% {
                opacity: 1;
            }
            90% {
                opacity: 1;
            }
            100% {
                opacity: 0;
                transform: translateY(-100vh) translateX(100px);
            }
        }

        body {
            margin: 0;
            padding: 0;
            overflow-x: hidden;
        }

        .content-wrapper {
            position: relative;
            z-index: 10;
            background: transparent;
            min-height: 100vh;
        }

        .dropzone {
            transition: all 0.3s ease;
            border: 2px dashed rgba(255, 255, 255, 0.3);
        }

        .dropzone.drag-over {
            background: rgba(59, 130, 246, 0.2) !important;
            border-color: rgba(59, 130, 246, 0.8) !important;
            transform: scale(1.02);
        }

        .file-input {
            display: none;
        }

        .image-preview {
            animation: slideInUp 0.5s ease-out;
        }

        @keyframes slideInUp {
            from {
                opacity: 0;
                transform: translateY(20px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        .gallery-item {
            animation: scaleIn 0.4s ease-out;
        }

        @keyframes scaleIn {
            from {
                opacity: 0;
                transform: scale(0.8);
            }
            to {
                opacity: 1;
                transform: scale(1);
            }
        }

        .spinner {
            border: 4px solid rgba(255, 255, 255, 0.2);
            border-top: 4px solid #3b82f6;
            border-radius: 50%;
            width: 40px;
            height: 40px;
            animation: spin 1s linear infinite;
        }

        @keyframes spin {
            0% { transform: rotate(0deg); }
            100% { transform: rotate(360deg); }
        }

        .modal {
            animation: fadeIn 0.3s ease-out;
        }

        @keyframes fadeIn {
            from {
                opacity: 0;
            }
            to {
                opacity: 1;
            }
        }

        .modal-content {
            animation: zoomIn 0.3s ease-out;
        }

        @keyframes zoomIn {
            from {
                opacity: 0;
                transform: scale(0.9);
            }
            to {
                opacity: 1;
                transform: scale(1);
            }
        }

        .image-wrapper {
            position: relative;
            overflow: hidden;
            border-radius: 1rem;
        }

        .image-wrapper img {
            transition: transform 0.3s ease;
        }

        .image-wrapper:hover img {
            transform: scale(1.1);
        }

        @keyframes slideDown {
            from {
                opacity: 0;
                transform: translateY(-20px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        .toast {
            animation: slideDown 0.4s ease-out;
        }

        .upload-progress {
            height: 4px;
            background: rgba(255, 255, 255, 0.1);
            border-radius: 2px;
            overflow: hidden;
        }

        .progress-bar {
            height: 100%;
            background: linear-gradient(90deg, #3b82f6, #8b5cf6);
            width: 0%;
            transition: width 0.3s ease;
        }
    </style>
</head>
<body>
    <div class="animated-bg"></div>
    <div class="shape shape-1"></div>
    <div class="shape shape-2"></div>
    <div class="shape shape-3"></div>
    <div class="particles" id="particles-container"></div>

    <div class="content-wrapper">
        <nav class="backdrop-blur-2xl bg-white/5 border-b border-white/10 sticky top-0 z-50">
            <div class="max-w-7xl mx-auto px-6 py-4 flex justify-between items-center">
                <div class="flex items-center gap-3">
                    <div class="p-2.5 bg-gradient-to-br from-blue-500 to-purple-600 rounded-lg">
                        <svg class="w-6 h-6 text-white" fill="currentColor" viewBox="0 0 20 20">
                            <path d="M4 3a2 2 0 00-2 2v10a2 2 0 002 2h12a2 2 0 002-2V5a2 2 0 00-2-2H4zm12 12H4l4.5-4.5 3 3 4-4 2.5 2.5V5a.5.5 0 00-.5-.5h-11a.5.5 0 00-.5.5v10z"></path>
                        </svg>
                    </div>
                    <h1 class="text-3xl font-bold bg-gradient-to-r from-blue-400 to-purple-400 bg-clip-text text-transparent">Gian's Gallery</h1>
                </div>
            </div>
        </nav>

        <div class="max-w-7xl mx-auto px-6 py-12">
            @if(session('success'))
                <div class="toast mb-8 backdrop-blur-md bg-green-500/20 border border-green-400/50 rounded-xl p-4 flex items-center gap-4">
                    <div class="flex-shrink-0">
                        <svg class="h-6 w-6 text-green-400" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"></path>
                        </svg>
                    </div>
                    <div>
                        <p class="text-green-200 font-semibold">Success!</p>
                        <p class="text-green-200/80 text-sm">{{ session('success') }}</p>
                    </div>
                </div>
            @endif

            <div class="grid grid-cols-1 lg:grid-cols-2 gap-8 mb-12">
                <div class="backdrop-blur-2xl bg-white/10 border border-white/20 rounded-3xl shadow-2xl p-8">
                    <div class="flex items-center gap-3 mb-6">
                        <div class="p-3 bg-blue-500/20 rounded-lg">
                            <svg class="w-6 h-6 text-blue-400" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M4 3a2 2 0 00-2 2v10a2 2 0 002 2h12a2 2 0 002-2V5a2 2 0 00-2-2H4zm12 12H4l4.5-4.5 3 3 4-4 2.5 2.5V5a.5.5 0 00-.5-.5h-11a.5.5 0 00-.5.5v10z" clip-rule="evenodd"></path>
                            </svg>
                        </div>
                        <h2 class="text-2xl font-bold text-white">Single Upload</h2>
                    </div>

                    <form id="singleUploadForm" action="{{ route('photos.store.single') }}" method="POST" enctype="multipart/form-data">
                        @csrf

                        <div class="dropzone dropzone-single backdrop-blur-md bg-white/5 border-2 border-dashed border-white/30 rounded-2xl p-12 text-center cursor-pointer hover:bg-white/10 transition">
                            <input type="file" name="image" class="file-input" accept="image/*" required>
                            <svg class="w-16 h-16 text-white/60 mx-auto mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                            </svg>
                            <h3 class="text-white font-semibold mb-1">Click or drag image here</h3>
                            <p class="text-white/60 text-sm">PNG, JPG, GIF up to 10MB</p>
                        </div>

                        <div id="singlePreview" class="mt-4 hidden">
                            <div class="image-preview relative">
                                <img id="singlePreviewImg" src="" alt="Preview" class="w-full h-64 object-cover rounded-xl">
                                <button type="button" id="clearSinglePreview" class="absolute top-3 right-3 bg-red-500/80 hover:bg-red-600 text-white p-2 rounded-lg transition">
                                    <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20">
                                        <path fill-rule="evenodd" d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z" clip-rule="evenodd"></path>
                                    </svg>
                                </button>
                            </div>
                        </div>

                        <div id="singleProgress" class="mt-4 hidden">
                            <div class="upload-progress">
                                <div class="progress-bar" id="singleProgressBar"></div>
                            </div>
                            <p class="text-white/60 text-sm mt-2 text-center"><span id="singleProgressPercent">0</span>%</p>
                        </div>

                        <button type="submit" class="w-full mt-6 py-3 px-6 bg-gradient-to-r from-blue-500 to-blue-600 hover:from-blue-600 hover:to-blue-700 text-white font-semibold rounded-lg transition duration-300 transform hover:scale-105 shadow-lg flex items-center justify-center gap-2">
                            <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M3 17a1 1 0 011-1h12a1 1 0 110 2H4a1 1 0 01-1-1zm3.293-7.707a1 1 0 011.414 0L9 10.586V3a1 1 0 112 0v7.586l1.293-1.293a1 1 0 111.414 1.414l-3 3a1 1 0 01-1.414 0l-3-3a1 1 0 010-1.414z" clip-rule="evenodd"></path>
                            </svg>
                            Upload Image
                        </button>
                    </form>
                </div>

                <div class="backdrop-blur-2xl bg-white/10 border border-white/20 rounded-3xl shadow-2xl p-8">
                    <div class="flex items-center gap-3 mb-6">
                        <div class="p-3 bg-purple-500/20 rounded-lg">
                            <svg class="w-6 h-6 text-purple-400" fill="currentColor" viewBox="0 0 20 20">
                                <path d="M5 3a2 2 0 00-2 2v6h16V5a2 2 0 00-2-2H5z"></path>
                                <path fill-rule="evenodd" d="M3 11v5a2 2 0 002 2h10a2 2 0 002-2v-5H3zm11.793.793a1 1 0 000 1.414l2 2a1 1 0 001.414-1.414l-2-2a1 1 0 00-1.414 0z" clip-rule="evenodd"></path>
                            </svg>
                        </div>
                        <h2 class="text-2xl font-bold text-white">Multiple Upload</h2>
                    </div>

                    <form id="multipleUploadForm" action="{{ route('photos.store.multiple') }}" method="POST" enctype="multipart/form-data">
                        @csrf

                        <div class="dropzone dropzone-multiple backdrop-blur-md bg-white/5 border-2 border-dashed border-white/30 rounded-2xl p-12 text-center cursor-pointer hover:bg-white/10 transition">
                            <input type="file" name="images[]" class="file-input" accept="image/*" multiple required>
                            <svg class="w-16 h-16 text-white/60 mx-auto mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                            </svg>
                            <h3 class="text-white font-semibold mb-1">Click or drag images here</h3>
                            <p class="text-white/60 text-sm">Multiple files supported</p>
                        </div>

                        <div id="multiplePreview" class="mt-4 hidden">
                            <div id="previewContainer" class="grid grid-cols-2 gap-3 mb-4"></div>
                            <button type="button" id="clearMultiplePreview" class="w-full py-2 px-4 bg-red-500/20 hover:bg-red-500/30 text-red-300 font-semibold rounded-lg transition">
                                Clear All
                            </button>
                        </div>

                        <div id="multipleProgress" class="mt-4 hidden">
                            <div class="upload-progress">
                                <div class="progress-bar" id="multipleProgressBar"></div>
                            </div>
                            <p class="text-white/60 text-sm mt-2 text-center"><span id="multipleProgressPercent">0</span>%</p>
                        </div>

                        <button type="submit" class="w-full mt-6 py-3 px-6 bg-gradient-to-r from-purple-500 to-purple-600 hover:from-purple-600 hover:to-purple-700 text-white font-semibold rounded-lg transition duration-300 transform hover:scale-105 shadow-lg flex items-center justify-center gap-2">
                            <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M3 17a1 1 0 011-1h12a1 1 0 110 2H4a1 1 0 01-1-1zm3.293-7.707a1 1 0 011.414 0L9 10.586V3a1 1 0 112 0v7.586l1.293-1.293a1 1 0 111.414 1.414l-3 3a1 1 0 01-1.414 0l-3-3a1 1 0 010-1.414z" clip-rule="evenodd"></path>
                            </svg>
                            Upload Images
                        </button>
                    </form>
                </div>
            </div>

            <div>
                <div class="mb-8">
                    <h2 class="text-4xl font-bold text-white mb-2">Recent Upload</h2>
                    <div class="h-1.5 w-32 bg-gradient-to-r from-blue-400 to-purple-400 rounded-full"></div>
                </div>

                @if($photos->count())
                    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-6 mb-12">
                        @foreach($photos as $photo)
                            <div class="gallery-item group">
                                <div class="backdrop-blur-xl bg-white/10 border border-white/20 rounded-2xl overflow-hidden shadow-lg hover:shadow-2xl transition duration-300 h-full flex flex-col">
                                    <div class="image-wrapper relative h-48 bg-gradient-to-br from-blue-500/10 to-purple-500/10">
                                        <img src="{{ asset('images/' . $photo->image) }}" alt="Uploaded Photo" class="w-full h-full object-cover">

                                        <div class="absolute inset-0 bg-black/40 opacity-0 group-hover:opacity-100 transition duration-300 flex items-center justify-center gap-3">
                                            <button type="button" class="view-image-btn p-3 bg-blue-500/80 hover:bg-blue-600 rounded-lg text-white transition transform hover:scale-110" data-image="{{ asset('images/' . $photo->image) }}">
                                                <svg class="w-6 h-6" fill="currentColor" viewBox="0 0 20 20">
                                                    <path d="M10 12a2 2 0 100-4 2 2 0 000 4z"></path>
                                                    <path fill-rule="evenodd" d="M.458 10C1.732 5.943 5.522 3 10 3s8.268 2.943 9.542 7c-1.274 4.057-5.064 7-9.542 7S1.732 14.057.458 10zM14 10a4 4 0 11-8 0 4 4 0 018 0z" clip-rule="evenodd"></path>
                                                </svg>
                                            </button>
                                            <form action="{{ route('photos.destroy', $photo->id) }}" method="POST" class="inline" onsubmit="return confirm('Delete this image?');">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="p-3 bg-red-500/80 hover:bg-red-600 rounded-lg text-white transition transform hover:scale-110">
                                                    <svg class="w-6 h-6" fill="currentColor" viewBox="0 0 20 20">
                                                        <path fill-rule="evenodd" d="M9 2a1 1 0 00-.894.553L7.382 4H4a1 1 0 000 2v10a2 2 0 002 2h8a2 2 0 002-2V6a1 1 0 100-2h-3.382l-.724-1.447A1 1 0 0011 2H9zM7 8a1 1 0 012 0v6a1 1 0 11-2 0V8zm5-1a1 1 0 00-1 1v6a1 1 0 102 0V8a1 1 0 00-1-1z" clip-rule="evenodd"></path>
                                                    </svg>
                                                </button>
                                            </form>
                                        </div>
                                    </div>

                                    <div class="p-4 flex-grow flex flex-col justify-between">
                                        <p class="text-white/80 text-sm truncate">Photo #{{ $photo->id }}</p>
                                        <p class="text-white/50 text-xs mt-2">{{ $photo->created_at->format('M d, Y') }}</p>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>

                    <div class="flex justify-center">
                        <div class="backdrop-blur-xl bg-white/10 border border-white/20 rounded-xl px-8 py-4">
                            {{ $photos->links('pagination::tailwind') }}
                        </div>
                    </div>
                @else
                    <div class="backdrop-blur-xl bg-white/10 border border-white/20 rounded-3xl shadow-2xl p-16 text-center">
                        <svg class="w-24 h-24 text-white/40 mx-auto mb-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                        </svg>
                        <h3 class="text-3xl font-semibold text-white mb-2">No Images Yet</h3>
                        <p class="text-white/60 mb-8">Upload your first image to get started with your beautiful gallery</p>
                    </div>
                @endif
            </div>
        </div>
    </div>

    <div id="imageModal" class="hidden fixed inset-0 z-50 bg-black/80 backdrop-blur-sm flex items-center justify-center p-4">
        <div class="modal modal-content relative max-w-4xl w-full">
            <button type="button" id="closeModal" class="absolute top-4 right-4 bg-white/20 hover:bg-white/30 text-white p-2 rounded-lg transition z-10">
                <svg class="w-6 h-6" fill="currentColor" viewBox="0 0 20 20">
                    <path fill-rule="evenodd" d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z" clip-rule="evenodd"></path>
                </svg>
            </button>
            <img id="modalImage" src="" alt="Full Size Image" class="w-full h-auto rounded-2xl">
        </div>
    </div>

    <script>
        const particlesContainer = document.getElementById('particles-container');
        const particleCount = 40;

        for (let i = 0; i < particleCount; i++) {
            const particle = document.createElement('div');
            particle.className = 'particle';
            particle.style.left = Math.random() * 100 + '%';
            particle.style.top = Math.random() * 100 + '%';
            particle.style.animationDuration = (Math.random() * 10 + 15) + 's';
            particle.style.animationDelay = Math.random() * 5 + 's';
            particlesContainer.appendChild(particle);
        }

        const singleDropzone = document.querySelector('.dropzone-single');
        const singleInput = document.querySelector('[name="image"]');
        const singlePreview = document.getElementById('singlePreview');
        const singlePreviewImg = document.getElementById('singlePreviewImg');
        const clearSinglePreview = document.getElementById('clearSinglePreview');

        ['dragenter', 'dragover', 'dragleave', 'drop'].forEach(eventName => {
            singleDropzone.addEventListener(eventName, preventDefaults, false);
        });

        function preventDefaults(e) {
            e.preventDefault();
            e.stopPropagation();
        }

        ['dragenter', 'dragover'].forEach(eventName => {
            singleDropzone.addEventListener(eventName, () => singleDropzone.classList.add('drag-over'), false);
        });

        ['dragleave', 'drop'].forEach(eventName => {
            singleDropzone.addEventListener(eventName, () => singleDropzone.classList.remove('drag-over'), false);
        });

        singleDropzone.addEventListener('drop', (e) => {
            const dt = e.dataTransfer;
            const files = dt.files;
            singleInput.files = files;
            handleSingleFileSelect();
        });

        singleInput.addEventListener('change', handleSingleFileSelect);

        function handleSingleFileSelect() {
            if (singleInput.files.length > 0) {
                const file = singleInput.files[0];
                const reader = new FileReader();
                reader.onload = (e) => {
                    singlePreviewImg.src = e.target.result;
                    singlePreview.classList.remove('hidden');
                };
                reader.readAsDataURL(file);
            }
        }

        clearSinglePreview.addEventListener('click', (e) => {
            e.preventDefault();
            singleInput.value = '';
            singlePreview.classList.add('hidden');
        });

        const multipleDropzone = document.querySelector('.dropzone-multiple');
        const multipleInput = document.querySelector('[name="images[]"]');
        const multiplePreview = document.getElementById('multiplePreview');
        const previewContainer = document.getElementById('previewContainer');
        const clearMultiplePreview = document.getElementById('clearMultiplePreview');

        ['dragenter', 'dragover', 'dragleave', 'drop'].forEach(eventName => {
            multipleDropzone.addEventListener(eventName, preventDefaults, false);
        });

        ['dragenter', 'dragover'].forEach(eventName => {
            multipleDropzone.addEventListener(eventName, () => multipleDropzone.classList.add('drag-over'), false);
        });

        ['dragleave', 'drop'].forEach(eventName => {
            multipleDropzone.addEventListener(eventName, () => multipleDropzone.classList.remove('drag-over'), false);
        });

        multipleDropzone.addEventListener('drop', (e) => {
            const dt = e.dataTransfer;
            const files = dt.files;
            multipleInput.files = files;
            handleMultipleFileSelect();
        });

        multipleInput.addEventListener('change', handleMultipleFileSelect);

        function handleMultipleFileSelect() {
            previewContainer.innerHTML = '';
            if (multipleInput.files.length > 0) {
                multiplePreview.classList.remove('hidden');
                Array.from(multipleInput.files).forEach((file, index) => {
                    const reader = new FileReader();
                    reader.onload = (e) => {
                        const previewItem = document.createElement('div');
                        previewItem.className = 'image-preview relative';
                        previewItem.innerHTML = `
                            <img src="${e.target.result}" alt="Preview ${index + 1}" class="w-full h-32 object-cover rounded-lg">
                            <button type="button" class="remove-file-btn absolute top-1 right-1 bg-red-500/80 hover:bg-red-600 text-white p-1 rounded transition" data-index="${index}">
                                <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z" clip-rule="evenodd"></path>
                                </svg>
                            </button>
                        `;
                        previewContainer.appendChild(previewItem);

                        previewItem.querySelector('.remove-file-btn').addEventListener('click', (e) => {
                            e.preventDefault();
                            const dataTransfer = new DataTransfer();
                            Array.from(multipleInput.files).forEach((f, i) => {
                                if (i !== index) {
                                    dataTransfer.items.add(f);
                                }
                            });
                            multipleInput.files = dataTransfer.files;
                            handleMultipleFileSelect();
                        });
                    };
                    reader.readAsDataURL(file);
                });
            } else {
                multiplePreview.classList.add('hidden');
            }
        }

        clearMultiplePreview.addEventListener('click', (e) => {
            e.preventDefault();
            multipleInput.value = '';
            multiplePreview.classList.add('hidden');
        });

        const imageModal = document.getElementById('imageModal');
        const modalImage = document.getElementById('modalImage');
        const closeModal = document.getElementById('closeModal');

        document.querySelectorAll('.view-image-btn').forEach(btn => {
            btn.addEventListener('click', (e) => {
                e.preventDefault();
                e.stopPropagation();
                modalImage.src = btn.dataset.image;
                imageModal.classList.remove('hidden');
            });
        });

        closeModal.addEventListener('click', () => {
            imageModal.classList.add('hidden');
        });

        imageModal.addEventListener('click', (e) => {
            if (e.target === imageModal) {
                imageModal.classList.add('hidden');
            }
        });

        document.addEventListener('keydown', (e) => {
            if (e.key === 'Escape') {
                imageModal.classList.add('hidden');
            }
        });

        document.getElementById('singleUploadForm').addEventListener('submit', function(e) {
            const progress = document.getElementById('singleProgress');
            const progressBar = document.getElementById('singleProgressBar');
            const progressPercent = document.getElementById('singleProgressPercent');
            
            progress.classList.remove('hidden');
            let percent = 0;
            const interval = setInterval(() => {
                percent += Math.random() * 30;
                if (percent > 90) percent = 90;
                progressBar.style.width = percent + '%';
                progressPercent.textContent = Math.round(percent);
            }, 200);
        });

        document.getElementById('multipleUploadForm').addEventListener('submit', function(e) {
            const progress = document.getElementById('multipleProgress');
            const progressBar = document.getElementById('multipleProgressBar');
            const progressPercent = document.getElementById('multipleProgressPercent');
            
            progress.classList.remove('hidden');
            let percent = 0;
            const interval = setInterval(() => {
                percent += Math.random() * 30;
                if (percent > 90) percent = 90;
                progressBar.style.width = percent + '%';
                progressPercent.textContent = Math.round(percent);
            }, 200);
        });
    </script>
</body>
</html>