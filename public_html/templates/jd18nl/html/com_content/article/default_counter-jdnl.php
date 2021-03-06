<div class="section section--blue section__numbers">
	<div class="container">
		<div class="numbers__wrapper">
			<div class="numbers" id="clockdiv">
				<div class="numbers__item">
					<div class="numbers__item-head">Zo lang nog tot de JoomlaDagen 2018:</div>
				</div>
				<div class="numbers__item">
					<span class="numbers__item-head days"></span>
					<div class="numbers__item-label">dagen</div>
				</div>
				<div class="numbers__item">
					<span class="numbers__item-head hours"></span>
					<div class="numbers__item-label">uren</div>
				</div>
				<div class="numbers__item">
					<span class="numbers__item-head minutes"></span>
					<div class="numbers__item-label">min</div>
				</div>
				<div class="numbers__item">
					<span class="numbers__item-head seconds"></span>
					<div class="numbers__item-label">sec</div>
				</div>
				<script>
                    function getTimeRemaining(endtime) {
                        var t = Date.parse(endtime) - Date.parse(new Date());
                        var seconds = Math.floor((t / 1000) % 60);
                        var minutes = Math.floor((t / 1000 / 60) % 60);
                        var hours = Math.floor((t / (1000 * 60 * 60)) % 24);
                        var days = Math.floor(t / (1000 * 60 * 60 * 24));
                        return {
                            'total': t,
                            'days': days,
                            'hours': hours,
                            'minutes': minutes,
                            'seconds': seconds
                        };
                    }

                    function initializeClock(id, endtime) {
                        var clock = document.getElementById(id);
                        var daysSpan = clock.querySelector('.days');
                        var hoursSpan = clock.querySelector('.hours');
                        var minutesSpan = clock.querySelector('.minutes');
                        var secondsSpan = clock.querySelector('.seconds');

                        function updateClock() {
                            var t = getTimeRemaining(endtime);

                            if (t.total <= 0) {
                                addClass('#' + id, 'hidden');
                                return;
                            }

                            daysSpan.innerHTML = t.days;
                            hoursSpan.innerHTML = ('0' + t.hours).slice(-2);
                            minutesSpan.innerHTML = ('0' + t.minutes).slice(-2);
                            secondsSpan.innerHTML = ('0' + t.seconds).slice(-2);

                            if (t.total <= 0) {
                                clearInterval(timeinterval);
                            }
                        }

                        updateClock();
                        var timeinterval = setInterval(updateClock, 1000);
                    }

                    var deadline = new Date('04/13/2018 09:00:00');
                    initializeClock('clockdiv', deadline);
				</script>
			</div>
		</div>
	</div>
</div>