<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.1//EN" "http://www.w3.org/TR/xhtml11/DTD/xhtml11.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
	<?php
		$movie = $_REQUEST["film"];
		$raw = file_get_contents("$movie/info.txt");
		$sideraw = file_get_contents("$movie/generaloverview.txt");
		$side = explode("\n",$sideraw);
		$info = explode("\n",$raw);
		$rcount = 0;

		function sidebar(){
			global $side;
			foreach($side as $line){
				$line = explode(":",$line);
				echo "<dt>{$line[0]}</dt>
					<dd>{$line[1]}</dd>";
			}
		}

		function getReviews(){
			global $movie;
			global $rcount;
			$reraw=array();
			foreach (glob("$movie/review*.txt") as $filename){
				$reraw[$rcount] = file_get_contents("$filename");
				$rcount++;
			}
			for ($i=0;$i<$rcount;$i++){
				$review = explode("\n",$reraw[$i]);
				dispRev($review,$i+1);
			}
		}
	
		function dispRev($review,$num){
			global $rcount;
			$review[1] = strtolower($review[1]);
			echo "<p class='review'>
					<img class='fr' src='images/{$review[1]}.gif' alt='{$review[1]}' />
					<q>{$review[0]}</q>
				</p>
				<p>
					<img class='critic' src='images/critic.gif' alt='Critic' />
					{$review[2]}<br />
					{$review[3]}
				</p>";
			if($num == floor($rcount/2)){
				echo "</div>
					<div class='column'>";
			}
		}

		function dispIcon($inf){
			if($inf >= 60){
				echo "<img src='images/freshbig.png' alt='Fresh'>";
			}
			else{
				echo "<img src='images/rottenbig.png' alt='Rotten'>";
			}
		}
	?>

	<head>
		<title><?=$info[0]?> - Rancid Tomatoes</title>
		<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
		<link rel="SHORTCUT ICON" href="images/rotten.gif" />
		<link href="movie.css" type="text/css" rel="stylesheet" />
	</head>
	<body>
		<div id="banner">
			<img src="images/banner.png" alt="Rancid Tomatoes" />
		</div>
		<h1><?echo "$info[0] ($info[1])";?></h1>
		<div id="main">	
	  		<div id="sidebar">
				<div>
					<img src="<?=$movie?>/generaloverview.png" alt="general overview" />
				</div>
				<dl>
					<?sidebar();?>
				</dl>
			</div>
			<div id="meter">
				<?dispIcon($info[2])?>
				<div id="metertext">
					<strong><?=$info[2]?>%</strong> (<?=$info[3]?> reviews total)
				</div>
			</div>
			<div id="columnholder">
				<div class="column">		
					<?getReviews();?>
				</div>
				<p class="end">(1- <?=$rcount?>) of <?=$info[3]?></p>
			</div>
		</div>
		<div id="links">
			<a href="http://validator.w3.org/check?uri=referer"><img src="images/w3c-html.png" alt="Valid HTML5" /></a><br />
			<a href="http://jigsaw.w3.org/css-validator/check/referer"><img src="images/w3c-css.png" alt="Valid CSS" /></a>
		</div>
	</body>
</html>