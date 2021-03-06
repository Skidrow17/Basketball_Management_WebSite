<?php 
//Access: Authorized User
//Purpose: Modify Score , My Weekly Games , All my Games history

require_once("php/session.php");
require_once('php/language.php');
require_once("http_to_https.php");
require_once("php/useful_functions.php");
require_once('php/select_boxes.php');

?>

<!DOCTYPE html>

<html>

<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<title>ΕΚΑΣΔΥΜ - <?php echo $matches; ?></title>
	<?php include('head.php'); ?>
</head>

<body>
	<main class="page lanidng-page">
		<section class="portfolio-block photography"></section>
	</main>
	<?php include('nav_bar.php'); ?>
	<div class='form-row'>
		<div class='col-xl-6'>
				<div class="annoucements-look element">
					<form id='ranking' method="post" style="background-color:rgba(238,238,238,0.74);">

						<div class="form-row">
							<div class="col">
								<h3><?php echo $ranking; ?></h3>
							</div>
						</div>

						<div class="form-row">
							<div class="col-xl-6"><small class="form-text text-muted"><?php echo $selectCategory; ?></small>
								<div class = "col selectbox-design"><?php echo getAllTeam_Categories(); ?></div>
							</div>

							<div class="col-xl-6" id="group_text" style="display:none;"><small class="form-text text-muted"><?php echo $select_group; ?></small>
								<div class = "col selectbox-design" id = "groups" contenteditable="false"></div>
							</div>
						</div>
							
						<div style="overflow-x:auto;">
							<table id='ranking_table'>
							</table>
						</div>

					</form>
				</div>
		</div>
		<div class='col-xl-6'>
			<div class="annoucements-look element">
				<form id='hide' method="post" style="background-color:rgba(238,238,238,0.74);">

					<div class="form-row">
						<div class="col">
							<h3><?php echo $weekly_matches; ?></h3>
						</div>
					</div>

					<div class="form-row">
						<div class="col">
							<hr>
						</div>
					</div>
					<div class='form-row'>
						<div class="col">
							<button class="btn btn-primary btn-block" id='men_a' value='1' type="button">A Ανδρών</button>
						</div>
					</div>

					<div class='form-row'>
						<div class="col">
							<button class="btn btn-primary btn-block" id='adult' value='4' type="button">Εφήβων</button>
						</div>
						<div class="col">
							<button class="btn btn-primary btn-block" id='men_b' value='2' type="button">B Ανδρών</button>
						</div>
						<div class="col">
							<button class="btn btn-primary btn-block" id='woman' value='3' type="button">Γυναικών</button>
						</div>
					</div>

					<div class='form-row'>
						<div class="col">
							<button class="btn btn-primary btn-block" id='girls' value='8' type="button">Κορασίδων</button>
						</div>
						<div class="col">
							<button class="btn btn-primary btn-block" id='young' value='5' type="button">Νεανίδων</button>
						</div>
						<div class="col">
							<button class="btn btn-primary btn-block" id='child' value='7' type="button">Παίδων</button>
						</div>
					</div>

				</form>

				<form method="post" id='apear' style="display: none;">

					<div class="form-row">
						<div class="col">
							<h3 id='team_category'></h3>
						</div>
					</div>

					<div class="form-row">
						<div class="col">
							<hr>
						</div>
					</div>

					<div>
						<nav aria-label="Page navigation example">
							<ul class="pagination">
								<li class='page-item' style='color:rgb(220,64,29);'><a id="previous" style='display:none;' class='page-link' aria-label='Previous'><span aria-hidden='true'>«</span></a></li>
								<li class='page-item' style='color:rgb(220,64,29);'><a id="min1" class='page-link' aria-label='Previous'><span aria-hidden='true'></span></a></li>
								<li class='page-item' style='color:rgb(220,64,29);'><a class='page-link' aria-label='Previous'><span aria-hidden='true'>..</span></a></li>
								<li class='page-item' style='color:rgb(220,64,29);'><a id="current1" class='page-link' aria-label='Previous'><span aria-hidden='true'></span></a></li>
								<li class='page-item' style='color:rgb(220,64,29);'><a class='page-link' aria-label='Previous'><span aria-hidden='true'>..</span></a></li>
								<li class='page-item' style='color:rgb(220,64,29);'><a id="max1" class='page-link' aria-label='Previous'><span aria-hidden='true'></span></a></li>
								<li class='page-item' style='color:rgb(220,64,29);'><a id="next" style='display:none;' class='page-link' aria-label='Previous'><span aria-hidden='true'>»</span></a></li>
							</ul>
						</nav>
					</div>

					<div style="overflow-x:auto;">
						<table id='table'>

						</table>
					</div>

					<div class="form-group">
						<button class="btn btn-primary btn-block" id='back' type="button" style="background-color:rgb(220,110,86);"><?php echo $back; ?></button>
					</div>
				</form>

			</div>
		</div>

	</div>

	<?php include('footer.php'); ?>
		<script src="assets/js/weekly_games.js"></script>
		<script src="assets/js/ranking_update.js"></script>

</body>

</html>