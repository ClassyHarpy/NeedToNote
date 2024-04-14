class StopWatch {
    buttonShow = null;
    movableDiv = null;
    isDragging = false;
    mouseX; mouseY;
    start = null;
    reset = null;
    stop = null;
    counter = null;
    interval = null;
    hours = 0; minutes = 0; seconds = 0;

    constructor() {
        this.buttonShow = document.getElementById('showWatch');
        this.movableDiv = document.getElementById('stopwatch');
        this.start = document.getElementById("start");
        this.reset = document.getElementById("reset");
        this.stop = document.getElementById("stop");
        this.counter = document.getElementById("stopwatch-counter");

        if (this.buttonShow && this.movableDiv && this.start && this.reset && this.stop && this.counter) {
            this.setListeners();
        } else {
            console.warn("Couldn't initialize the stopwatch!");
        }
    }

    showWatch() {
        this.movableDiv.classList.toggle("active");
    }

    startWatch() {
        clearInterval(this.interval);

        this.interval = setInterval(() => {
            this.seconds++;

            if (this.seconds > 59) {
                this.minutes++;
                this.seconds = 0;
            }

            if (this.minutes > 59) {
                this.hours++;
                this.minutes = 0;
            }

            this.counter.innerText =
                `${this.hours > 0 ? `${this.hours}:` : ""}${this.minutes <= 9 ? `0${this.minutes}` : this.minutes}:${this.seconds <= 9 ? `0${this.seconds}` : this.seconds}`;
        }, 1000);
    }

    stopWatch() {
        clearInterval(this.interval);
    }

    resetWatch() {
        this.hours = 0;
        this.minutes = 0;
        this.seconds = 0;
        this.counter.innerText = "00:00";

        clearInterval(this.interval);
    }

    setListeners() {
        this.buttonShow.addEventListener("click", this.showWatch.bind(this));

        this.movableDiv.addEventListener('mousedown', function (event) {
            if (event.target.tagName !== "BUTTON") {
                this.isDragging = true;

                this.mouseX = event.clientX;
                this.mouseY = event.clientY;
            }
        }.bind(this));

        this.start.addEventListener("click", this.startWatch.bind(this));
        this.stop.addEventListener("click", this.stopWatch.bind(this));
        this.reset.addEventListener("click", this.resetWatch.bind(this));

        document.addEventListener('mousemove', function (event) {
            if (this.isDragging) {
                const deltaX = event.clientX - this.mouseX;
                const deltaY = event.clientY - this.mouseY;

                this.movableDiv.style.left = (this.movableDiv.offsetLeft + deltaX) + 'px';
                this.movableDiv.style.top = (this.movableDiv.offsetTop + deltaY) + 'px';

                this.mouseX = event.clientX;
                this.mouseY = event.clientY;
            }
        }.bind(this));

        document.addEventListener('mouseup', function () {
            this.isDragging = false;
        }.bind(this));
    }
}

//Singleton
const stopWatch = new StopWatch();
