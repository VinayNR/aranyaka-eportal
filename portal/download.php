<html> 
<head>
    <title>File download</title>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
    <link href='css/bootstrap.css' rel='stylesheet'> 
    <link rel="stylesheet" type="text/css" href="index.css">
    <link rel="stylesheet" type="text/css" href="eportal.css">
	
	<script>	
		function download_file(Id)
		{
			$.post("DownloadFile.php",
				{
					id: Id
				},
				function(data,status){
					alert(data);
			});
		}
	</script>
	
	<script>
		history.pushState(null, null, document.URL);
		window.addEventListener('popstate', function () {
			history.pushState(null, null, document.URL);
		});
	</script>
	<style>
	.logout{
			margin-right:3%;
	}
	</style>
</head>
    <body>
         <div class="row">
            <div class='col-xs-12'>
                <div class="style"> 
                    <div class='navbar navbar-inverse navbar-fixed-top'>
                            <ul class="nav navbar-nav">
                                <li><a href="mysHomed.php" title="Go Back"><img src="back.png" style="width:50px;height:50px;"></a></li>
                                <li><strong><font size=5px>E-Portal</font></strong></li>
                                <li><a class="btn btn-success" href="index.php">HOME</a></li>
                            </ul>
							<ul class="nav nav-tabs navbar-right logout">
                                <li><form method="POST"><input class="btn navbar-btn btn-danger" type="submit" value="Logout " name="Logout"/></form></li>
							</ul>						
                    </div>
                </div>
            </div>
        </div>
		<br><br><br><br>
		<div class="row">
			<div class="container-fluid">
				<?php
					session_start();
					ob_start();
					require_once 'dbconnect.php';
					
					if(@$_SESSION['student'] == "") 
					{ 
						header("Location: mysLogind.php");
						exit;
					} 
				 
					if(isset($_POST['Logout']))
					{
						session_destroy();
						header("Location: mysLogind.php");
						exit;
					}
					
					if(@$_GET['sub']!="") 
					{
						$subject = $_GET['sub'];
						$_SESSION['subject'] = $subject;
					}
					$subject = $_SESSION['subject'];
					$query = "SELECT id, subject, name FROM upload WHERE subject = '$subject'";
					$result = mysqli_query($conn, $query) or die('Error, query failed');
					if(mysqli_num_rows($result)==0) 
					{
						echo "<div class=\"container-fluid\">
								<p>No contents uploaded for this subject!</p>
							</div>" ;	
						die();
					}
					?>
					<?php
					echo "<table class=\"table table-striped table-hover\" style=\"width:100%\">
							 <tr>
								<th>File Name</th>
								<th></th> 
							 </tr>";
					while(list($id, $sub, $name) = mysqli_fetch_array($result))
					{
						echo "<tr>";
						echo "<td>"; echo $sub . " " . $name . " "; echo "</td>";
						?>
						<td><a href="DownloadFile.php?id=<?php echo $id; ?>" ><button class="btn-success">Download</button></a></td>
					<?php
						echo "</tr>";
					}
					?>
					<?php 
					echo "</table>";
				?>
			</div>
		</div>
	</body>
</html>
