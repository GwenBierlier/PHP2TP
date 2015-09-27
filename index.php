<!DOCTYPE html>
<html lang="fr">

	<head>

		<meta charset="utf-8">
		<meta name="viewport" content="initial-scale=1.0" />
		<title>PHP2TP : Inscris-toi au Cercle ! ∙ PHP</title>

		<?php
			include('opengraph.inc.php') ;
			include('favicon.inc.php') ;
		
			include('Mobile_Detect.php') ;

			$detect = new Mobile_Detect;

			if ( $detect->isMobile() ) {
				echo ("<link rel='stylesheet' href='mobile.css' type='text/css'>") ;
			} else {
				echo ("<link rel='stylesheet' href='style.css' type='text/css'>") ;
			}

		?>

	</head>

	<body>

		<?php

			function valid_email($email) {
				return filter_var($email, FILTER_VALIDATE_EMAIL) ;
			}

			function show_error($error) {

				echo "<div class='div-feedback'><p class='error'>Désolé, nous n'avons pas pu t'inscrire : </p><ul class='error'>" ;
				foreach ($error as $liste) {
					echo "<li class='error'>$liste</li>";
				}
				echo "</ul></div>" ;

			}

			function show_qcm($qcm) {

				echo "<div class='div-feedback'><p class='error'>Désolé, mais tu n'as pas compris ce qu'est le baptême. Revois tes priorités et recommence.</p></div>" ;

			}
			
			function sendMail($prenom, $nom, $email, $jour, $mois, $annee, $adresse, $destinataire, $sujet, $message) {

				$sujet = $prenom." ".$nom." inscription" ;
				$message =	"Prénom Nom : $prenom $nom\n\r Adresse mail : $email\n\r Date de naissance : $jour $mois $annee\n\r Adresse : $adresse";

				mail ($destinataire, $sujet, $message, 'Content-Type: text/plain; charset=UTF-8');
				echo ("<div class='div-feedback'><p class='success'>C'est envoyé, rendez-vous en bleusaille !</p></div>") ;

			}

			$destinataire = "gwenael.bierlier@etud.infographie-sup.eu" ;
			$p = $_POST ;
			
			$errorPrenom = "Nous avons besoin de ton prénom." ;
			$errorNom = "Nous avons besoin de ton nom." ;
			$errorEmail = "Nous avons besoin de ton mail." ;
			$errorInvalid = "Vérifie que ton mail est correctement inscrit." ;
			$errorDate = "Nous avons besoin de ta date de naissance." ;

			if($p) {

				// Nettoyage
				$mail = trim(strip_tags($p['mail'])) ;
				$prenom = trim(strip_tags($p['prenom'])) ;
				$nom = trim(strip_tags($p['nom'])) ;
				$email = trim(strip_tags($p['email'])) ;
				$adresse = trim(strip_tags($p['adresse'])) ;
				$qcm = $p['qcm'] ;
				$jour = $p['jour'] ;
				$mois = $p['mois'] ;
				$annee = $p['annee'] ;

				// Vérification
				if($mail != '') {

					die ('No.');

				}

				if ( $prenom == '' ) {

					$error[] = $errorPrenom ;
					$e = true ;

				}

				if ( $nom == '' ) {

					$error[] = $errorNom ;
					$e = true ;

				}

				if ( $email == '' ) {

					$error[] = $errorEmail ;
					$e = true ;

				} else if (valid_email($email) == false) {

					$error[] = $errorInvalid ;
					$e = true ;

				}

				if ( $jour == '' || $mois == '' || $annee == '') {

					$error[] = $errorDate ;
					$e = true ;

				}

			}

		?>

		<div class="container">
			
			<img src="cover.svg" alt="cover" draggable="false">

			<div class="form">
	
				<h1>Inscris-toi au Cercle</h1>
				
				<p class="info">Remplis ce petit formulaire pour t'inscrire au Cercle des étudiants de l'ESIAJ.</p>
	
				<?php
	
					// Envoi
					if ($p) {
	
						if ( $e == true ) {
	
							echo show_error($error) ;
	
						} else {
	
							if ($qcm == "qcm2") {
	
								sendMail($prenom, $nom, $email, $jour, $mois, $annee, $adresse, $destinataire, $sujet, $message) ;
	
							} else {
	
								echo show_qcm($qcm) ;
	
							}
	
						}
	
					}
	
				?>
	
				<form method="post">
	
					<label class="mail" for="mail">Mail <abbr value="requis">*</abbr></label>
					<input class="mail" type="text" id="mail" name="mail">
	
					<label class="form--block" for="prenom">Ton prénom <abbr value="requis">*</abbr></label>
					<input class="form--block" type="text" id="prenom" name="prenom" value="<?php if( $p['prenom'] != "" ) { echo $p['prenom'] ;}else{ echo "" ;} ?>">
	
					<label class="form--block" for="nom">Ton nom <abbr value="requis">*</abbr></label>
					<input class="form--block" type="text" id="nom" name="nom"  value="<?php if( $p['nom'] != "" ) { echo $p['nom'] ;}else{ echo "" ;} ?>">
	
					<label class="form--block" for="email">Ton adresse email <abbr value="requis">*</abbr></label>
					<input class="form--block" type="text" id="email" name="email"  value="<?php if( $p['email'] != "" ) { echo $p['email'] ;}else{ echo "" ;} ?>">
	
					<label class="form--block" for="adresse" for="adresse">L'adresse complète de ton kot</label>
					<textarea class="form--block" name="adresse" id="adresse"><?php if( $p['adresse'] != "" ) { echo $p['adresse'] ;}else{ echo "" ;} ?></textarea>
	
					<fieldset>
	
						<legend class="form--block">Ta date de naissance <abbr value="requis">*</abbr></legend>
	
						<select id="date" name="jour" >
							<?php include('jour.inc.php'); ?>
						</select>
	
						<select id="date" name="mois" >
							<?php include('mois.inc.php'); ?> 	
	 					</select>
	
						<select id="date" name="annee" >
							<?php include('annee.inc.php'); ?>
						</select>
	
					</fieldset>
	
					<fieldset>
	
						<legend>Pourquoi souhaites-tu devenir bleu ? <abbr value="requis">*</abbr></legend>
	
						<ul class="radio">
	
							<li>
								<input class="input-qcm" type="radio" id="qcm1" name="qcm" value="qcm1" checked required <?php if( $p['qcm']=='qcm1'){ echo 'checked="checked"';} ?>>
								<label for="qcm1" class="non">Pour boire des bières.</label>
							</li>
	
							<li>
								<input class="input-qcm" type="radio" id="qcm2" name="qcm" value="qcm2" required <?php if( $p['qcm']=='qcm2'){ echo 'checked="checked"';} ?>>
								<label for="qcm2" class="non">Pour me faire des amis.</label>
							</li>
	
							<li>
								<input class="input-qcm" type="radio" id="qcm3" name="qcm" value="qcm3" required <?php if( $p['qcm']=='qcm3'){ echo 'checked="checked"';} ?>>
								<label for="qcm3" class="non">Pour draguer.</label>
							</li>
	
						</ul>
	
					</fieldset>
	
					<input type="submit" value="Envoyer" class="button">
	
					<p class="note">* Champs requis</p>
				
				</form>
				
			</div>

		</div>

		<?php include('footer.inc.php') ; ?>

	</body>

</html>