<?php
//code to clear flag

?>

<!DOCTYPE html>
<html>

<head>
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<meta charset="utf-8">
	<link href="css/bootstrap.min.css" rel="stylesheet">
	<script src="js/bootstrap.min.js"></script>
	<script src="jquery.min.js"></script>
	<script>
		// $(document).ready(function() {
		// 	$("#getUID").load("UIDContainer.php");
		// 	setInterval(function() {
		// 		$("#getUID").load("UIDContainer.php");
		// 	}, 500);
		// });
	</script>
	<style>
		html {
			font-family: Arial;
			display: inline-block;
			margin: 0px auto;
			text-align: center;
		}

		ul.topnav {
			list-style-type: none;
			margin: auto;
			padding: 0;
			overflow: hidden;
			background-color: #4CAF50;
			width: 70%;
		}

		ul.topnav li {
			float: left;
		}

		ul.topnav li a {
			display: block;
			color: white;
			text-align: center;
			padding: 14px 16px;
			text-decoration: none;
		}

		ul.topnav li a:hover:not(.active) {
			background-color: #3e8e41;
		}

		ul.topnav li a.active {
			background-color: #333;
		}

		ul.topnav li.right {
			float: right;
		}

		@media screen and (max-width: 600px) {

			ul.topnav li.right,
			ul.topnav li {
				float: none;
			}
		}

		td.lf {
			padding-left: 15px;
			padding-top: 12px;
			padding-bottom: 12px;
		}

		/*  */
		.row-container {
			display: flex;
			flex-direction: row;
			margin: auto;
			justify-content: space-around;
		}
	</style>

	<title>Read Tag : NodeMCU V3 ESP8266 / ESP12E with MYSQL Database</title>
</head>

<body>
	<h2 align="center">NodeMCU V3 ESP8266 / ESP12E with MYSQL Database</h2>
	<ul class="topnav">
		<li><a href="home.php">Home</a></li>
		<li><a href="user data.php">User Data</a></li>
		<li><a href="registration.php">Registration</a></li>
		<li><a href="read tag.php">Read Tag ID</a></li>
		<li><a class="active" href="topup.php">Top-UP</a></li>
	</ul>

	<br>

	<h3 align="center" id="blink">Please Scan Tag to Display ID or User Data</h3>

	<p id="getUID" hidden></p>

	<br>
	<div class="row-container">
		<div id="show_merchant_data">
			<form id="show_merchant_data_form">
				<table width="452" border="1" bordercolor="#10a0c5" align="center" cellpadding="0" cellspacing="1" bgcolor="#000" style="padding: 2px">
					<tr>
						<td height="40" align="center" bgcolor="#10a0c5">
							<font color="#FFFFFF">
								<b>Merchant Data</b>
							</font>
						</td>
					</tr>
					<tr>
						<td bgcolor="#f9f9f9">
							<table id="merchant_table" width="452" border="0" align="center" cellpadding="5" cellspacing="0">
								<tr>
									<td width="113" align="left" class="lf">ID</td>
									<td style="font-weight:bold">:</td>
									<td align="left">--------</td>
								</tr>
								<tr bgcolor="#f2f2f2">
									<td align="left" class="lf">Name</td>
									<td style="font-weight:bold">:</td>
									<td align="left">--------</td>
								</tr>
								<tr>
									<td align="left" class="lf">Gender</td>
									<td style="font-weight:bold">:</td>
									<td align="left">--------</td>
								</tr>
								<tr bgcolor="#f2f2f2">
									<td align="left" class="lf">Email</td>
									<td style="font-weight:bold">:</td>
									<td align="left">--------</td>
								</tr>
								<tr>
									<td align="left" class="lf">Mobile Number</td>
									<td style="font-weight:bold">:</td>
									<td align="left">--------</td>
								</tr>
							</table>
						</td>
					</tr>
				</table>
			</form>
		</div>

		<div id="show_customer_data">
			<form id="show_customer_data_form">
				<table width="452" border="1" bordercolor="#10a0c5" align="center" cellpadding="0" cellspacing="1" bgcolor="#000" style="padding: 2px">
					<tr>
						<td height="40" align="center" bgcolor="#10a0c5">
							<font color="#FFFFFF">
								<b>Customer Data</b>
							</font>
						</td>
					</tr>
					<tr>
						<td bgcolor="#f9f9f9">
							<table id="customer_table" width="452" border="0" align="center" cellpadding="5" cellspacing="0">
								<tr>
									<td width="113" align="left" class="lf">ID</td>
									<td style="font-weight:bold">:</td>
									<td align="left">--------</td>
								</tr>
								<tr bgcolor="#f2f2f2">
									<td align="left" class="lf">Name</td>
									<td style="font-weight:bold">:</td>
									<td align="left">--------</td>
								</tr>
								<tr>
									<td align="left" class="lf">Gender</td>
									<td style="font-weight:bold">:</td>
									<td align="left">--------</td>
								</tr>
								<tr bgcolor="#f2f2f2">
									<td align="left" class="lf">Email</td>
									<td style="font-weight:bold">:</td>
									<td align="left">--------</td>
								</tr>
								<tr>
									<td align="left" class="lf">Mobile Number</td>
									<td style="font-weight:bold">:</td>
									<td align="left">--------</td>
								</tr>
							</table>
						</td>
					</tr>
				</table>
			</form>
		</div>
	</div>
	<div class="row-container controls">
		<button>Top-UP</button>
		<button onclick="return clearMerchant()">Clear Merchant</button>
		<button onclick="return clearCustomer()">Clear Customer</button>
		<button onclick="return clearAll()">Clear All</button>
	</div>
	<script>
		/*
		^modify tables
		create funciton to update each table
		read data to tables with interavls
		create flags to kill intervals
		*/
		var merchantFound = false;
		var customerFound = false;
		var merchantID = "";
		var customerID = "";


		var myVar = setInterval(timerNewID, 1000);
		var myVar1 = setInterval(timerUpdatedID, 1000);
		var oldID = "";
		clearInterval(myVar1);

		function timerNewID() {
			// var getID = document.getElementById("getUID").innerHTML;
			// oldID = getID;
			
			if (merchantFound&&customerFound) {
				myVar1 = setInterval(timerUpdatedID, 500);
				// showUser(getID);
				showCustomer(merchantID);
				showMerchant(customerID);


				clearInterval(myVar);
			}else{
				if(!merchantFound){
					fetch()
				}
				if(!customerFound){

				}
			}
		}

		function timerUpdatedID() {
			var getID = document.getElementById("getUID").innerHTML;
			if (oldID != getID) {
				myVar = setInterval(timerNewID, 500);
				clearInterval(myVar1);
			}
		}

		function showUser(str) {
			if (str == "") {
				document.getElementById("show_user_data").innerHTML = "";
				return;
			} else {
				if (window.XMLHttpRequest) {
					// code for IE7+, Firefox, Chrome, Opera, Safari
					xmlhttp = new XMLHttpRequest();
				} else {
					// code for IE6, IE5
					xmlhttp = new ActiveXObject("Microsoft.XMLHTTP");
				}
				xmlhttp.onreadystatechange = function() {
					if (this.readyState == 4 && this.status == 200) {
						document.getElementById("show_user_data").innerHTML = this.responseText;
					}
				};
				xmlhttp.open("GET", "read tag user data.php?id=" + str, true);
				xmlhttp.send();
			}
		}
		function showCustomer(id){
			let link = "readtag.php?id=" + id ;
			fetch(link).then((res)=>res.text()).then((data)=>{
				document.querySelector("#customer_table").innerHTML = data;
			})
		}
		function showMerchant(id){
			let link = "readtag.php?id=" + id ;
			fetch(link).then((res)=>res.text()).then((data)=>{
				document.querySelector("#merchant_table").innerHTML = data;
			})
		}
		var blink = document.getElementById('blink');
		setInterval(function() {
			blink.style.opacity = (blink.style.opacity == 0 ? 1 : 0);
		}, 750);

		function clearCustomer(){
			document.querySelector("#customer_table").innerHTML = defaultTable;
		}
		function clearMerchant(){
			document.querySelector("#merchant_table").innerHTML = defaultTable;
		}
		function clearAll(){
			clearCustomer();
			clearMerchant();
		}
		var defaultTable = `<tr>
									<td width="113" align="left" class="lf">ID</td>
									<td style="font-weight:bold">:</td>
									<td align="left">--------</td>
								</tr>
								<tr bgcolor="#f2f2f2">
									<td align="left" class="lf">Name</td>
									<td style="font-weight:bold">:</td>
									<td align="left">--------</td>
								</tr>
								<tr>
									<td align="left" class="lf">Gender</td>
									<td style="font-weight:bold">:</td>
									<td align="left">--------</td>
								</tr>
								<tr bgcolor="#f2f2f2">
									<td align="left" class="lf">Email</td>
									<td style="font-weight:bold">:</td>
									<td align="left">--------</td>
								</tr>
								<tr>
									<td align="left" class="lf">Mobile Number</td>
									<td style="font-weight:bold">:</td>
									<td align="left">--------</td>
								</tr>`;
	</script>
</body>

</html>