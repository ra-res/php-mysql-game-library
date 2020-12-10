<!DOCTYPE hmtl>
<html>
<head>   
<?php 
$pagetitle = "Game Library";
include("header.php");
?>
</head>
<body>
<div class="headerdiv" style="background-image: url(assets/images/cataloguebackground.jpg);"><div class="layer" style="display:flex; flex-direction:row; justify-content:center;"> <h1 class="gametitle" style="margin-top:15%"> rp's game library </h1> </div> </div>
<main class ="mainContainer">
<div class="gameContainer">
	<div class="filterBox">
			<form action="index.php" method="GET" class="searchform">
				<input class="searchbox" name="name" type="text" placeholder="   Type here">
				<input class="filterbutton" name="submit" type="submit" value="Filter">
				<br>
				<?php
				checkBoxSpan(); 
				?>
			</form>
	</div>
	<?php
	$name = null;
	$genre = null;
	if(isset($_GET['submit'])){
		if(isset($_GET['name'])){
			$name = $_GET['name'];
		}
		if(isset($_GET['genreSelected'])) {
			$genre = $_GET['genreSelected'];
		}
	}
	if(isAdmin()){ ?>
	<form method="get" style="margin-top: 7%;">
	<button class="log" style="width:100%; margin-top:6%;" name="addgameindex" type="submit">Add a new game</button>	
	</form>
	<?php	

	if(isset($_GET['addgameindex'])){
		header("Location: userprofile.php?creategame=");
						
 }}	/*?>
	
         <div class="logInForm" style="margin-bottom: 2%; margin-top:20%;"> 
		 			<h1 style="color:lightblue; margin-left:5%;"> Add a new game </h1>
                    <form method="post" action="index.php">
                    <p class="err" style="color:red; margin-left: 5%;"><?php 
                    if(isset($_POST['addgameindex'])){ 
                        newgamevalidate();
                    } else {
                        echo "<br>";
                    } ?></p>
                    <br>
                    <label style="color:lightblue; margin-left:5%;">Enter game title</label><br>
                    <input class="input" type="text" name="title"><br>
                    <label style="color:lightblue; margin-left:5%;">Add image (link)</label><br>
                    <input class="input" type="text" name="image"><br>
                    <label style="color:lightblue; margin-left:5%;">Enter the game's genre</label><br>
                    <input class="input" type="text" name="genre"><br>
                    <label style="color:lightblue; margin-left:5%;">Enter the game's rating</label><br>
					<input class="input" type="text" name="rating"><br>
					<label style="color:lightblue; margin-left:5%;">Enter the game's description</label>
                    <input class="input" type="text" name="desc">
                    <button class="log" style="width:100%; margin-top:6%;" name="addgameindex" type="submit">Add game</button>
                </form></div> 
	<?php 
	
	}

*/?> 
	
	<form method="get" action="gamepage.php" class ="gameform">
		<?php gameListContent2(connect(), $name, $genre); ?>
	</form>
</div>
</main>
<?php
include("footer.php");
?>
</body>
</html>