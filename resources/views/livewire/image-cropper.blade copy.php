<div class="container py-6" x-data="ImageCropper" wire:replace>
    <!-- File Input -->
    <input type="file" class="form-control" wire:model="image" accept="image/*" @change="showModal = true">

    <!-- Display Preview -->
    @if ($image)
        <img src="{{ $image->temporaryUrl() }}" id="image-to-crop" style="max-width: 500px;" x-show="!showModal">
    @endif

    <!-- Cropping Modal -->
    <div x-show="showModal" class="fixed inset-0 bg-gray-800 bg-opacity-75 flex items-center justify-center">
        <div class="bg-white p-4 rounded">
            <img id="cropper-image" src="{{ $image ? $image->temporaryUrl() : '' }}" style="max-width: 500px;">
            <button @click="cropImage" class="mt-2 bg-blue-500 text-white px-4 py-2 rounded">Crop</button>
            <button @click="showModal = false" class="mt-2 bg-gray-500 text-white px-4 py-2 rounded">Cancel</button>
        </div>
    </div>

    <!-- Success Message -->
    @if (session()->has('message'))
        <div class="text-green-500">{{ session('message') }}</div>
    @endif

    @push('scripts')
        <link href="https://unpkg.com/cropperjs/dist/cropper.min.css" rel="stylesheet">
        {{-- <script src="https://unpkg.com/cropperjs/dist/cropper.min.js"></script> --}}
    @endpush

    <script>
        document.addEventListener('alpine:init', () => {
            Alpine.data('ImageCropper', () => ({
                showModal: false,
                imageUrl: '',
                cropper: null,
                init() {
                    console.log('Cropper available:', window
                        .Cropper);
                    this.$watch('showModal', value => {
                        if (value) {
                            this.$nextTick(() => {
                                console.log('Cropper available:', window
                                    .Cropper); // Verify Cropper
                                const image = document.getElementById('cropper-image');
                                this.cropper = new Cropper(image, {
                                    aspectRatio: 1, // Square crop
                                    viewMode: 1,
                                });
                            });
                        }
                    });
                },
                cropImage() {
                    console.log('Crop image');
                    const canvas = this.cropper.getCroppedCanvas();
                    this.$wire.set('croppedImage', canvas.toDataURL('image/png'));
                    this.showModal = false;
                    this.cropper.destroy();
                    this.$wire.call('saveCroppedImage');
                }
            }));
        });
    </script>
</div>
