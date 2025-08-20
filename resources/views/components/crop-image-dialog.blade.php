@props([
    'title' => __('Crop image'),
    'titleIcon' => 'bi-crop',
    // 'show' => 'showCrop',
    'class' => null,
    'headerClass' => null,
    'titleClass' => null,
    'bodyClass' => '',
    'footerClass' => '',
    // 'imageUrl' => null,
    // 'save' => 'saveCroppedImage',
    'model' => 'croppedImage',
    'showCrop' => false,
])
<div x-data="ImageCropper">
    <div class="modal-backdrop show" x-show="showModal" x-on:click="close"></div>
    <div x-show="showModal" x-transition
        class="{{ css_classes(['modal fade show', $class => $class]) }}" wire:ignore x-cloak>
        <div class="modal-dialog">
            <div class="modal-content">
                @if ($title)
                    <div class="{{ css_classes(['modal-header', $headerClass => $headerClass]) }}">
                        <h5
                            class="{{ css_classes(['modal-title', $titleClass => $titleClass, 'flex-space-2' => $titleIcon]) }}">
                            @icon($titleIcon)
                            <span>{{ $title ?? '' }}</span>
                        </h5>
                        <button type="button" class="btn-close" x-on:click="close">
                            <i class="icon bi-x-lg"></i>
                        </button>
                    </div>
                @endif
                <div class="{{ css_classes(['modal-body', $bodyClass => $bodyClass]) }}">
                    <div class="grid gap-4 grid-cols-1 md:grid-cols-4 h-full">
                        <div class="col md:col-span-3">
                            <div class="cropper-container">
                                <img src="" id="cropper-image" x-ref="image" alt="Image to crop">
                            </div>
                            Show crop: {{ $showCrop }}
                        </div>
                        <div class="col h-full overflow-y-auto">
                            <div class="grid grid-cols-2 gap-4">
                                <div class="col">
                                    <button type="button" x-on:click="zoomIn" class="btn btn-sm btn-primary">
                                        <i class="icon bi-plus-circle"></i>
                                    </button>
                                </div>
                                <div class="col">
                                    <button type="button" x-on:click="zoomOut" class="btn btn-sm btn-primary">
                                        <i class="icon bi-dash-circle"></i>
                                    </button>
                                </div>
                                <div class="col">
                                    <button type="button" x-on:click="rotateLeft" class="btn btn-sm btn-green">
                                        <i class="icon bi-arrow-counterclockwise"></i>
                                    </button>
                                </div>
                                <div class="col">
                                    <button type="button" x-on:click="rotateRight" class="btn btn-sm btn-green">
                                        <i class="icon bi-arrow-clockwise"></i>
                                    </button>
                                </div>
                                <div class="col">
                                    <button type="button" x-on:click="flipX" class="btn btn-sm btn-violet">
                                        <i class="icon bi-arrows-expand-vertical"></i>
                                    </button>
                                </div>
                                <div class="col">
                                    <button type="button" x-on:click="flipY" class="btn btn-sm btn-violet">
                                        <i class="icon bi-arrows-expand"></i>
                                    </button>
                                </div>
                                <div class="col col-span-2">
                                    <button type="button" x-on:click="reset" class="btn btn-sm btn-blue">
                                        <i class="icon bi-repeat"></i>
                                    </button>
                                </div>
                                <div class="col col-span-2">
                                    <fgx:label :label="__('Aspect ratio')" />
                                    <select x-on:change="onAspectRatioChanged" class="form-select sm">
                                        <option value="NaN"> Free </option>
                                        <option value="1"> 1:1 (Square) </option>
                                        <option value="1.7777777777777777" selected> 16:9 (Widescreen) </option>
                                        <option value="1.3333333333333333"> 4:3 (Portrait) </option>
                                        <option value="0.75"> 3:4 (Portrait) </option>
                                        <option value="0.5625"> 9:16 (Portrait) </option>
                                    </select>
                                </div>
                                <div class="col col-span-2">
                                    <fgx:label :label="__('View mode')" />
                                    <select x-on:change="onViewModeChanged" class="form-select sm">
                                        <option value="0">0</option>
                                        <option value="1">1</option>
                                        <option value="2">2</option>
                                        <option value="3" selected>3</option>
                                    </select>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="{{ css_classes(['modal-footer', $footerClass => $footerClass]) }}">
                    <div class="flex-space-2 justify-between w-full">
                        <button type="button" class="btn btn-secondary btn-sm" x-on:click="close">
                            {{ __('Close') }}
                        </button>
                        <button x-on:click="cropImage" type="button"
                            class="btn btn-primary btn-sm">
                            <i class="icon bi-crop"></i>
                            <span x-show="!uploading">{{ __('Crop') }}</span>
                            <i class="icon fg-loader-dots-move" x-show="uploading"></i>
                        </button>
                    </div>
                </div>
            </div>
        </div><!-- Modal Dialog -->
    </div><!-- Modal -->
</div>


@assets
    @vite(['resources/js/cropper.js', 'resources/css/cropper.css'])
@endassets
@script
    <script>
        Alpine.data('ImageCropper', () => ({
            showModal: false,
            listeners: [],
            cropper: null,
            image: null,
            model: null,
            uploading: false,
            // imageUrl: null,
            fx: 1,
            fy: 1,
            open() {
                this.showModal = true;
            },
            close() {
                this.showModal = false;
            },
            init() {
                this.$nextTick(() => {
                    this.image = this.$refs.image;
                    this.listeners.push(
                        Livewire.on('crop', (data) => {
                            console.log('start cropper', data);
                            this.open();
                            this.image.src = data.url;
                            this.model = data.model;
                            this.image.onload = () => this.initCropper();
                            if (this.image.complete) {
                                this.initCropper();
                            }
                        })
                    );
                });
            },
            initCropper() {
                this.$wire.showModal = true;
                if (this.cropper) {
                    this.cropper.destroy();
                }
                this.cropper = new Cropper(this.image, {
                    viewMode: 3,
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
            zoomIn() {
                this.cropper.zoom(0.1);
            },
            zoomOut() {
                this.cropper.zoom(-0.1);
            },
            rotateLeft() {
                this.cropper.rotate(-90);
            },
            rotateRight() {
                this.cropper.rotate(90);
            },
            flipX() {
                this.fx = this.fx === 1 ? -1 : 1;
                this.cropper.scaleX(this.fx);
            },
            flipY() {
                this.fy = this.fy === 1 ? -1 : 1;
                this.cropper.scaleY(this.fy);
            },
            onAspectRatioChanged(event) {
                const ratio = parseFloat(event.target.value);
                this.cropper.setAspectRatio(isNaN(ratio) ? NaN : ratio);
            },
            onViewModeChanged(event) {
                this.cropper.viewMode = event.target.value;
            },
            reset() {
                this.cropper.reset();
            },
            cropImage() {
                if (!this.cropper) return;
                const canvas = this.cropper.getCroppedCanvas({
                    width: this.image.naturalWidth,
                    height: this.image.naturalHeight,
                    fillColor: '#fff',
                    imageSmoothingEnabled: true,
                    imageSmoothingQuality: 'high'
                });

                this.uploading = true;
                canvas.toBlob((blob) => {
                    if (!blob) {
                        alert('Failed to create image blob');
                        this.uploading = false;
                        return;
                    }

                    // Create a File object with proper filename and type
                    const file = new File([blob], 'cropped-image.png', {
                        type: blob.type || 'image/png'
                    });
                    /* this.$wire.$set(this.model, file);
                    this.$nextTick(() => {
                        this.uploading = false;
                        this.$wire.$toggle('showCrop');
                    }); */
                    this.$wire.upload(
                        this.model,
                        file,
                        (uploadedFilename) => {
                            this.uploading = false;
                            this.close();
                            this.$nextTick(() => {
                                this.$wire.$toggle('showCrop');
                            });

                        },
                        () => {
                            alert('Error uploading cropped image');
                            this.uploading = false;
                        },
                        (event) => {
                            const progress = event.detail.progress;
                            console.log('Upload progress:', progress);
                        }
                    );
                });
            },
            cropImagee() {
                if (!this.cropper) return;
                // const canvas = this.cropper.getCroppedCanvas();
                const canvas = this.cropper.getCroppedCanvas({
                    width: this.image.naturalWidth,
                    height: this.image.naturalHeight,
                    fillColor: '#fff',
                    imageSmoothingEnabled: true,
                    imageSmoothingQuality: 'high'
                });
                this.uploading = true;
                canvas.toBlob((blob) => {
                    // Convert to Base64 for form submission
                    const reader = new FileReader();
                    reader.readAsDataURL(blob);
                    reader.onloadend = () => {
                        this.$wire.upload(this.model, reader.result, (uploadedFilename) => {
                            // Success
                            this.$wire.$dispatch('cropped');
                            this.uploading = false;
                        }, () => {
                            // Error
                            alert('Error in crop');
                            this.uploading = false;
                        }, (event) => {
                            // Progress callback...
                            // event.detail.progress contains a number between 1 and 100 as the upload progresses
                            const progress = event.detail.progress;
                            console.log('progress', progress);
                        }, () => {
                            // Cancelled callback...
                            this.uploading = false;
                        })
                    };
                });
            },
            destroy() {
                if (this.cropper) {
                    this.cropper.destroy();
                }
                this.listeners.forEach((listener) => {
                    listener();
                });
            }
        }));
    </script>
@endscript
