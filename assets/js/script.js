var currentPlaylist = [];
var shufflePlaylist = [];
var tempPlaylist = [];
var audioElement;
var mouseDown = false;
var currentIndex = 0;
var repeat = false;
var shuffle = false;
var userLoggedIn;
var timer;

 function openPage(url) {
    if(timer != null) {
        clearTimeout(timer);
    }
    if(url.indexOf("?") == -1) {
        url = url + "?";
    }
    var encodedUrl = encodeURI(url + "&userLoggedIn" + userLoggedIn);
    $("#mainContent").load(encodedUrl);
    $("body").scrollTop(0);
    history.pushState(null, null, url);
}


// function formatTime(seconds) {
//     var time = Math.round(seconds);
//     var minutes = Math.floor(time / 60);
//     var seconds = time - minutes * 60;
//     var extraZero = (seconds < 10) ? "0" : "";
//     return minutes + ":" + extraZero + seconds;
// }
function formatTime(seconds) {
  const minutes = Math.floor(seconds / 60);
  const remainingSeconds = Math.floor(seconds % 60);
  return `${minutes}:${remainingSeconds.toString().padStart(2, "0")}`;
}
function updateTimeProgessBar(audio) {
    $(".progressTime.current").text(formatTime(audio.currentTime));
    // $(".progressTime.remaining").text(formatTime(audio.duration - audio.currentTime)); // this is to display remaining time, I don't want that.
    var progress = audio.currentTime / audio.duration * 100;
    $(".playbackBar .progress").css("width", progress + "%");
    $(".playbackBar .progressNode").css("left", progress + "%");
}
function updateVolumeProgressBar(audio) {
    var volume = audio.volume * 100;
    $(".volumeBar .progress").css("width", volume + "%");
    $(".volumeBar .progressNode").css("left", volume + "%");
}
function playFirstSong() {
    setTrack(tempPlaylist[0], tempPlaylist, true);
}

function Audio() {
    this.currentlyPlaying;
    this.audio = document.createElement('audio');

    this.audio.addEventListener("ended", function() {
        nextSong();
    });
    this.audio.addEventListener("canplay", function() {
        var duration = formatTime(this.duration);
        $(".progressTime.remaining").text(duration);
        
    });
    this.audio.addEventListener("timeupdate", function() {
        if(this.duration) {
            updateTimeProgessBar(this);
        }
    });
    this.audio.addEventListener("volumechange", function() {
		updateVolumeProgressBar(this);
	});
    this.setTrack = function(track) {
        this.currentlyPlaying = track;
        this.audio.src = track.path;
    }
    this.play = function() {
        this.audio.play();
    }
    this.pause = function() {
        this.audio.pause();
    }
    this.setTime = function(seconds) {
        this.audio.currentTime = seconds;
    }
}

