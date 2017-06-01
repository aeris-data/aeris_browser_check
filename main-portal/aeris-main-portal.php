<?php 

/**
 * Plugin Name: aeris-wordpress-project-form
 * Description: Provide form for opened projects 
 * Version: 0.0.1
 * Author: Aeris
 * GitHub Plugin URI: aeris-data/aeris-wordpress-project-form
 *
 **/


function registration_form( $projectName, $description, $context,
		$support, $use, $humanResources, $computingResources, $dueDate, $dueDateJustification,
		$applicantName, $email, $laboratory,
		$manager, $emailManager ) {
	echo '
    <style>
    div {
        margin-bottom:2px;
    }
			
    input{
        margin-bottom:4px;
    }
    </style>
    ';
	
	echo '
    <h3>Description du projet</h3>
<hr />
    <form role="form" data-toggle="validator" action="' . $_SERVER['REQUEST_URI'] . '" method="post">
    	<div class="form-group">
    		<label for="projectName" class="control-label">Nom</label>
   			<input type="text" class="form-control" name="projectName" value="' . ( isset( $_POST['projectName'] ) ? $projectName: null ) . '"
placeholder="Nom du projet" required>
    	</div>
    		
        <div class="form-group">
		    <label for="description">Description <strong>*</strong></label>
    		<textarea name="description" value="' . ( isset( $_POST['description'] ) ? $password : null ) . '" placeholder="Décrivez de manière détaillée les services, mise en place ou traitement de données demandées par le projet" data-error="Description manquante"></textarea>
    <div class="help-block with-errors"></div>

    	</div>
    		
     	<div class="form-group">
    		<label for="contexte">Contexte scientifique <strong>*</strong></label>
    		<textarea type="text" name="contexte" value="' . ( isset( $_POST['context']) ? $context : null ) . '" placeholder="Contexte scientifique" required data-error="Contexte scientifique manquant"></textarea>
    	<div class="help-block with-errors"></div>

    	</div>
    		
     	<div class="form-group">
		    <label for="soutiens">Soutien scientifique</label>
    		<textarea type="text" name="soutiens" value="' . ( isset( $_POST['support']) ? $support : null ) . '" placeholder="required data-error="Soutien scientifique manquant">
				Indiquez les programmes nationaux européens ou internationaux liés au projet. Indiquez le soutien obtenu de la part de ces programmes.
			</textarea>
	    <div class="help-block with-errors"></div>

    	</div>
    		
   		<div class="form-group">
		    <label for="use">Utilisation envisagée</label>
    		<textarea type="text" name="use" value="' . ( isset( $_POST['use']) ? $use : null ) . '" placeholder="-Indiquez les informations relatives à l\'utilisation envisagée du produit: domaine, taille de la communauté, utilisations ...
-Décrivez en quoi la réalisation du projet a un intérêt ou des applications pour la communauté AERIS et au delà" required data-error="Décrivez l\'utilisation du projet">
			</textarea>
    		    <div class="help-block with-errors"></div>

	</div>
    		
    	<div class="form-group">
		    <label for="soutiens">Ressources humaines</label>
    		<textarea type="text" name="humanResources" value="' . ( isset( $_POST['humanResources']) ? $humanResources : null ) . '" placeholder="Indiquez les ressources humaines affectées au projet par le proposant : 
- laboratoires impliqués 
- Chercheurs participants (et leurs pourcentages de temps sur le projet) 
- Personnel technique (et leurs pourcentages de temps sur le projet)" required data-error="Spécifiez les ressources humaines du projet">
			</textarea>
    		    <div class="help-block with-errors"></div>
    	</div>
	
		<div class="form-group">
		    <label for="soutiens">Ressources informatiques</label>
    		    <textarea type="text" name="computingResources" value="' . ( isset( $_POST['computingResources']) ? $computingResources : null ) . '" placeholder="Indiquez les ressources informatiques affectées au projet par le proposant" required data-error="Spécifiez les ressources informatiques du projet">
		     </textarea>
    		    <div class="help-block with-errors"></div>

    	</div>
    		<h3>Echéance</h3>
<hr />
    	<div class="form-group">
    		<label for="dueDate" class="control-label">Echéance</label>
   			<input type="text" class="form-control" name="dueDate" value="' . ( isset( $_POST['dueDate'] ) ? $dueDate: null ) . '"
placeholder="Echéance">
    	</div>

		<div class="form-group">
		    <label for="dueDateJustification">Justification</label>
    		<textarea type="text" name="dueDateJustification" value="' . ( isset( $_POST['dueDateJustification']) ? $dueDateJustification : null ) . '" placeholder="Justification">
			</textarea>
    	</div>
	<h3>Informations concernant le proposant</h3>
	<hr />
	<div class="form-group">
    		<label for="applicantName" class="control-label">Nom</label>
   			<input type="text" class="form-control" name="applicantName" value="' . ( isset( $_POST['applicantName'] ) ? $applicantName: null ) . '"
placeholder="Nom" required data-error="Spécifiez le nom du référant projet">
    		    <div class="help-block with-errors"></div>
    </div>
	<div class="form-group">
    		<label for="email" class="control-label">Mail <i>Une copie de votre demande sera envoyée à cette adresse</i></label>
   		<input type="email" class="form-control" name="email" value="' . ( isset( $_POST['email'] ) ? $email: null ) . '"
placeholder="email" required data-error="votre adresse mail">
		 <div class="help-block with-errors"></div>
    </div>
	<div class="form-group">
    		<label for="laboratory" class="control-label">Laboratoire *</label>
   			<input type="text" class="form-control" name="laboratory" value="' . ( isset( $_POST['laboratory'] ) ? $laboratory: null ) . '"
placeholder="Laboratoire" required data-error="Nom du laboratoire">
		 <div class="help-block with-errors"></div>
    </div>
	<div class="form-group">
    		<label for="manager" class="control-label">Nom du directeur *</label>
   			<input type="text" class="form-control" name="manager" value="' . ( isset( $_POST['manager'] ) ? $manager: null ) . '"
placeholder="Nom du directeur" data-error="Saisir le nom du directeur" required>
		 <div class="help-block with-errors"></div>
    </div>
	<div class="form-group">
    		<label for="emailManager" class="control-label">Email du directeur *</label>
   			<input type="email" class="form-control" name="emailManager" value="' . ( isset( $_POST['emailManager'] ) ? $emailManager: null ) . '"
placeholder="Nom du directeur" required data-error="Saisir l\'email du directeur">
			 <div class="help-block with-errors"></div>
    </div>
    <button type="submit" name="submit" class="btn btn-primary">Envoyer</button>
    </form>


    ';
}


global $reg_errors;
$reg_errors = new WP_Error;

add_action('wp_enqueue_scripts', function() {
				wp_enqueue_media( $args );

				wp_register_script('formproject', plugin_dir_url(__FILE__). '/js/form_project.js');
		
				wp_enqueue_script('formproject');

			}); 
			
// Register a new shortcode: [cr_custom_registration]
add_shortcode( 'cr_custom_registration', 'custom_registration_shortcode' );

// The callback function that will replace [book]
function custom_registration_shortcode() {
	ob_start();
	custom_registration_function();
	return ob_get_clean();
}


function custom_registration_function() {
	registration_form( $projectName, $description, $context,
		$support, $use, $humanResources, $computingResources, $dueDate, $dueDateJustification,
		$applicantName, $email, $laboratory,
		$manager, $emailManager );
	
        

         if(isset($_POST['submit']) && !empty($_POST)){

	 $name = stripslashes($_POST['projectName']);
	 $description = stripslashes($_POST['description']);
         $context = stripslashes($_POST['context']);
	 $support = stripslashes($_POST['support']);
	 $use = stripslashes($_POST['use']);

         $computingResources = stripslashes($_POST['computingResources']);
         $humanResources = stripslashes($_POST['humanResources']);
	 $dueDate = $_POST['dueDate'];
         $dueDateJustification = stripslashes($_POST['dueDateJustification']);
         $applicantName = stripslashes($_POST['applicantName']);
         $email = $_POST['email'];
         
         ValidateEmail($email);
	 $email = trim($email);
         $laboratory = stripslashes($_POST['laboratory']);
	 $manager = stripslashes($_POST['manager']);
	 $email_manager = stripslashes($_POST['emailManager']);	
         ValidateEmail($email_manager);
	 $emailManager = trim($email_manager);
	 
	 $subject = "appel à projet ".$name;
         $to = "clemansles@gmail.com";
         $message = " <html> 
                          <label>nom du projet : </label>".$name."<br />".
                          "<label>description : </label>".$description."<br />".
 			  "<label>contexte : </label>".$context."<br />".
			  "<label>soutiens : </label>".$support."<br />".
			  "<label>utilisation : </label>".$use."<br />".
			  "<label>ressources humaines : </label>".$humanResources."<br />".
			  "<label>ressources informatique : </label>".$computingResources."<br />".
			  "<label>echeance : </label>".$dueDate."<br />".
			  "<label>justification : </label>".$dueDateJustification."<br />".
			  "<label>nom référant : </label>".$applicantName."<br />".
			  "<label>email : </label>".$email."<br />".
			  "<label>laboratoire : </label>".$laboratory."<br />".
			  "<label>directeur : </label>".$manager."<br />".
			  "<label>email directeur : </label>".$emailManager."<br /></html>";
	
	 $mail = wp_mail($to, $subject, $message,
			 'From: '.$applicantName.' <'.$email.'>\r\n'
			.'Reply-To: '.$email.'\r\n'
			.'X-Mailer: PHP/' . phpversion());
 
		if($mail)
		{
			echo 'OK';
		}

	 }
	
}

function ValidateEmail($email)
{
	/*
	(Name) Letters, Numbers, Dots, Hyphens and Underscores
	(@ sign)
	(Domain) (with possible subdomain(s) ).
	Contains only letters, numbers, dots and hyphens (up to 255 characters)
	(. sign)
	(Extension) Letters only (up to 10 (can be increased in the future) characters)
	*/
 
	$regex = '/([a-z0-9_.-]+)'. # name

	'@'. # at

	'([a-z0-9.-]+){2,255}'. # domain & possibly subdomains

	'.'. # period

	'([a-z]+){2,10}/i'; # domain extension 

	if($email == '') { 
		return false;
	}
	else {
		$eregi = preg_replace($regex, '', $email);
	}
 
	return empty($eregi) ? true : false;
}
?>