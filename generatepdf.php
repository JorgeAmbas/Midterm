<?php
	function fetch_data(){
		$output = '';
		$conn = mysqli_connect("localhost", "root", "", "link");
		$sql = "SELECT * FROM users";
		$result=mysqli_query($conn,$sql);

		while($row = mysqli_fetch_array($result)){
			$output .= '<tr>
							<td>' . $row["id"].'</td>
							<td>' . $row["username"].'</td>
							<td>' . $row["password"].'</td>
							<td>' . $row["email"].'</td>
						</tr>';
		}
		return $output;
	}

	if(isset($_POST["generate_pdf"])){
		require_once('TCPDF/tcpdf.php');

		$obj_pdf = new TCPDF('P', PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);
		$obj_pdf->SetCreator(PDF_CREATOR);
		$obj_pdf->SetTitle('Users');
		$obj_pdf->SetHeaderData('','', PDF_HEADER_TITLE, PDF_HEADER_STRING);
        $obj_pdf->SetHeaderFont(Array(PDF_FONT_NAME_MAIN, '', PDF_FONT_SIZE_MAIN));
        $obj_pdf->SetFooterFont(Array(PDF_FONT_NAME_DATA, '', PDF_FONT_SIZE_DATA));

        $obj_pdf->SetDefaultMonospacedFont('courier');
        $obj_pdf->SetMargins(PDF_MARGIN_LEFT, '5', PDF_MARGIN_RIGHT);
        $obj_pdf->SetPrintHeader(false);
        $obj_pdf->SetPrintFooter(false); 

        $obj_pdf->SetAutoPageBreak(TRUE, 10);
        $obj_pdf->SetFont('courier', '', 11.5);
        $obj_pdf->AddPage();

        $content='';
        $content.='
        	<h4 align="center"> Generate TABLE DATA to PDF From MySQL Database Using TCPDF in PHP </h4><br/>
        	<table border="1" cellspacing="0" cellpadding="3">
        	<tr>
        		<th width="9%"> ID </th>
        		<th width="38%"> Username </th>
        		<th width="38%"> Password </th>
        		<th width="15%"> Email Address </th>
        	</tr>
        ';
        $content .= fetch_data();
        $content .= '</table>';
        $obj_pdf->writeHTML($content);
        $obj_pdf->Output('Users.pdf', 'D');

	}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <title>Users View</title> 

    <meta charset="UTF-8">
    <meta name="viewport" content="width-device-width, initial-scale=1">
    
    <link rel="stylesheet" href="css/min.css">
    <link rel="stylesheet" href="https://pro.fontawesome.com/releases/v5.10.0/css/all.css" integrity="sha384-AYmEC3Yw5cVb3ZcuHtOA93w35dYTsvhLPVnYs9eStHfGJvOvKxVfELGroGkvsg+p" crossorigin="anonymous">   
    <link rel="stylesheet" type="text/css" href="css/styles.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <link rel="stylesheet" href="css/bootstrap1.css">
    
<style type="text/css">
    body{ font: 14px fantasy; 
    padding-top: 40px;
    padding-bottom: 40px;
    background: linear-gradient(90deg, rgba(251,239,223,1) 0%, rgba(255,221,146,1) 100%);
    height: 100%;
    background-position: absolute;
    background-repeat: no-repeat;
    background-size: cover;
    color: black;
    font-size: 24px;
}

    .wrapper{
        margin-left: 50px;
        margin-top: 90px;
    }
    .wrapper input{
       
        margin-left: -30px;
        
        width: 380px;

    }
    .wrapper label{
       
       margin-left: -30px;
       
   

   }
    .wrapper .btn{
        margin-left: 25px;
        width: 210px;
 
        
    }
    h1{
            
            font-size: 40px;
            font-weight: bold;
            margin-top: -40px;
            margin-left: 100px;
        }
   
  






</style>

<?php
    require_once "database.php";

    $result = mysqli_query($conn,"SELECT * FROM users");

    echo "<table border='5'>
    <tr>
    <th> User ID </th>
    <th> Username </th>
    <th> Password </th>
    <th> Email Address </th>
    </tr>";

    while($row = mysqli_fetch_array($result))
    {
        echo "<tr>";
        echo "<td>" . $row['id'] . "</td>";
        echo "<td>" . $row['username'] . "</td>";
        echo "<td>" . $row['password'] . "</td>";
        echo "<td>" . $row['email'] . "</td>";
        echo "</tr>";
    }
    echo "</table>";

    mysqli_close($conn);
?>   
</head>  
<body>
                
    <div class="wrapper">
        <form action="" method="post" style="margin-top: 20px;" name="login"><br>
        <div class="container">
            <center>
                <button Type="submit" Name="generate_pdf" class="" Value="Generate PDF" />Generate PDF</button>
                
                <button type="button" class="" name="register" style="margin-top: 10px;"onclick="window.location.href='../PHP/adminpage.php'">BACK</button>
        </center></form>
                <br><br>
                <p></p><br><br>
            </center>
        </div>
    </div>
</form>
</body>
<center>
<br>


</center>
</html>