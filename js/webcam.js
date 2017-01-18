document.addEventListener('DOMContentLoaded', function() {
	var height = 450, width = 600;
	var streaming = false;
	var audio, audioType;
	var video = document.querySelector('video');
	var canvas = document.querySelector('canvas');
	var context = canvas.getContext('2d');
	var iFilter = 0;
	var filters = [
		'grayscale',
		'sepia',
		'brightness',
		'contrast',
		'hue-rotate',
		'hue-rotate2',
		'hue-rotate3',
		'saturate',
		'invert',
		'none'];

navigator.getUserMedia = navigator.getUserMedia ||
	navigator.webkitGetUserMedia ||
	navigator.mozGetUserMedia ||
	navigator.msGetUserMedia;

window.URL = window.URL ||
	window.webkitURL ||
	window.mozURL ||
	window.msURL;

if (navigator.getUserMedia)
{
	navigator.getUserMedia({video: true, audio: false}, onSuccessCallback, onErrorCallback);
	function onSuccessCallback(stream) {
		video.src = window.URL.createObjectURL(stream) || stream;
		video.play();
	}    
	function onErrorCallback(e) {
		var expl = 'An error occurred: [Reason: ' + e.code + ']';
		console.error(expl);
		return;
	}
}
else
{
	document.querySelector('.container').style.visibility = 'hidden';
	document.querySelector('.warning').style.visibility = 'visible';
	return;
}

video.addEventListener('canplay', function(){
	if (!streaming)
{
	height = video.videoHeight / (video.videoWidth/width);
	video.setAttribute('width', width);
	video.setAttribute('height', height);
	canvas.setAttribute('width', width);
	canvas.setAttribute('height', height);
	streaming = true;
}
}, false);

function takePicture() {
	canvas.width = width;
	canvas.height = height;
	canvas.getContext('2d').drawImage(video, 0, 0, width, height);

	var data = canvas.toDataURL('image/png');
	var effect = filters[iFilter - 1 % filters.length];
	if (effect) {
		data = canvas.classList.add(effect);
	}
}

function savePicture()
{
	var overlay = document.getElementById('overlay').src;
	var overlay_name = overlay.split("/");
	if (overlay_name[overlay_name.length - 1] != 'index.php?page=home')
	{
		var canvas = document.querySelector('canvas');
		var dataURL = canvas.toDataURL();
		var http = new XMLHttpRequest();
		var url = "actions/save_picture.php";
		var effect = filters[iFilter - 1 % filters.length];
		var params = "data=" + dataURL + "&effect=" + effect + "&overlay=" + overlay;

		http.open("POST", url, true);
		http.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
		http.onreadystatechange = function()
		{
			if (http.readyState == 4 && http.status == 200) {
				var img = document.createElement("img");
				var test0 = http.responseText;
				var test1 = test0.split("\"");
				img.src = test1[1].substr(3);
				img.id = "mini-picture";
				var captContainer = document.getElementById('capt-container');
				captContainer.appendChild(img);
			}
		}
		http.send(params)
	}
}

startbutton.addEventListener('click', function(ev) {
	takePicture();
	ev.preventDefault();
}, false);

savebutton.addEventListener('click', function(ev) {
	savePicture();
	ev.preventDefault();
}, false);

document.querySelector('button').addEventListener('click', function() {
	video.className = 'none';
	if (iFilter == filters.length) {
		iFilter = 0;
	}
	var effect = filters[iFilter++ % filters.length];
	if (effect) {
		video.classList.add(effect);
	}
}, false);
}, false);

//////////////////////////////////////
/* change img (src and alt) onclick */
//////////////////////////////////////
function selectOverlay()
{
	var i;
	var doc = document.getElementById('overlay');
	var rates = document.getElementsByName('rate');

	for (i = 0; i < rates.length; i++)
	{
		if (rates[i].checked)
		{
			var rate_value = rates[i].value;
			break;
		}
	}
	if (rate_value == "none")
	{
		doc.style.display = "none";
		doc.src = "";
		doc.alt = "";
	}
	else
	{
		doc.style.display = "inline-block";
		doc.src = "img/overlays/".concat(rate_value).concat(".png");;
		doc.alt = rate_value;
	}
}
