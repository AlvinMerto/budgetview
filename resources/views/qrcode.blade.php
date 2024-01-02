<html>
	<body style="display:flex; align-items: center; justify-content: center; height:100%;">
	<div class="visible-print text-center" style="text-align: center;">
		<p style="font-family: calibri;"> Please scan me </p>
		<?php 
            $url = base64_encode(QrCode::size(200)->generate($url)) 
        ?>
        
        <img src="data:image/png;base64, {!! $url !!} ">
	    <!-- {!! QrCode::size('200')->style('dot')->generate('$url'); !!} -->
	    <p style="font-family: calibri;"> Activity Design Tracking Code</p>
	</div>
	</body>
</html>