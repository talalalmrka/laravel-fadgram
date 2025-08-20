<div class="container py-6" x-data="ImageCropper">
    <fgx:file id="image" wire:model.live="image" :label="__('Image')" :previews="$previewsImage" />

    <x-modal show="showModal" :title="__('Crop image')">
        <div class="cropper-container">
            @if ($image)
                <img src="{{ $image->temporaryUrl() }}" id="cropper-image" x-ref="image" alt="Image to crop">
            @endif
        </div>
        <div class="flex-space-2 flex-wrap mt-4 flex-1">
            <button type="button" class="nav-link" id="zoomInBtn"><i class="icon bi-plus-circle"></i></button>
            <button type="button" class="nav-link" id="zoomOutBtn"><i class="icon bi-dash-circle"></i></button>
            <button type="button" class="nav-link" id="rotateLeftBtn"><i
                    class="icon bi-arrow-counterclockwise"></i></button>
            <button type="button" class="nav-link" id="rotateRightBtn"><i class="icon bi-arrow-clockwise"></i></button>
            <button type="button" class="nav-link" id="resetBtn"><i class="icon bi-repeat"></i></button>
            <select id="selectionAspectRatio" class="" name="aspectRatio">
                <option value="NaN"> Free </option>
                <option value="1"> 1:1 (Square) </option>
                <option value="1.7777777777777777" selected> 16:9 (Widescreen) </option>
                <option value="1.3333333333333333"> 4:3 (Portrait) </option>
                <option value="0.75"> 3:4 (Portrait) </option>
                <option value="0.5625"> 9:16 (Portrait) </option>
            </select>
        </div>
        <x-slot name="footer">
            <div class="flex-space-2 justify-end">
                <button type="button" class="btn btn-secondary btn-sm" x-on:click="closeModal">
                    {{ __('Close') }}
                </button>
                <button x-on:click="cropImage" type="button"
                    class="btn btn-primary btn-sm">
                    <i class="icon bi-crop"></i>
                    <span wire:loading.remove wire:target="saveCroppedImage">{{ __('Crop') }}</span>
                    <fgx:loader wire:loading wire:target="saveCroppedImage" />
                </button>
            </div>
        </x-slot>
    </x-modal>



    @if (session()->has('message'))
        <div class="text-green-500">{{ session('message') }}</div>
    @endif
</div>


@assets
    @vite(['resources/js/cropper.js', 'resources/css/cropper.css'])
@endassets
@script
    <script>
        Alpine.data('ImageCropper', () => ({
            listeners: [],
            cropper: null,
            image: null,
            showModal: false,
            init() {
                this.listeners.push(
                    Livewire.on('crop', () => {
                        console.log('start cropper');
                        this.$nextTick(() => {
                            // this.image = document.getElementById('cropper-image');
                            this.image = this.$refs.image;
                            // console.log('image', this.image);
                            if (!this.image) return;

                            this.image.onload = () => this
                                .initCropper(); // Ensure image is fully loaded
                            if (this.image.complete) {
                                this.initCropper();
                            }
                        });

                    })
                );
            },

            initCropper() {
                this.$wire.showModal = true;
                if (this.cropper) {
                    this.cropper.destroy();
                }

                this.cropper = new Cropper(this.image, {
                    viewMode: 2,
                    aspectRatio: 1.7777777777777777,
                    dragMode: 'move',
                    autoCropArea: 1,
                    restore: false,
                    movable: true,
                    rotatable: true,
                    zoomable: true,
                    minCanvasWidth: 300,
                    minCanvasHeight: 300,
                    background: true,
                    responsive: true,
                    // preview: '#preview',
                    crop: function(event) {
                        // Update preview dynamically
                    }
                });
            },

            cropImage() {
                if (!this.cropper) return;
                // const canvas = this.cropper.getCroppedCanvas();
                const canvas = this.cropper.getCroppedCanvas({
                    width: this.image.naturalWidth,
                    height: this.image.naturalHeight,
                    fillColor: '#fff',
                    imageSmoothingEnabled: true,
                    imageSmoothingQuality: 'high'
                });
                this.$wire.set('croppedImage', canvas.toDataURL('image/png'));
                this.cropper.destroy();
                this.$wire.call('saveCroppedImage');
            },
            destroy() {
                this.listeners.forEach((listener) => {
                    listener();
                });
            }
        }));
    </script>
@endscript
