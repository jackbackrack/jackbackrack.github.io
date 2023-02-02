<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN">
<html>
  <head>
    <title>minimals survey</title>
  </head>

<style type="text/css"><!-- 
BODY, P, TD  {font-size: 14pt; font-family: 'helvetica neue', helvectica, arial, georgia, times; color: #666} 
BIG {	font-size: 124pt} 
SMALL  { font-size: 24pt} 
a
{
font-size: 5-pt;
color: #888;
text-decoration: none;
}

a:hover
{background: #FFFF3C;
color: #000;
text-decoration: none;
}

.post a:link,
.post a:visited
{
color: #FFFF3C;
text-decoration: none;
}

.post a:hover
{
color: #fff;
text-decoration: none;
}


--> </style>

<body bgcolor=#000000 fgcolor=#ffffff text=#ffffff>

<?php 
$uid            = $_POST['uid'];
$animal_num     = $_POST['animal_num'];
$animal_tot     = $_POST['animal_tot'];
$resolution     = $_POST['resolution'];
$animal_answer  = $_POST['animal_answer'];
$animal_unknown = $_POST['animal_unknown'];
$animal_guess   = $_POST['animal_guess'];
?>

<?php 
if ($uid == NULL) { // FIRST TIME THROUGH

  $uid = date("YmdHis");
  $animal_num = 0;
  $animal_tot = -1;
?>  

<!-- <h1>Welcome <?php echo $uid; ?> to the Minimals survey.</h1> -->

<?php
} else {
?>

<!-- <h1>You (<?php echo $uid; ?>) saw a <?php echo htmlspecialchars($animal_guess); ?>. -->

<?php
$filename = "answers/" . $uid . ".txt";
?>

<?php
if ($animal_unknown)
  $animal_guess = "unknown";
$file = fopen($filename, 'a');
$result = $animal_answer . " " . $resolution . " " . $animal_guess . "\n";
fwrite($file, $result);
fclose($file);

}
?>

<?php
if ($animal_tot > 0 && $animal_num >= $animal_tot) { // DID ALL ANIMALS?
?>

<h1>Thank you <?php echo $uid; ?> for taking the Minimals survey.</h1>
<h2>Come to <a href="http://www.collisioncollective.org">Collision 16</a> to see the winning 50&#37; minimals.</h2>

<?php
} else {

// NEXT ANIMAL / RESOLUTION

$animals     = array();
$animals_dir = opendir("minimals");
while ($animal = readdir($animals_dir)) {
  if ($animal != "." && $animal != "..")
    $animals[] = $animal;
}
$animal_tot = sizeof($animals);

$animal = $animals[$animal_num];
$animal_dir = opendir("minimals/" . $animal);
$resolutions = array();
while ($resolution = readdir($animal_dir)) {
  if ($resolution != "." && $resolution != "..")
    $resolutions[] = $resolution;
}
$resolution_num = rand(0, sizeof($resolutions)-1);
$resolution_filename = $resolutions[$resolution_num];
$dash_pos = strpos($resolution_filename, '-');
$dot_pos = strpos($resolution_filename, '.');
$resolution = substr($resolution_filename, $dash_pos+1, $dot_pos-$dash_pos-1);
$gif_filename = "minimals/" . $animal . "/" .$resolution_filename
?>

<h1>Welcome <?php echo $uid; ?> to part
<?php echo $animal_num+1; ?>/<?php echo $animal_tot; ?> of Minimals survey.</h1>

<IMG SRC=<?php echo $gif_filename ?>>

<?php
closedir($animal_dir);
closedir($animals_dir);
$animal_num = $animal_num + 1;
?>

<form action="minimal.php" method="post">
<h1>What animal do you see? </h1>
<input type="text" name="animal_guess" /> 
<input type="hidden" name="uid" value="<?php echo $uid ?>" /> 
<input type="hidden" name="animal_tot" value="<?php echo $animal_tot ?>" /> 
<input type="hidden" name="animal_num" value="<?php echo $animal_num ?>" /> 
<input type="hidden" name="animal_answer" value="<?php echo $animal ?>" /> 
<input type="hidden" name="resolution" value="<?php echo $resolution ?>" /> 
<input type="submit" />
<input type="submit" name="animal_unknown" value="don't know" /></p>
</form>
<h3>
<a href="http://www.jbot.org">jonathan bachrach</a> and 
<a href="http://web.media.mit.edu/~jdward">jonathan ward</a></h3>
<h4>
Minimals showing at <a href="http://www.collisioncollective.org">Collision 16</a> opening Feb 25th
</h4>

<?php
}
?>

<!-- Created: Sat Jan 29 16:20:08 EST 2011 -->
<!-- hhmts start -->
<!-- hhmts end -->
  </body>
</html>

