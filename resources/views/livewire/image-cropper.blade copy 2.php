<div class="container py-6" x-data="ImageCropper">
    <!-- File Input -->
    <input type="file" class="form-control" wire:model="image" accept="image/*" @change="showModal = true">

    <!-- Display Preview -->
    @if ($image)
        <cropper-canvas background>
            <cropper-image src="{{ $image->temporaryUrl() }}" alt="Picture" rotatable scalable skewable
                translatable class="w-full h-auto"></cropper-image>
            <cropper-shade hidden></cropper-shade>
            <cropper-handle action="select" plain></cropper-handle>
            <cropper-selection initial-coverage="0.5" movable resizable>
                <cropper-grid role="grid" covered></cropper-grid>
                <cropper-crosshair centered></cropper-crosshair>
                <cropper-handle action="move" theme-color="rgba(255, 255, 255, 0.35)"></cropper-handle>
                <cropper-handle action="n-resize"></cropper-handle>
                <cropper-handle action="e-resize"></cropper-handle>
                <cropper-handle action="s-resize"></cropper-handle>
                <cropper-handle action="w-resize"></cropper-handle>
                <cropper-handle action="ne-resize"></cropper-handle>
                <cropper-handle action="nw-resize"></cropper-handle>
                <cropper-handle action="se-resize"></cropper-handle>
                <cropper-handle action="sw-resize"></cropper-handle>
            </cropper-selection>
        </cropper-canvas>
        <button @click="cropImage" class="mt-2 bg-blue-500 text-white px-4 py-2 rounded">Crop</button>
        <button @click="showModal = false" class="mt-2 bg-gray-500 text-white px-4 py-2 rounded">Cancel</button>
    @endif

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
                    /* this.$nextTick(() => {
                        console.log('Cropper available:', window
                            .Cropper); // Verify Cropper
                        const image = document.getElementById('cropper-image');
                        if (image) {
                            this.cropper = new Cropper(image, {
                                aspectRatio: 1, // Square crop
                                viewMode: 1,
                            });
                        }

                    }); */
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
