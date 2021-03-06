<?php
	session_start();
    if(!isset($_SESSION['login_user']) || !isset($_SESSION['user-id'])){
        header('location: login.html');
    }
#Verbindung mit der Datenbank
$conn = mysqli_connect("127.0.0.1","swpuser","swpuser","swp");
if(mysqli_connect_errno()){
    die("DB Connection-Error please contact the server admin");
}

	# x wird in diesem Code als hochzählbare Variable für for-Schleifen genutzt

	$Zahl1 = $_POST["zahl1"];
	$Zahl2 = $_POST["zahl2"];
	$Zahl3 = $_POST["zahl3"];
	$Zahl4 = $_POST["zahl4"];
	$Zahl5 = $_POST["zahl5"];
	$Zahl6 = $_POST["zahl6"];
	
	$getippteZahlen = [$Zahl1, $Zahl2, $Zahl3, $Zahl4, $Zahl5, $Zahl6] ;
	$alleRichtige = [];
	$Ende = false;
	$gewonnenerPreis = 0;
	
	$SESSION_userID = $_SESSION['user-id'];
?>
<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, shrink-to-fit=no">
    <title> Lottery 6/49  - Sloterino</title>
    <link rel="stylesheet" href="assets/bootstrap/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i">
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.12.0/css/all.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <link rel="stylesheet" href="assets/fonts/fontawesome5-overrides.min.css">
    <link rel="stylesheet" href="assets/css/profile.css">
    <link rel="stylesheet" href="assets/css/untitled.css">
</head>

<body id="page-top">
    <div id="wrapper">
        <nav class="navbar navbar-dark align-items-start sidebar sidebar-dark accordion bg-gradient-primary p-0">
            <div class="container-fluid d-flex flex-column p-0"><a class="navbar-brand d-flex justify-content-center align-items-center sidebar-brand m-0" href="#">
                    <div class="sidebar-brand-icon"><i class="fab fa-viacoin"></i></div>
                    <div class="sidebar-brand-text mx-3"><span>Sloterino</span></div>
                </a>
                <hr class="sidebar-divider my-0">
                <ul class="navbar-nav text-light" id="accordionSidebar">
                    <li class="nav-item"><a class="nav-link" href="index.html"><i class="fa fa-gamepad"></i><span>Games</span></a></li>
                    <li class="nav-item"><a class="nav-link" href="profile.html"><i class="fas fa-user"></i><span>Profile</span></a></li>
                    <?php 
                    $sql = "SELECT Admin FROM User WHERE UserID = ". $_SESSION['user-id'];
                    $res = $conn->query($sql);
                    if($res->num_rows > 0){
                        if($res->fetch_assoc()["Admin"] == 1){
                            echo('<li class="nav-item"><a class="nav-link" href="table.html"><i class="fas fa-users-cog"></i><span>Admin</span></a></li>');
                        }
                    }else{
                        die("Invalid or no userID");
                    }
                    ?>
                </ul>
                <div class="text-center d-none d-md-inline"><button class="btn rounded-circle border-0" id="sidebarToggle" type="button"></button></div>
            </div>
        </nav>
        <div class="d-flex flex-column" id="content-wrapper">
            <div id="content">
                <nav class="navbar navbar-light navbar-expand bg-white shadow mb-4 topbar static-top">
                    <div class="container-fluid"><button class="btn btn-link d-md-none rounded-circle me-3" id="sidebarToggleTop" type="button"><i class="fas fa-bars"></i></button>
                        <ul class="navbar-nav flex-nowrap ms-auto">
                            <li class="nav-item dropdown d-sm-none no-arrow"><a class="dropdown-toggle nav-link" aria-expanded="false" data-bs-toggle="dropdown" href="#"><i class="fas fa-search"></i></a>
                                <div class="dropdown-menu dropdown-menu-end p-3 animated--grow-in" aria-labelledby="searchDropdown">
                                    <form class="me-auto navbar-search w-100">
                                        <div class="input-group"><input class="bg-light form-control border-0 small" type="text" placeholder="Search for ...">
                                            <div class="input-group-append"><button class="btn btn-primary py-0" type="button"><i class="fas fa-search"></i></button></div>
                                        </div>
                                    </form>
                                </div>
                            </li>
                            <li class="nav-item dropdown no-arrow mx-1">
                                <div class="nav-item dropdown no-arrow"><a class="dropdown-toggle nav-link" aria-expanded="false" data-bs-toggle="dropdown" href="#"></a>
                                    <div class="dropdown-menu dropdown-menu-end dropdown-list animated--grow-in">
                                        <h6 class="dropdown-header">alerts center</h6><a class="dropdown-item d-flex align-items-center" href="#">
                                            <div class="me-3">
                                                <div class="bg-primary icon-circle"><i class="fas fa-file-alt text-white"></i></div>
                                            </div>
                                            <div><span class="small text-gray-500">December 12, 2019</span>
                                                <p>A new monthly report is ready to download!</p>
                                            </div>
                                        </a><a class="dropdown-item d-flex align-items-center" href="#">
                                            <div class="me-3">
                                                <div class="bg-success icon-circle"><i class="fas fa-donate text-white"></i></div>
                                            </div>
                                            <div><span class="small text-gray-500">December 7, 2019</span>
                                                <p>$290.29 has been deposited into your account!</p>
                                            </div>
                                        </a><a class="dropdown-item d-flex align-items-center" href="#">
                                            <div class="me-3">
                                                <div class="bg-warning icon-circle"><i class="fas fa-exclamation-triangle text-white"></i></div>
                                            </div>
                                            <div><span class="small text-gray-500">December 2, 2019</span>
                                                <p>Spending Alert: We've noticed unusually high spending for your account.</p>
                                            </div>
                                        </a><a class="dropdown-item text-center small text-gray-500" href="#">Show All Alerts</a>
                                    </div>
                                </div>
                            </li>
                            <!-- balance and username -->
                            <li class="nav-item dropdown no-arrow mx-1">
                                <div class="nav-item dropdown no-arrow"><a class="dropdown-toggle nav-link" aria-expanded="false" data-bs-toggle="dropdown" href="#" style="color: rgb(84,85,96);" id="balance"></a>
                                    <div class="dropdown-menu dropdown-menu-end dropdown-list animated--grow-in">
                                        <h6 class="dropdown-header">Recent Transactions</h6>
                                        <div id="recent-transactions">
                                        </div>
                                        <a class="dropdown-item text-center small text-gray-500" href="transactions.html">Show all transactions</a>
                                    </div>
                                </div>
                                <div class="shadow dropdown-list dropdown-menu dropdown-menu-end"
                                    aria-labelledby="alertsDropdown"></div>
                            </li>
                            <div class="d-none d-sm-block topbar-divider"></div>
                            <li class="nav-item dropdown no-arrow">
                                <div class="nav-item dropdown no-arrow"><a class="dropdown-toggle nav-link" aria-expanded="false" data-bs-toggle="dropdown" href="#"><span class="d-none d-lg-inline me-2 text-gray-600 small" id="username"></span><img class="border rounded-circle img-profile" style="object-fit: cover;" src="" id="img-profile"></a>
                                    <div class="dropdown-menu shadow dropdown-menu-end animated--grow-in"><a class="dropdown-item" href="profile.html"><i class="fas fa-user fa-sm fa-fw me-2 text-gray-400"></i>&nbsp;Profile</a>
                                        <div class="dropdown-divider"></div><a class="dropdown-item" href="logout.html"><i class="fas fa-sign-out-alt fa-sm fa-fw me-2 text-gray-400"></i>&nbsp;Logout</a>
                                    </div>
                                </div>
                            </li>
                            <!-- end balance and username -->
                        </ul>
                    </div>
                </nav>
                <div class="container-fluid">
                    <h3 class="text-dark mb-1">Lottery draw</h3>
                    
                    <?php
                    #Überprüfung Doppelte
					$set = [];
					foreach ($getippteZahlen as $zahl)
					{
						if (in_array($zahl, $set)) 
						{
							echo("Your selected numbers were not unique. Please select again.");
							$Ende = true;
							break;
						}
						
						else 
						{
							$set[] = $zahl; 
						}
					}

					
					if ($Ende == false) #falls keine Zahl doppelt war
					{
								
						#Zufallszahlen
						$alleZahlen = range (1,49);
						shuffle ($alleZahlen);
						
						$lottoZahlen = array_slice($alleZahlen, 0,6);
						sort($lottoZahlen);
						
						echo "The lottery numbers are: <BR>";
						for ($x = 0; $x < 6; $x++  )
						{
							echo "$lottoZahlen[$x]   ";
						}

						#Überprüfung der Übereinstimmungen
						for($x=0; $x<6; $x++)
						{
							if(in_array($getippteZahlen[$x] ,$lottoZahlen))
							{
							array_push ($alleRichtige, $getippteZahlen[$x]);
							}
						}
						
						#Ausgabe der Richtigen
						if (count($alleRichtige) >  0)
						{
							echo ("<BR><BR> Your matches:<BR>");
					
						
							for ($x=0; $x<count($alleRichtige); $x++)
							{
								echo ("$alleRichtige[$x] ");
							}

							#Preisberechnung
							$qgewinn = "SELECT Gewinn FROM Game WHERE GameID = 2";
						  
							$Hauptgewinn= mysqli_query($conn, $qgewinn);
						  
									$row = mysqli_fetch_assoc($Hauptgewinn); 
									if(!$row) {
										echo "no rows\n";
									}
									$gewinn = $row["Gewinn"];
											
							
							if (count($alleRichtige) ==  2)
							{
								$gewonnenerPreis = $gewinn / 62500; 
							}
							
							if (count($alleRichtige) ==  3)
							{
								$gewonnenerPreis = $gewinn / 15625;
							}
							
							if (count($alleRichtige) ==  4)
							{
								$gewonnenerPreis = $gewinn / 2000;
							}
							
							if (count($alleRichtige) ==  5)
							{
								$gewonnenerPreis = $gewinn / 50;
							}
							
							if (count($alleRichtige) ==  6)
							{
								$gewonnenerPreis = $gewinn;
							}
							
							if (count($alleRichtige) > 1)
							{
							echo ("<BR> <BR> You won $gewonnenerPreis $!");
							}	
						}
						
						if ((count($alleRichtige)) ==0 or (count($alleRichtige)) ==1 )
						{
								echo ("<BR> <BR>Unfortunately you did not win anything!");
						}
					
						
						#Kontostand aktualisieren
						$qKonto = " SELECT Kontostand FROM User WHERE UserID = $SESSION_userID ";
						$resKonto= mysqli_query($conn, $qKonto);
								
								$row = mysqli_fetch_assoc($resKonto); 
								if(!$row) {
									echo "no rows\n";
								}
								$Kontostand = $row["Kontostand"];
								
						$qEinsatz = " SELECT Mindesteinsatz FROM Game WHERE GameID = 2";
						$resEinsatz= mysqli_query($conn, $qEinsatz);
								
								$row = mysqli_fetch_assoc($resEinsatz); 
								if(!$row) {
									echo "no rows\n";
								}
								$Einsatz = $row["Mindesteinsatz"];
								
								$neuerKontostand = $Kontostand - $Einsatz + $gewonnenerPreis;
								
						
						$qneuerStand = "UPDATE User SET `Kontostand` =$neuerKontostand WHERE UserID = $SESSION_userID";
					 
						$Einsatz= mysqli_query($conn, $qneuerStand);	
						
						#PaymentHistory-Eintrag hinzufügen
						$datum = date('Y-m-d H:i:s');
						
						$betrag =  $gewonnenerPreis - $Einsatz;
								
		
						$qHistory = "INSERT INTO `paymenthistory`( `Datum`, `Betrag`, `Typ`, `UserID`,`GameID` ) VALUES ('$datum','$betrag','Lotto', $SESSION_userID, 2)";	
						$resHistory= mysqli_query($conn, $qHistory);		
						
						}		



?>	

<BR>
<BR>
<BR>
<BR>

<A HREF="lotto.html" NAME="x">select new numbers</A>
</BODY>


                </div>
                
            </div>
            <footer class="bg-white sticky-footer">
                <div class="container my-auto">
                    <div class="text-center my-auto copyright"><span>Copyright © Sloterino 2021</span></div>
                </div>
            </footer>
        </div><a class="border rounded d-inline scroll-to-top" href="#page-top"><i class="fas fa-angle-up"></i></a>
    </div>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/5.0.0-beta2/js/bootstrap.bundle.min.js"></script>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script src="assets/js/site.js"></script>
    <script src="assets/js/games.js"></script>
    <script src="assets/js/theme.js"></script>
</body>

</html>
