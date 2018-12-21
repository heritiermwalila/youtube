# youtube Clone
recommanded FFMPEG in order to work and convert the video, please download ffmpeg <a href="https://www.ffmpeg.org/download.html">here</a>
for this I used the mac version. 

#For window machine
you must change go to includes/classes/videoProcessor.php and add in the constructor this:

$this->ffmpegPath = realpath("ffmpeg/bin/ffmpeg.exe");

# Notes
This is not a full version yet. it's still under development
