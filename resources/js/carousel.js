// public/js/carousel.js
/* function carouselData({
    autoplay = true,
    interval = 3500,
    controls = true,
    indicators = true,
    slides = [],
}) {
    return {
        autoplay,
        interval,
        controls,
        indicators,
        slides,
        currentIndex: 1,
        playInterval: null,
        transitionStart: "-translate-x-full",
        transitionEnd: "translate-x-full",
        transitionReverse: false,
        transitionPrev() {
            this.transitionReverse = true;
        },
        transitionNext() {
            this.transitionReverse = false;
        },
        previous() {
            this.transitionPrev();
            this.currentIndex =
                this.currentIndex > 1
                    ? this.currentIndex - 1
                    : this.slides.length;
        },
        next() {
            this.transitionNext();
            this.currentIndex =
                this.currentIndex < this.slides.length
                    ? this.currentIndex + 1
                    : 1;
        },
        play() {
            this.playInterval = setInterval(() => {
                this.next();
            }, this.interval);
        },
        pause() {
            if (this.playInterval) {
                clearInterval(this.playInterval);
                this.playInterval = null;
            }
        },
        playPause() {
            if (this.playInterval) {
                this.pause();
            } else {
                this.play();
            }
        },
        forward() {
            this.reset();
            this.next();
            if (this.autoplay) this.play();
        },
        backward() {
            this.reset();
            this.previous();
            if (this.autoplay) this.play();
        },
        step(index) {
            this.reset();
            this.transitionReverse = index + 1 < this.currentIndex;
            this.currentIndex = index + 1;
            if (this.autoplay) this.play();
        },
        reset() {
            if (this.playInterval) clearInterval(this.playInterval);
            this.playInterval = null;
        },
    };
} */
document.addEventListener("alpine:init", () => {
    Alpine.data(
        "carousel",
        ({
            autoplay = true,
            duration = 700,
            interval = 3500,
            controls = true,
            indicators = true,
            slides = [],
        }) => ({
            autoplay,
            duration,
            interval,
            controls,
            indicators,
            slides,
            currentIndex: 1,
            playInterval: null,
            transitionStart: "-translate-x-full",
            transitionEnd: "translate-x-full",
            transitionReverse: false,
            get durationClass() {
                const durations = {
                    100: "duration-150",
                    150: "duration-150",
                    200: "duration-200",
                    300: "duration-300",
                    400: "duration-400",
                    500: "duration-500",
                    600: "duration-600",
                    700: "duration-700",
                    800: "duration-800",
                    900: "duration-900",
                    1000: "duration-1000",
                    1500: "duration-1500",
                    2000: "duration-2000",
                };
                return durations[this.duration] ?? `duration-${this.duration}`;
            },
            btnPrev: {
                ["@click"]() {
                    this.backward();
                },
            },
            btnNext: {
                ["@click"]() {
                    this.forward();
                },
            },
            btnPlayPause: {
                ["@click"]() {
                    this.playPause();
                },
            },
            transitionPrev() {
                this.transitionReverse = true;
            },
            transitionNext() {
                this.transitionReverse = false;
            },
            previous() {
                this.transitionPrev();
                this.currentIndex =
                    this.currentIndex > 1
                        ? this.currentIndex - 1
                        : this.slides.length;
            },
            next() {
                this.transitionNext();
                this.currentIndex =
                    this.currentIndex < this.slides.length
                        ? this.currentIndex + 1
                        : 1;
            },
            play() {
                this.playInterval = setInterval(() => {
                    this.next();
                }, this.interval);
            },
            pause() {
                if (this.playInterval) {
                    clearInterval(this.playInterval);
                    this.playInterval = null;
                }
            },
            playPause() {
                if (this.playInterval) {
                    this.pause();
                } else {
                    this.play();
                }
            },
            forward() {
                this.reset();
                this.next();
                if (this.autoplay) this.play();
            },
            backward() {
                this.reset();
                this.previous();
                if (this.autoplay) this.play();
            },
            step(index) {
                this.reset();
                this.transitionReverse = index + 1 < this.currentIndex;
                this.currentIndex = index + 1;
                if (this.autoplay) this.play();
            },
            reset() {
                if (this.playInterval) clearInterval(this.playInterval);
                this.playInterval = null;
            },
            init() {
                if (this.autoplay) {
                    this.play();
                }
            },
        }),
    );
});
