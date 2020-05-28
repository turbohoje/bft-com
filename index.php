<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Buring Free Time Podcast</title>
    <link rel="stylesheet" href="css/style.css">

    <!-- Global site tag (gtag.js) - Google Analytics -->
    <script async src="https://www.googletagmanager.com/gtag/js?id=UA-42536493-5"></script>
    <script>
        window.dataLayer = window.dataLayer || [];
        function gtag() {
            dataLayer.push(arguments);
        }
        gtag('js', new Date());
        gtag('config', 'UA-42536493-5');
    </script>


</head>
<body>
<div class="pimg1">
    <div class="ptext">
      <span class="border">
        Burning Free Time
      </span>
    </div>
</div>

<section class="section section-light">
    <h2>Just another dumb podcast</h2>
    <p>We are a married couple based in Denver, CO. We were inspired by boredom during the covid lockdown and thought it
        would be fun
        to archive our thoughts, for future laughs, at the expense of our past selves.</p>
</section>

<div class="pimg2">
    <div class="ptext">

    </div>
</div>

<section class="section section-dark">
    <h2>Why do this?</h2>
    <p>This is what personal amusement looks like when you record it and put it on the internets.  There is no intention or delusion of thinking this will be popular, profitable or anything.
    </p>
</section>

<div class="pimg3">
    <div class="etext">

	<div class="ep">Episode 3 : 2020-05-25<br><br>
		<audio controls id="ep3" style="width:90%" preload="none">
			<source src="podcast/200525_0006S34.mp3" type="audio/mpeg">
		</audio>
	</div>


	<div class="ep">Episode 2 : 2020-05-17<br><br>
	<audio controls id="ep2" style="width:90%" preload="none">
	<source src="podcast/200517_0004S34.mp3" type="audio/mpeg">
	</audio>
	</div>

	<div class="ep">Episode 1 : 2020-05-15<br><br>
	<audio controls id="ep1" style="width:90%" preload="none">
	<source src="podcast/200515_0003S34.mp3" type="audio/mpeg">
	</audio>
	</div>
		<font color="white">x's of playback</font>
		<nav>
		<ul>
			<li><a href="#1/2x" onclick="playspeed(1/2);">1/2</a></li>
			<li><a href="#1x" onclick="playspeed(1);" class="active"">1</a></li>
			<li><a href="#5/4x" onclick="playspeed(5/4);">5/4</a></li>
			<li><a href="#3/2x" onclick="playspeed(3/2);">3/2</a></li>
			<li><a href="#7/4x" onclick="playspeed(7/4);">7/4</a></li>
			<li><a href="#2x" onclick="playspeed(2);">2</a></li>
			<li><a href="#9/4x" onclick="playspeed(9/4);">9/4</a></li>
		</ul>
		</nav>
		<a name="1/2x"></a>
		<a name="1x"></a>
		<a name="5/4x"></a>
		<a name="3/2x"></a>
		<a name="7/4x"></a>
		<a name="2x"></a>
		<a name="9/4x"></a>
    </div>
</div>
</body>

<!--section class="section section-dark">
    <h2>Be Our Guest</h2>
    <p>You know you don't have much better to do, come on</p><br><br><br><br>
</section-->


<script language="javascript">
    function set_play_speed_button(){
        var ns = document.querySelectorAll('nav ul li');

        var url = document.URL;
        var idx = url.indexOf("#");
        var anc = idx != -1 ? url.substring(idx+1) : "1x";

        for (var i=0; i < ns.length; i++) {
            var lurl = document.querySelectorAll('nav ul li')[i].querySelector('a').href;
            var lidx = lurl.indexOf("#");
            if(lurl.substring(lidx+1) == anc) {
                document.querySelectorAll('nav ul li')[i].querySelector('a').classList.add("active");
            }
            else{
                document.querySelectorAll('nav ul li')[i].querySelector('a').classList.remove("active");
            }
        }
    }

	function playspeed(x){
        // $('audio').playbackRate = x;
        var as = document.querySelectorAll('audio');
        for (var i=0; i < as.length; i++) {
            as[i].playbackRate = x;
		}

        gtag('event', 'action', {'event_label': 'playbackRate', 'event_category': 'rate=' + x})
        setTimeout(set_play_speed_button, 1);
	}



    var events = ["play", "playing", "pause", "ended", "seeked", "stalled", "volumechanged", "emptied", "playbackRate"];
    var eps = ["ep1", "ep2", "ep3"]

    var eventFunc = function(id, event){
        gtag('event', 'action', {'event_label': event, 'event_category': 'playback.' + id})
    };

    for (var j = 0; j < eps.length; j++) {
        v = document.getElementById(eps[j]);

        for (var i = 0; i < events.length; i++) {
            v.addEventListener(events[i], eventFunc.bind(this, v.id, events[i] + '.' + v.id), true);
        }
    }

    //set playspeed if bookmarked
    var url = document.URL;
    var idx = url.indexOf("#");
    var anc = idx != -1 ? url.substring(idx+1) : "1x";
	var val =  eval(anc.replace("x", ""));
    playspeed(val);
</script>

</html>
