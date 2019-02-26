<?php

	/*  
	  ini_set('display_errors', true);
	  error_reporting(E_ALL); 
	 */
  
	require_once('lib/nusoap.php');
	$error  = '';
	$result = array();
	$response = '';
	$wsdl = "https://localhost/web-services/webservice-server.php?wsdl";
	if(isset($_POST['isbn'])){
		$isbn = trim($_POST['isbn']);
		if(!$isbn){
			$error = 'Ingrese un codigo.';
		}

		if(!$error){
			//create client object
			$client = new nusoap_client($wsdl, true);
			$err = $client->getError();
			if ($err) {
				echo '<h2>Constructor error</h2>' . $err;
				// At this point, you know the call that follows will fail
			    exit();
			}
			 try {
				$result = $client->call('fetchBookData', array($isbn));
				$result = json_decode($result);
			  }catch (Exception $e) {
			    echo 'Caught exception: ',  $e->getMessage(), "\n";
			 }
		}
	}	

	/* Add new book **/
	if(isset($_POST['addbtn'])){
		$title = trim($_POST['title']);
		$isbn = trim($_POST['isbn']);
		$author = trim($_POST['author']);
		$category = trim($_POST['category']);
		$price = trim($_POST['price']);

		//Perform all required validations here
		if(!$isbn || !$title || !$author || !$category || !$price){
			$error = 'All fields are required.';
		}

		if(!$error){
			//create client object
			$client = new nusoap_client($wsdl, true);
			$err = $client->getError();
			if ($err) {
				echo '<h2>Constructor error</h2>' . $err;
				// At this point, you know the call that follows will fail
			    exit();
			}
			 try {
				/** Call insert book method */
				 $response =  $client->call('insertBook', array($title, $author, $price, $isbn, $category));
				 $response = json_decode($response);
			  }catch (Exception $e) {
			    echo 'Caught exception: ',  $e->getMessage(), "\n";
			 }
		}
	}

?>
<!DOCTYPE html>
<html lang="en">
<head>
  <title>Web Service SOAP-PHP</title>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.0/jquery.min.js"></script>
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
</head>
<body>

<div class="container">
  <h2>SOAP Web Service PHP</h2>
  <h4>Ing. Javier La Cruz</h4>
  
  <br />       
  <div class='row'>
  	<form class="form-inline" method = 'post' name='form1'>
  		<?php if($error) { ?> 
	    	<div class="alert alert-danger fade in">
    			<a href="#" class="close" data-dismiss="alert">&times;</a>
    			<strong>Error!</strong>&nbsp;<?php echo $error; ?> 
	        </div>
		<?php } ?>
	    <div class="form-group">
	      <label for="email">Codigo:</label>
	      <input type="text" class="form-control" name="isbn" id="isbn" placeholder="Ingrese Codigo a Buscar" required>
	    </div>
	    <button type="submit" name='sub' class="btn btn-default">Buscar</button>
    </form>
   </div>
   <br />
   <h3>Datos del codigo consultado:</h3>
  <table class="table">
    <thead>
      <tr>
        <th>Tutulo</th>
        <th>Autor</th>
        <th>Precio</th>
        <th>Cod</th>
        <th>Categoria</th>
      </tr>
    </thead>
    <tbody>
    <?php if($result){ ?>
      	
		      <tr>
		        <td><?php echo $result->title; ?></td>
		        <td><?php echo $result->author_name; ?></td>
		        <td><?php echo $result->price; ?></td>
		        <td><?php echo $result->isbn; ?></td>	
		        <td><?php echo $result->category; ?></td>
		      </tr>
      <?php 
  		}else{ ?>
  			<tr>
		        <td colspan='5'>No existen Datos</td>
		      </tr>
  		<?php } ?>
    </tbody>
  </table>
	<div class='row'>
	<h3>Formulario de Registro</h3>
	 <?php if(isset($response->status)) {

	  if($response->status == 200){ ?>
		<div class="alert alert-success fade in">
    			<a href="#" class="close" data-dismiss="alert">&times;</a>
    			<strong>Success!</strong>&nbsp; Agregado Correctamente. 
	        </div>
	  <?php }elseif(isset($response) && $response->status != 200) { ?>
			<div class="alert alert-danger fade in">
    			<a href="#" class="close" data-dismiss="alert">&times;</a>
    			<strong>Error!</strong>&nbsp; No se realizo el registro, intente nuevamente. 
	        </div>
	 <?php } 
	 }
	 ?>
  	<form class="form-inline" method = 'post' name='form1'>
  		<?php if($error) { ?> 
	    	<div class="alert alert-danger fade in">
    			<a href="#" class="close" data-dismiss="alert">&times;</a>
    			<strong>Error!</strong>&nbsp;<?php echo $error; ?> 
	        </div>
		<?php } ?>
	    <div class="form-group">
	      <label for="email"></label>
	      <input type="text" class="form-control" name="title" id="title" placeholder="Titulo" required>
				<input type="text" class="form-control" name="author" id="author" placeholder="Autor" required>
				<input type="text" class="form-control" name="price" id="price" placeholder="Precio" required>
				<input type="text" class="form-control" name="isbn" id="isbn" placeholder="Codigo" required>
				<input type="text" class="form-control" name="category" id="category" placeholder="Categoria" required>
	    </div>
	    <button type="submit" name='addbtn' class="btn btn-default">Agregar</button>
    </form>
   </div>
</div>

</body>
</html>



