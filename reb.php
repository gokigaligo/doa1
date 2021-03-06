<!DOCTYPE html>
<html>
<head>
	<title>NDINDE</title>
	<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js" integrity="sha384-Tc5IQib027qvyjSMfHjOMaLkfuWVxZxUPnCJA7l2mCWNIpG9mGCD8wGNIcPD7Txa" crossorigin="anonymous"></script>
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
	<link rel="stylesheet" href="css/bootstrap.min.css" media="all">
	<link rel="stylesheet" href="css/bootstrap-theme.min.css" media="all">
	<link rel="stylesheet" href="css/styles.css" media="all">
	<style type="text/css">
		.progress-bar{
			background-color: #06467c;
		}
	</style>
</head>
<body style="background: #efefef;">
	<div class="container">
		<div class="jumbotron topbar" style="background-color: #3778b0">
			<div class="row">
				<div class="col-md-2">
					<div style="box-shadow: 0 2px 2px 0 rgba(0,0,0,.14), 0 3px 1px -2px rgba(0,0,0,.2), 0 1px 5px 0 rgba(0,0,0,.12);
					    height: 100px;
					    background-color: #d3d5db;
					    width: 100px;
					    background-size: cover;
					    background-repeat: no-repeat;
					    background-position: center center;
					    border-radius: 100px;
					    background-image: url();">
				</div></div>
				<div class="col-md-8" style="overflow-y: hidden;">
					<form class="form-horizontal">
						<div class="form-group">
							<label for="inputEmail3" class="col-sm-3 control-label">LHS ID:</label>
							<div class="col-sm-9">
							  <input type="email" class="form-control" id="inputEmail3" disabled value="25.001/REB/">
							</div>
						</div>
						<div class="form-group">
							<label for="currentTime" class="col-sm-3 control-label">LHS NAME:</label>
							<div class="col-sm-9">
							  <input type="text" class="form-control" id="currentTime" disabled value="RWANDA EDUCATION BOARD">
							</div>
						</div>
					</form>
				</div>
				<div class="col-md-2">
					<div class="form-horizontal">
						<div class="form-group">
						    <div class="col-sm-offset-2 col-sm-10">
						      <form action="login.php">
						      	<button type="submit" class="btn btn-danger">Exit</button>
						      </form>
						    </div>
				  		</div>
				  		<div class="form-group">
						    <div class="col-sm-offset-2 col-sm-10">
						      <button type="button" class="btn btn-success" data-toggle="modal" data-target="#myModal">Grant Access</button>
						    </div>
				  		</div>
				  	</div>
				</div>
			</div>
		</div>
	  	<dir class="row mainContent">
	  		<div class="col-md-9 contentHolder">
	  			<div class="holderHead">NIDA (<?php 
	  			include('db.php');
		  						$sqlNida = $db->query("SELECT * FROM reb");
		  						echo mysqli_num_rows($sqlNida); ?>)</div>
	  			<div class="card card-fluid">
		  			<table class="table table-striped">
		  				<thead>
		  					<tr>
		  						<th>No</th>
		  						<th>Certificate</th>
		  						<th>Points</th>
		  						<th>From</th>
		  						<th>To</th>
		  					</tr>
		  				</thead>
		  				<tbody id="peopleTable">
		  				<?php 
		  					$n=0;
		  					while($row = mysqli_fetch_array($sqlNida))
	  						{
	  							$n++;
	  							$doaClass = $row['handleId'];
	  							if($doaClass == NULL || $doaClass == ""){ $doaClass = 'noDoa';}else{$doaClass = 'withDoa';}
	  							echo '<tr class="'.$doaClass.'" data-names="'.$row['certificate'].'" data-gender="'.$row['points'].'" data-nid="'.$row['institution'].'"><td>'.$n.'</td><td>'.$row['certificate'].'</td><td>'.$row['points'].'</td><td>'.$row['institution'].'</td><td>'.$row['owner'].'</td></tr>';
	  						}
		  				?>
		  				</tbody>
		  			</table>
				</div>
			</div>
	  		<div class="col-md-3 contentHolder">
	  			<div class="holderHead">DOA  (<?php 
		  						$sqlDoa1 = $db->query("SELECT handleId FROM reb WHERE handleId <>'' AND handleId IS NOT NULL")or die(mysqli_error($db));
		  						echo mysqli_num_rows($sqlDoa1); ?>)</div>
	  			<div id="handlesHolder">123</div>
			</div>
	  	</dir><br>
	  	<div class="row mainContent">
	  		<div class="col-md-11">
	  			<div class="progress">
			    <div class="progress-bar progress-bar-striped active progress-bar-dark" role="progressbar" id="handleProgress" aria-valuenow="40" aria-valuemin="0" aria-valuemax="100" style="width:0%">
			      0%
			    </div>
			  </div>
	  		</div>
	  		<div class="col-md-1">
	  			<button class="btn btn-warning" id="generateHandles">Merge</button>
	  		</div>
	  	</div><br>
	  	<dir class="row mainContent">
	  		<div class="col-md-12 contentHolder" style="min-height: 100px;">
	  			<div class="holderHead">ERROR LOG (0)</div>
	  			<div style="color: red;padding: 15px;">
	  				Test error here.
	  			</div>
	  		</div>
	  	</dir><br>
	</div>

<script type="text/javascript">
	//looping 
	//when button is clicked
	genBtn = document.getElementById('generateHandles')
	genBtn.addEventListener('click', function(){
		//get all people to generate handle
		handleElems = document.querySelectorAll('#peopleTable tr.noDoa')
		progressElem = document.getElementById('handleProgress')

		var nGenerated = 5; //number of handles generated
		var nhandleElems = handleElems.length;

		for( n=0; n<handleElems.length; n++){

			handleElem = handleElems[n]

			progressElem.style.width = nGenerated+'%';
			progressElem.innerText = nGenerated+'%';

			//getting details of user
			names 	= handleElem.dataset.names
			gender 	= handleElem.dataset.gender
			nid 	= handleElem.dataset.nid
			console.log(nid);
			$.ajax({
				type: "GET",
				url: "functions.php",
				dataType: "html",
				async: false,
				cache: "false",
				data: {
					action: 'createNidHandle',
					img: 	'img',
					names: 	names,
					gender: gender,
					dob: 	'dob',
					nid: 	nid
				},
				success: function(html, textStatus){
					//progress changing
					console.log(html);
					loopHandles();
					alert("Moving on"+percentage+'%'+nGenerated);
					
				},
				error : function(xht, textStatus, errorThrown){
					alert("Error : " + errorThrown);
				}
			});
			alert("Moving on"+percentage+'%'+nGenerated);
			nGenerated++;
					console.log(nGenerated);
					percentage = (nGenerated/nhandleElems)*100;
					progressElem.style.width = percentage+'%';
					progressElem.innerText = percentage+'%';
					
		}
	})
</script> 
<script type="text/javascript">
(loopHandles())();
function loopHandles(){
	//alert("I am called");
	document.getElementById('handlesHolder').innerHTML ='<svg class="spinner" width="65px" height="65px" viewBox="0 0 66 66" xmlns="http://www.w3.org/2000/svg">'
		   +'<circle class="path" fill="none" stroke-width="6" stroke-linecap="round" cx="33" cy="33" r="30"></circle></svg>';

	$.ajax({
			type : "GET",
			url : "functions.php",
			dataType : "html",
			cache : "false",
			data : {
				action: 'loopHandles'
			},
			success : function(html, textStatus){
				//alert('reslut back');
			$('#handlesHolder').html(html);
			},
			error : function(xht, textStatus, errorThrown){
				alert("Error : " + errorThrown);
			}
		});

	
};

</script>
</body>
</html>