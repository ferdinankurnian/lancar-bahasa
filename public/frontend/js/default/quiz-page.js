"use strict"

function countdown(minutes) {
  let storedEndTime = localStorage.getItem('endTime');
  let endTime;

  if (storedEndTime) {
    endTime = parseInt(storedEndTime, 10);
  } else {
    endTime = new Date().getTime() + (minutes * 60 * 1000);
    localStorage.setItem('endTime', endTime);
  }

  const countdownInterval = setInterval(function() {
    let currentTime = new Date().getTime();
    let timeDifference = endTime - currentTime;

    let hoursRemaining = Math.floor((timeDifference % (1000 * 60 * 60 * 24)) / (1000 * 60 * 60));
    let minutesRemaining = Math.floor((timeDifference % (1000 * 60 * 60)) / (1000 * 60));
    let secondsRemaining = Math.floor((timeDifference % (1000 * 60)) / 1000);

    $('.hour').text(hoursRemaining);
    $('.minute').text(minutesRemaining);
    $('.second').text(secondsRemaining);

    if (timeDifference <= 0) {
      clearInterval(countdownInterval);
      localStorage.removeItem('endTime');
      $('.question-form').trigger('submit');
    }

  }, 1000);
}
// rest countdown from storage
function resetCountdown() {
  localStorage.removeItem('endTime');
}