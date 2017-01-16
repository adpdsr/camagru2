<div id="home-global">
	<div id="capt-container"></div>
	<div class="home-container">
		<button style="margin-top: 0px;">Appliquez un filtre</button>
		<div style="clear:both"></div>
			<div class="col">
				<video></video>
				<canvas width="600" height="450"></canvas>
			</div>
		<button id="startbutton">Prendre une photo</button>
		<button id="savebutton">Sauvegarder la photo</button>
		<div id="overlays">
			<div id="rates">
				<input type="radio" id="r1" name="rate" value="none" onclick="selectOverlay()" checked="checked"> None
				<input type="radio" id="r2" name="rate" value="tree" onclick="selectOverlay()"> tree
				<input type="radio" id="r3" name="rate" value="bubble" onclick="selectOverlay()"> bubble
				<input type="radio" id="r4" name="rate" value="sword" onclick="selectOverlay()"> sword
				<input type="radio" id="r5" name="rate" value="frame1" onclick="selectOverlay()"> frame1
				<input type="radio" id="r6" name="rate" value="frame2" onclick="selectOverlay()"> frame2
				<input type="radio" id="r7" name="rate" value="frame3" onclick="selectOverlay()"> frame3
				<input type="radio" id="r8" name="rate" value="frame4" onclick="selectOverlay()"> frame4
			</div>
			<img id="overlay" src="" alt="">
		</div>
	</div>
</div>

<script src='js/webcam.js'></script>
