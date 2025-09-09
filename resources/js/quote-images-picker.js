document.addEventListener("alpine:init", () => {
    Alpine.data("QuoteImagesPicker", (options) => ({
        shuffle: false,
        shuffling: false,
        reseting: false,
        currentImage: options.currentImage,
        fetchUrl: options.fetchUrl,
        images: options.images,
        realImages: options.images,
        selectedImage: {
            ["x-ref"]: "selectedImage",
        },
        btnShuffle: {
            ["x-ref"]: "btnShuffle",
            async ["@click"]() {
                await this.loadRandomImages();
            },
        },
        btnDownload: {
            ["x-ref"]: "btnDownload",
        },
        btnReset: {
            ["x-ref"]: "btnReset",
            ["@click"]() {
                this.resetImages();
            },
        },
        image: {
            ["x-ref"]: "image",
            ["@click"]() {
                const source = this.$el.dataset.source;
                const download = this.$el.dataset.download;
                this.currentImage = source;
                this.$refs.selectedImage.src = source;
                this.$refs.btnDownload.href = download;
            },
        },
        selectedImageCheck: {
            ["x-show"]() {
                const source = this.$el.dataset.choice;
                const show = this.$el.dataset.choice === this.currentImage;
                return show;
            },
        },
        resetImages() {
            try {
                const data = this.realImages;
                if (!Array.isArray(data) || data.length === 0) {
                    throw new Error("No images returned");
                }
                const first = data[0];
                if (first) {
                    const firstSource = first.source;
                    if (firstSource) {
                        this.currentImage = firstSource;
                        this.$refs.selectedImage.src = firstSource;
                    }
                    const firstDownload = first.download;
                    if (firstDownload) {
                        this.$refs.btnDownload.href = firstDownload;
                    }
                }
                this.images = data;
                this.shuffle = false;
            } catch (e) {
                alert(e);
            }
        },
        async loadRandomImages() {
            this.shuffling = true;
            try {
                let response = await fetch(this.fetchUrl);
                if (!response.ok) {
                    throw new Error("Failed to fetch images");
                }
                let data = await response.json();
                if (!Array.isArray(data) || data.length === 0) {
                    throw new Error("No images returned");
                }
                const first = data[0];
                if (first) {
                    const firstSource = first.source;
                    if (firstSource) {
                        this.currentImage = firstSource;
                        this.$refs.selectedImage.src = firstSource;
                    }
                    const firstDownload = first.download;
                    if (firstDownload) {
                        this.$refs.btnDownload.href = firstDownload;
                    }
                }
                this.images = data;
                this.shuffle = true;
            } catch (e) {
                alert(e);
            } finally {
                this.shuffling = false;
            }
        },
    }));
});
