<!DOCTYPE html>
<html>
<head>
	
	<title>Gestion</title>
	<meta charset="utf-8" />
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<link type="text/css" rel="stylesheet" href="CSS/gestion.css">
	<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
	<script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
	<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js" integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous"></script>
	<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous"></script>
	
</head>
<body id="fond">


<?php
    define('HOSTNAME','localhost');
    define('DB_USERNAME','root');
    define('DB_PASSWORD','');
    define('DB_NAME','projet_web');

    $mysqli = new mysqli(HOSTNAME, DB_USERNAME, DB_PASSWORD, DB_NAME); ?>
	
<header id="entete">
	</br>
	</br>
	</br>
	<div id="bouton_menu">
		<a href="Visualisation.php" role="button" class="btn btn-light" >Visualisation</a>
		<a href="Gestion.php" role="button" class="btn btn-light" >Gestion</a>
	</div>

</header>

<div id="volet">

<div class="accordion" id="accordionExample">

	<div class="card">
		<div class="card-header" id="headingOne">
			<h2 class="mb-0">
			<button class="btn btn-link" id="choix1" type="button" data-toggle="collapse" 
data-target="#collapseOne" aria-expanded="true" aria-controls="collapseOne">
          Bornes
			</button>
			</h2>
		</div>

		<div id="collapseOne" class="collapse show" aria-labelledby="headingOne" 
data-parent="#accordionExample">
			<div class="card-body" id="liste_borne">			
			
				<table class="table">
					<thead>
						<tr>
							<th scope="col">Quartier</th>
							<th scope="col">Adresse</th>
							<th scope="col">Site</th>
							<th scope="col">Nom connexion</th>
							<th scope="col">Disponibilite</th>
							<th scope="col">Zone emission</th>
							<th scope="col">Année installation</th>
							<th scope="col">Modifier</th>
						</tr>
					</thead>
				<tbody>
					<?php include 'PHP/ListeBornesGestion.php' ; ?>
				</tbody>
				</table>

			</div>
		</div>
  </div>
  
  <div class="card">
		<div class="card-header" id="headingTwo">
			<h2 class="mb-0">
			<button class="btn btn-link collapsed" id="choix2" type="button" data-toggle="collapse" 
data-target="#collapseTwo" aria-expanded="false" aria-controls="collapseTwo">
          Population par quartiers
			</button>
			</h2>
		</div>
		<div id="collapseTwo" class="collapse" aria-labelledby="headingTwo" 
data-parent="#accordionExample">
			<div class="card-body" id="liste_population">

				<table class="table" id="tableau_population">
					<thead>
						<tr>
							<th scope="col">Quartier</th>
							<th scope="col">Population</th>
							<th scope="col">Nombres Bornes Wi-Fi</th>
							<th scope="col">Modifier</th>
						</tr>
					</thead>
				<tbody>
						<?php include 'PHP/ListeQuartiersGestion.php' ; ?>
				</tbody>
				</table>

			</div>
		</div>
  </div>
  
  <div class="card">
		<div class="card-header" id="headingThree">
			<h2 class="mb-0">
			<button class="btn btn-link collapsed" id="choix3" type="button" data-toggle="collapse" 
data-target="#collapseThree" aria-expanded="false" aria-controls="collapseThree">
          Ajouter une borne
			</button>
			</h2>
		</div>
		<div id="collapseThree" class="collapse" aria-labelledby="headingThree" 
data-parent="#accordionExample">
			<div class="card-body" id="ajout_borne">

			<form method="post" action="AjouterBornesGestion.php">

				<div class="form-group row">
					<label for="quartier" class="col-sm-2 col-form-label">Quartier</label>
					<div class="col-sm-10">
							<select class="form-control" id="quartier">								 
								<?php include 'PHP/ListeNomsQuartiers.php' ; ?>
							</select>
					</div>
				</div>
				
				<div class="form-group row">
					<label for="site" class="col-sm-2 col-form-label">Site</label>
					<div class="col-sm-10">
						<input type="text" class="form-control" id="site" placeholder="Capitole">


					</div>
				</div>
				
				<div class="form-group row">
					<label for="annee_ins" class="col-sm-2 col-form-label">Année d'installation</label>
					<div class="col-sm-10">
						<input type="text" class="form-control" id="annee_ins" placeholder="2010">
					</div>
				</div>
				
				<div class="form-group row">
					<label for="zone" class="col-sm-2 col-form-label">Zone d'emission</label>
					<div class="col-sm-10">
						<input type="text" class="form-control" id="zone" placeholder="intérieur/exterieur">
					</div>
				</div>
				
				<div class="form-group row">
					<label for="nom_c" class="col-sm-2 col-form-label">Nom de connexion</label>
					<div class="col-sm-10">
						<input type="text" class="form-control" id="nom_c" placeholder="Tlse_WiFi">
					</div>
				</div>
				
				<div class="form-group row">
					<label for="dispo" class="col-sm-2 col-form-label">Disponibilité</label>
					<div class="col-sm-10">
						<input type="text" class="form-control" id="dispo" placeholder="24h/24h">
					</div>
				</div>
				
				<div class="form-group row">
					<label for="adresse" class="col-sm-2 col-form-label">Adresse</label>
					<div class="col-sm-10">
						<input type="text" class="form-control" id="adresse" placeholder="106 avenue Victor Hugo">
					</div>
				</div>
				
				<div class="form-group row">
					<div class="col-sm-10">
						<button type="submit" class="btn btn-dark">Valider</button>
					</div>
				</div>
			</form>
			
			</div>
		</div>
  </div>
  
</div>

</div>

</body>