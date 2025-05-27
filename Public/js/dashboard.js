document.addEventListener('DOMContentLoaded', () => {
  const alarmPopup = document.getElementById('alarm-popup');
  const snoozeBtn = document.getElementById('snooze-btn');
  const stopBtn = document.getElementById('stop-btn');
  const alarmAudio = loadAlarmAudio(window.alarmTone);

  let alarmChecker;
  let alarmTime = window.alarmTimeStr;

function loadAlarmAudio(tone) {
  const audio = new Audio();
    audio.src = `/Principles/Public/tones/${tone}`;
  audio.onerror = function()  {
    audio.src = '/Principles/Public/tones/sunshine.mp3';
    audio.load();
  };
  return audio;
}
  function playAlarm() {
    alarmPopup.style.display = 'block';
    alarmAudio.currentTime = 0;
    alarmAudio.play();

    setTimeout(() => {
      stopAlarm();
    }, 15000);
  }

  function stopAlarm() {
    alarmAudio.pause();
    alarmPopup.style.display = 'none';
    clearInterval(alarmChecker);
  }

  function snoozeAlarm() {
    const parts = alarmTime.split(':');
    let date = new Date();
    date.setHours(parseInt(parts[0], 10), parseInt(parts[1], 10), parseInt(parts[2], 10));
    date = new Date(date.getTime() + 5 * 60000);
    alarmTime = date.toTimeString().slice(0, 8);
    stopAlarm();
    startAlarmChecker();
  }

  function checkAlarm() {
    if (!alarmTime) return;

    const now = new Date();
    const currentTime = now.toTimeString().slice(0, 8);

    if (currentTime === alarmTime) {
        console.log('Alarm time matched, playing alarm!');
      playAlarm();
    }
    else{
      console.log('Alarm time no, no alarm!');
    }
  }

  function startAlarmChecker() {
    alarmChecker = setInterval(checkAlarm, 1000);
  }

  snoozeBtn.addEventListener('click', snoozeAlarm);
  stopBtn.addEventListener('click', stopAlarm);

  startAlarmChecker();
});
