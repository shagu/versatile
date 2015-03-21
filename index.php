<!DOCTYPE html>
<?php include("./versatile/versatile.php"); ?>
<html lang="de">
  <head>

    <meta charset="utf-8"/>
	<meta name="description" content="<?php echo $title . " - " . $subtitle; ?>" />
    <link rel="stylesheet" type="text/css" href="./versatile/style.css"/>
    <title>
      <?php echo $title . " - " . $subtitle; ?>
    </title>
   </head>

  <body>
    <div class="topbar">
      <span class="headerbig"><?php echo $title;?></span>
      <span class="headersmall"><?php echo $subtitle; ?></span>
      <span class="navbar"><?php echo $menu?></span>
    </div>
       
    <div class="content"><?php echo $content; ?></div>
  </body>
</html>
