<!DOCTYPE html>
<html>
<head>
	<title>BackUp de fotolog</title>
	<link href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/css/bootstrap.min.css" rel="stylesheet" integrity="sha256-MfvZlkHCEqatNoGiOXveE8FIwMzZg4W85qfrfIFBfYc= sha512-dTfge/zgoMYpP7QbHy4gWMEGsbsdZeCXz7irItjcC3sPUFtf0kuFbDz/ixG7ArTxmDjLXDmezHubeNikyKGVyQ==" crossorigin="anonymous">
	<link rel="stylesheet" type="text/css" href="css/swag.css">
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.4/jquery.min.js"></script>
	<script>
	$(document).ready(function() {

	    $('form').submit(function() {
	    	$('#loading').fadeIn();
	        $.ajax({
	            type: 'POST',
	            url: $(this).attr('action'),
	            data: $(this).serialize(),
	            success: function(data) {
	            	$('#dta').empty();
	                $('#dta').html(data);
	                var hash = data.split('hash');
	                $('#descarga').html('Descargar zip: <a href="https://fotologbackup.herokuapp.com/'+hash[1]+'.zip"> '+hash[1]+' </a>')
	                $('#loading').fadeOut();
	            }
	        })        
	        return false;
	    }); 
	})
	</script>
</head>
<body>
<div id="degradado"></div>
<div id="formulario">
	<form method="post" action="scrap.php">
		<input class="form-control" type="text" placeholder="ID del fotolog (ej: cumbio)" size="30" name="name"><br>
	 	<input class="btn btn-default btn-lg" type="submit" name="submit" value="Scrapear">
	 	<img src="http://i.imgur.com/t6HyfIO.gif" id="loading" style="display: none;" />
	 </form>
	 <br>
	 <textarea class="form-control" rows="15" id="dta"></textarea>
	 <div id="descarga"></div>
</div>

<div id="copy">
	made with <span class="cora">&hearts;</span> - 
	dev: <a href="https://twitter.com/brai4u">@brai4u</a> - 
	Code: <a href="https://github.com/brai4u">Github</a>
</div>
</body>
</html>