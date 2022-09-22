<!doctype html>
<html lang="en">

<head>
	<title>Admin Login - Pearland</title>
	<!--== META TAGS ==-->
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">
	<meta name="theme-color" content="#76cef1" />
	<meta name="description" content="">
	<meta name="keyword" content="">
	<!--== FAV ICON(BROWSER TAB ICON) ==-->
	<link rel="shortcut icon" href="../images/fav.ico" type="image/x-icon">
	<!--== GOOGLE FONTS ==-->
	<link href="https://fonts.googleapis.com/css?family=Oswald:700|Source+Sans+Pro:300,400,600,700&display=swap" rel="stylesheet">
	<!--== CSS FILES ==-->
  	<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/jqueryui/1.12.1/jquery-ui.min.css">

  	<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">

  	<link rel="stylesheet" href="<?= base_url() ?>assets/admin/css/admin-style.css">
  	<link rel="stylesheet" href="<?= base_url() ?>assets/css/fonts.css">
	<!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
	<!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
	<!--[if lt IE 9]>
	<script src="../js/html5shiv.js"></script>
	<script src="../js/respond.min.js"></script>
	<![endif]-->
</head>

<body>
	<!-- START -->
	<!--PRICING DETAILS-->
	<section class="login-reg ad-login-reg">
		<div class="container">
			<div class="row">
				<div class="login-main">
					<div class="log-bor">&nbsp;</div> <span class="udb-inst">Admin Area</span>
					<div class="log log-1">
						<div class="login">
							<h4>Admin Login</h4>
							<form name="directory_login" method="post" action="">
								<div class="form-group">
									<!--                                  <input type="text" name="admin_email" id="admin_email"  class="form-control" placeholder="Enter email*" pattern="^[\w]{1,}[\w.+-]{0,}@[\w-]{2,}([.][a-zA-Z]{2,}|[.][\w-]{2,}[.][a-zA-Z]{2,})$" title="Invalid email address" required>-->
									<input type="text" name="admin_email" id="admin_email" class="form-control" placeholder="Enter email*" title="Invalid email address" required>
								</div>
								<div class="form-group">
									<input type="password" name="admin_password" id="admin_password" class="form-control" placeholder="Enter password*" required>
								</div>
								<button type="submit" value="submit" name="admin_submit" class="btn btn-primary">Sign in</button>
							</form>
						</div>
					</div>
					<div class="log log-3">
						<div class="login">
							<h4>Forgot password</h4>
							<form>
								<div class="form-group">
									<input type="email" class="form-control" placeholder="Enter email*" pattern="^[\w]{1,}[\w.+-]{0,}@[\w-]{2,}([.][a-zA-Z]{2,}|[.][\w-]{2,}[.][a-zA-Z]{2,})$" title="Invalid email address" required>
								</div>
								<button type="submit" class="btn btn-primary">Sign in</button>
							</form>
						</div>
					</div>
					<div class="log-bot">
						<ul>
							<li> <span class="ll-1">Login?</span>
							</li>
							<li> <span class="ll-3">Forgot password?</span>
							</li>
						</ul>
					</div>
				</div>
			</div>
		</div>
	</section>
	<!--END PRICING DETAILS-->
	<!-- Optional JavaScript -->
	<!-- jQuery first, then Popper.js, then Bootstrap JS -->
	<script src="https://code.jquery.com/jquery-3.4.1.min.js" integrity="sha256-CSXorXvZcTkaix6Yvo6HppcZGetbYMGWSFlBw8HfCJo=" crossorigin="anonymous"></script>

	<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js" integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous"></script>

	<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous"></script>

	<script src="https://code.jquery.com/ui/1.12.1/jquery-ui.min.js" integrity="sha256-VazP97ZCwtekAsvgPBSUwPFKdrwD3unUfSGVYrahUqU=" crossorigin="anonymous"></script>
	<script src="<?= base_url() ?>/assets/js/custom.js"></script>
</body>

</html>