<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ config('app.name', 'Pencatatan Tamu') }}</title>

    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />

    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <style>
        /* Camera styles */
        #camera-container {
            position: relative;
            width: 100%;
            overflow: hidden;
            margin-bottom: 1rem;
            aspect-ratio: 4/3;
        }

        #video,
        #canvas,
        #photoPreview {
            width: 100%;
            height: 100%;
            object-fit: cover;
            border-radius: 0.375rem;
            border: 1px solid #e5e7eb
        }

        #photoPreview {
            display: none;
        }

        .camera-controls {
            display: flex;
            justify-content: center;
            gap: 1rem;
            margin-top: 0.5rem;
        }

        .btn-camera {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            padding: 0.5rem 1rem;
            background-color: #3b82f6;
            color: #ffffff;
            font-weight: 500;
            border-radius: 0.375rem;
            cursor: pointer;
            transition: background-color 0.15s;
        }

        .btn-camera:hover {
            background-color: #2563eb;
        }

        .btn-camera.btn-retake {
            background-color: #6b7280;
        }

        .btn-camera.btn-retake:hover {
            background-color: #4b5563;
        }

        .success-message {
            animation: fadeIn 0.5s;
        }

        @keyframes fadeIn {
            from {
                opacity: 0;
                transform: translateY(-10px);
            }

            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        @media (max-width: 768px) {
            .form-grid {
                display: block;
            }
        }
    </style>
</head>

<body class="min-h-screen flex items-center justify-center p-4 bg-gray-50">
    <div class="w-full max-w-5xl">
        <!-- Header -->
        <div class="text-center mb-8">
            <img src="{{ asset('logo.jpg') }}" alt="Logo" class="mx-auto mb-4 w-24 h-24">
            <h1 class="text-3xl font-bold text-gray-800">Selamat Datang</h1>
            <p class="text-gray-600 mt-2">Silakan isi data diri Anda untuk melanjutkan</p>
        </div>

        <div class="bg-white shadow-lg rounded-lg overflow-hidden form-container">
            <div class="bg-blue-600 py-4 px-6">
                <h2 class="text-white text-xl font-semibold">Form Pengunjung</h2>
            </div>

            @if (session('success'))
            <div id="successMessage" class="success-message bg-green-100 border-l-4 border-green-500 text-green-700 p-4 mb-4 mx-6 mt-6">
                <div class="flex justify-between items-center">
                    <p>{{ session('success') }}</p>
                    <button onclick="document.getElementById('successMessage').style.display='none'" class="text-green-700 hover:text-green-900">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                        </svg>
                    </button>
                </div>
            </div>
            @endif

            @if ($errors->any())
            <div class="bg-red-100 border-l-4 border-red-500 text-red-700 p-4 mb-4 mx-6 mt-6">
                <p class="font-bold">Terdapat kesalahan pada input:</p>
                <ul class="list-disc ml-5">
                    @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
            @endif

            <form method="POST" action="{{ route('main') }}" class="p-6" enctype="multipart/form-data">
                @csrf

                <div class="grid grid-cols-1 md:grid-cols-2 gap-8 form-grid">
                    <!-- LEFT SIDE - Camera Section -->
                    <div class="space-y-4">
                        <label for="photo" class="block text-sm font-medium text-gray-700 mb-1">Foto Pengunjung <span class="text-red-600">*</span></label>

                        <div id="camera-container">
                            <video id="video" autoplay playsinline></video>
                            <canvas id="canvas" style="display:none;"></canvas>
                            <img id="photoPreview" alt="Preview foto" />
                        </div>

                        <div class="camera-controls">
                            <button type="button" id="startCamera" class="btn-camera">
                                <svg class="w-5 h-5 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 9a2 2 0 012-2h.93a2 2 0 001.664-.89l.812-1.22A2 2 0 0110.07 4h3.86a2 2 0 011.664.89l.812 1.22A2 2 0 0018.07 7H19a2 2 0 012 2v9a2 2 0 01-2 2H5a2 2 0 01-2-2V9z"></path>
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 13a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                </svg>
                                Buka Kamera
                            </button>

                            <button type="button" id="takePhoto" class="btn-camera" style="display:none;">
                                <svg class="w-5 h-5 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                                </svg>
                                Ambil Foto
                            </button>

                            <button type="button" id="retakePhoto" class="btn-camera btn-retake" style="display:none;">
                                <svg class="w-5 h-5 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15"></path>
                                </svg>
                                Ambil Ulang
                            </button>
                        </div>

                        <input type="hidden" name="photo_data" id="photoData">
                        <p class="text-xs text-gray-500 mt-2">Foto akan digunakan untuk keperluan identifikasi pengunjung.</p>
                    </div>

                    <!-- RIGHT SIDE - Form Fields -->
                    <div class="space-y-6">
                        <!-- Nama dan Instansi -->
                        <div>
                            <label for="nama" class="block text-sm font-medium text-gray-700 mb-1">Nama Lengkap <span class="text-red-600">*</span></label>
                            <input type="text" name="nama" id="nama" value="{{ old('nama') }}" required class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm py-2 px-3 focus:outline-none focus:ring-blue-500 focus:border-blue-500 sm:text-sm" placeholder="Masukkan nama lengkap Anda">
                        </div>

                        <div>
                            <label for="instansi" class="block text-sm font-medium text-gray-700 mb-1">Instansi / Perusahaan</label>
                            <input type="text" name="instansi" id="instansi" value="{{ old('instansi') }}" class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm py-2 px-3 focus:outline-none focus:ring-blue-500 focus:border-blue-500 sm:text-sm" placeholder="Nama instansi atau perusahaan">
                        </div>

                        <!-- Kontak -->
                        <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                            <div>
                                <label for="telepon" class="block text-sm font-medium text-gray-700 mb-1">Nomor Telepon</label>
                                <input type="tel" name="telepon" id="telepon" value="{{ old('telepon') }}" class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm py-2 px-3 focus:outline-none focus:ring-blue-500 focus:border-blue-500 sm:text-sm" placeholder="Contoh: 08123456789">
                            </div>

                            <div>
                                <label for="email" class="block text-sm font-medium text-gray-700 mb-1">Email</label>
                                <input type="email" name="email" id="email" value="{{ old('email') }}" class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm py-2 px-3 focus:outline-none focus:ring-blue-500 focus:border-blue-500 sm:text-sm" placeholder="contoh@email.com">
                            </div>
                        </div>

                        <!-- Keperluan -->
                        <div>
                            <label for="keperluan" class="block text-sm font-medium text-gray-700 mb-1">Keperluan <span class="text-red-600">*</span></label>
                            <textarea name="keperluan" id="keperluan" rows="4" required class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm py-2 px-3 focus:outline-none focus:ring-blue-500 focus:border-blue-500 sm:text-sm" placeholder="Jelaskan keperluan Anda secara singkat">{{ old('keperluan') }}</textarea>
                        </div>

                        <!-- Submit Button -->
                        <div class="flex justify-end pt-4">
                            <button type="submit" id="submitBtn" class="inline-flex items-center px-6 py-3 border border-transparent text-base font-medium rounded-md shadow-sm text-white bg-blue-600 hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 transition duration-150">
                                <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                                </svg>
                                Kirim Data
                            </button>
                        </div>
                    </div>
                </div>
            </form>
        </div>

        <!-- Footer -->
        <div class="text-center mt-8 text-gray-500 text-sm">
            <p>&copy; {{ date('Y') }} Sistem Pencatatan Tamu. All rights reserved.</p>
        </div>
    </div>

    <script>
        // Telephone input constraint
        document.getElementById('telepon').addEventListener('input', function(e) {
            this.value = this.value.replace(/[^0-9]/g, '');
        });

        // Success message auto-hide
        document.addEventListener('DOMContentLoaded', function() {
            const successMessage = document.getElementById('successMessage');
            if (successMessage) {
                setTimeout(function() {
                    successMessage.style.display = 'none';
                }, 5000);
            }

            @if(session('success'))
            document.querySelector('form').reset();
            // Reset camera preview
            photoPreview.style.display = 'none';
            retakeButton.style.display = 'none';
            startButton.style.display = 'inline-flex';
            photoData.value = '';
            @endif
        });

        // Camera functionality
        let stream;
        let video = document.getElementById('video');
        let canvas = document.getElementById('canvas');
        let photoPreview = document.getElementById('photoPreview');
        let photoData = document.getElementById('photoData');
        let startButton = document.getElementById('startCamera');
        let takePhotoButton = document.getElementById('takePhoto');
        let retakeButton = document.getElementById('retakePhoto');
        let context = canvas.getContext('2d');
        let photoTaken = false;

        // Start camera button
        startButton.addEventListener('click', async function() {
            try {
                stream = await navigator.mediaDevices.getUserMedia({
                    video: {
                        facingMode: 'user',
                        width: {
                            ideal: 480
                        },
                        height: {
                            ideal: 360
                        }
                    },
                    audio: false
                });

                video.srcObject = stream;
                startButton.style.display = 'none';
                takePhotoButton.style.display = 'inline-flex';
                video.style.display = 'block';
                photoPreview.style.display = 'none';
            } catch (err) {
                console.error('Gagal mengakses kamera: ', err);
                alert('Maaf, kamera tidak dapat diakses. Pastikan kamera Anda aktif dan berikan izin akses kamera.');
            }
        });

        // Take photo button
        takePhotoButton.addEventListener('click', function() {
            canvas.width = video.videoWidth;
            canvas.height = video.videoHeight;
            context.drawImage(video, 0, 0, canvas.width, canvas.height);

            // Optimize the image before sending
            let dataUrl = canvas.toDataURL('image/jpeg', 0.8); // 80% quality JPEG
            photoData.value = dataUrl;

            // Display the photo preview
            photoPreview.src = dataUrl;
            video.style.display = 'none';
            photoPreview.style.display = 'block';

            // Stop camera stream
            if (stream) {
                stream.getTracks().forEach(track => track.stop());
            }

            // Update buttons
            takePhotoButton.style.display = 'none';
            retakeButton.style.display = 'inline-flex';
            photoTaken = true;
        });

        // Retake photo button
        retakeButton.addEventListener('click', async function() {
            try {
                stream = await navigator.mediaDevices.getUserMedia({
                    video: {
                        facingMode: 'user',
                        width: {
                            ideal: 480
                        },
                        height: {
                            ideal: 360
                        }
                    },
                    audio: false
                });

                video.srcObject = stream;
                photoPreview.style.display = 'none';
                video.style.display = 'block';
                takePhotoButton.style.display = 'inline-flex';
                retakeButton.style.display = 'none';
                photoTaken = false;
            } catch (err) {
                console.error('Gagal mengakses kamera: ', err);
                alert('Maaf, kamera tidak dapat diakses. Pastikan kamera Anda aktif dan berikan izin akses kamera.');
            }
        });

        // Form validation for photo
        document.querySelector('form').addEventListener('submit', function(e) {
            if (!photoData.value) {
                e.preventDefault();
                alert('Harap ambil foto terlebih dahulu');

                // Scroll to camera section
                document.getElementById('camera-container').scrollIntoView({
                    behavior: 'smooth'
                });
            }
        });
    </script>
</body>

</html>