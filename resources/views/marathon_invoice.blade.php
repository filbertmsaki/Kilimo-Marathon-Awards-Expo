<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- The above 3 meta tags *must* come first in the head; any other head content must come *after* these tags -->

	<title>Kilimo Marathon Registration Invoice</title>

	<!-- Bootstrap cdn 3.3.7 -->
	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">

	<!-- Custom font montseraat -->
	<link href="https://fonts.googleapis.com/css?family=Montserrat:400,500,600,700" rel="stylesheet">

	<!-- Custom style invoice1.css -->
	<link rel="stylesheet" type="text/css" href="{{ asset('assets/css/invoice2.css') }}">

	<!-- HTML5 shim and Respond.js for IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
      <script src="https://oss.maxcdn.com/html5shiv/3.7.3/html5shiv.min.js"></script>
      <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
    <![endif]-->
</head>
<body>

	<section class="back">
		<div class="container">
			<div class="row">
				<div class="col-xs-12">
					<div class="front-invoice-wrapper">
						<div class="front-invoice-top">
							<div class="row">
								<center>
									<div class="logo-wrapper">
										<img width="150" src="{{ asset('imgs/KILIMO-MARATHON--EXPO-LOGO.png') }}" class="img-responsive logo" />
									</div> 
								</center>
								<div class="col-12">
									<div class="front-invoice-top-left">
										<h4 class="service-name">Invoice #{{ $payment->transactionref }}</h4>
										<h6 class="date">{{ $payment->created_at->toDayDateTimeString()}}</h6>
									</div>
								</div>
								
							</div>
						</div>
						<div class="invoice-bottom">
							<div class="row">
								<div class="col-xs-12">
									<div class="task-table-wrapper">
										<table class="table">
											<thead>
												<tr  class="table-head">
													<th>DESCRIPTION</th>
												</tr>
											</thead>
											<tbody>
												<tr>
													<td class="desc">
														<h3>Marathon Registration</h3>
														<h5>Payment for registering to Kilimo Marathon 5Km running</h5>
													</td>
												</tr>
										
												
											</tbody>
											
										</table>
									
										{{-- <p>{{dd($payment_details)}}</p> --}}
										<p> {!! str_replace('   ', "<br>", $payment_details['instructions']) !!}</p>
										
									</div>
								</div>
								<div class="clearfix"></div>
								<div class="col-md-12">
									<div class="invoice-bottom-total">
										<div class="col-sm-8 no-padding">
											<div class="sub-total-box">
												<h6>SUBTOTAL</h6>
												<h5></h5>
											</div>
											<div class="add-box">
												<h3>+</h3>
											</div>
											<div class="tax-box">
												<h6>TAXES</h6>
												<h5></h5>
											</div>
										</div>
										<div class="col-sm-4 no-padding">
											<div class="total-box">
												<h6>TOTAL</h6>
												<h3>Tsh 3,5000</h3>
											</div>
										</div>
									</div>
								</div>

							</div>
						</div>
						<div class="front-invoice-top" style="padding-bottom: 0px;">
							<div class="row">
							
								<div class="col-12">
									<div class="front-invoice-top-left">
										<h2>Kilimo Marathon, Awards & EXPO</h2>
										<h3>Mkulima House, 2nd Floor - Mandela Rd,<br> Ubungo External,</h3>
										<h5> Dar es salaam, Tanzania</h5>
									</div>
								</div>
								<div class="clearfix"></div>
								<div class="col-xs-12">
									<hr class="divider">
								</div>
								<div class="col-sm-4 col-12">
									<h6 class="text-center table-head" ><a href="https://kilimomarathon.co.tz/"></a>kilimomarathon.co.tz</a></h6>
								</div>
								<div class="col-sm-4 col-12">
									<h6 class="text-center table-head">marketing@kilimomarathon.co.tz</h6>
								</div>
								<div class="col-sm-4 col-12">
									<h6 class="text-center table-head">+255 754 222 800</h6>
								</div>
								
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
	</section>
	

	<!-- jquery slim version 3.2.1 minified -->
	<script src="https://code.jquery.com/jquery-3.2.1.slim.min.js" integrity="sha256-k2WSCIexGzOj3Euiig+TlR8gA0EmPjuc79OEeY5L45g=" crossorigin="anonymous"></script>

	<!-- Latest compiled and minified JavaScript -->
	<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js" integrity="sha384-Tc5IQib027qvyjSMfHjOMaLkfuWVxZxUPnCJA7l2mCWNIpG9mGCD8wGNIcPD7Txa" crossorigin="anonymous"></script>

</body>
</html>