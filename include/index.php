<?php 
	if(isset($_SERVER['HTTP_X_REQUESTED_WITH']) && strtolower($_SERVER['HTTP_X_REQUESTED_WITH'])=="xmlhttprequest"){
	$mysqli = new mysqli("localhost","root","root1156.","water");
// Check connection
				if (mysqli_connect_errno())
				{
				echo "Failed to connect to MySQL: " . mysqli_connect_error();
				}
	
	
	
	 $sql = 'SELECT * from zh_date where `phone`="'.$_POST['phone'].'" LIMIT 1;';
	 $result = $mysqli->query($sql);
	$result = $result->fetch_row();
	 if(!$result){
		$url = 'insert into zh_date(phone,ctime) values("'.$_POST['phone'].'","'.time().'");';
		$query = $mysqli->query($url);
		echo 2;
	}
	else{
		echo 1;
	}
	/*$query->free();//ÊÍ·ÅÄÚ´æ*/
    $mysqli->close(); 
	
	}
	
	