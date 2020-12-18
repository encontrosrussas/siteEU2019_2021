(function () {
    function VerticalTimeline(element) {
        this.element = element;
        this.blocks = this.element.getElementsByClassName("timeline-block");
        this.images = this.element.getElementsByClassName("timeline-icon");
        this.contents = this.element.getElementsByClassName("timeline-content");
        this.offset = 0.8;
        this.hideBlocks();
    };

    VerticalTimeline.prototype.hideBlocks = function () {
        if (!"classList" in document.documentElement) {
            return;
        }
        var self = this;
        for (var i = 0; i < this.blocks.length; i++) {
            (function (i) {
                if (self.blocks[i].getBoundingClientRect().top > window.innerHeight * self.offset) {
                    self.images[i].classList.add("timeline-icon--hidden");
                    self.contents[i].classList.add("timeline-content--hidden");
                }
            })(i);
        }
    };

    VerticalTimeline.prototype.showBlocks = function () {
        if (! "classList" in document.documentElement) {
            return;
        }
        var self = this;
        for (var i = 0; i < this.blocks.length; i++) {
            (function (i) {
                if (self.contents[i].classList.contains("timeline-content--hidden") && self.blocks[i].getBoundingClientRect().top <= window.innerHeight * self.offset) {
                    self.images[i].classList.add("timeline-icon--bounce-in");
                    self.contents[i].classList.add("timeline-content--bounce-in");
                    self.images[i].classList.remove("timeline-icon--hidden");
                    self.contents[i].classList.remove("timeline-content--hidden");
                }
            })(i);
        }
    };

    var verticalTimelines = document.getElementsByClassName("js-timeline"),
        verticalTimelinesArray = [],
        scrolling = false;
    if (verticalTimelines.length > 0) {
        for (var i = 0; i < verticalTimelines.length; i++) {
            (function (i) {
                verticalTimelinesArray.push(new VerticalTimeline(verticalTimelines[i]));
            })(i);
        }

        window.addEventListener("scroll", function (event) {
            if (!scrolling) {
                scrolling = true;
                (!window.requestAnimationFrame) ? setTimeout(checkTimelineScroll, 250) : window.requestAnimationFrame(checkTimelineScroll);
            }
        });
    }

    function checkTimelineScroll() {
        verticalTimelinesArray.forEach(function (timeline) {
            timeline.showBlocks();
        });
        scrolling = false;
    };
})();