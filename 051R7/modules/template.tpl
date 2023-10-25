<!DOCTYPE html>
<html>
	<head>
		<meta charset="utf-8" />
		<title>{title}</title>
		<!--[if lt IE 9]><script src="http://html5shiv.googlecode.com/svn/trunk/html5.js"></script><![endif]-->
		<link rel="stylesheet" type="text/css" href="./modules/style.css" />
		<link rel="stylesheet" type="text/css" href="./modules/form.css" />
	</head>
	<body>
		<div class="main">
			<div class="title"><a href="./">{title}</a> <small>/ <a href="./">Home</a></small></div>
			<div class="login">
				<div class="inner">
					{login}
				</div>
			</div>
			<div class="container">
				<div class="left">
					<div class="inner">
						{left}
					</div>
				</div>
				<div class="content">
					<div class="inner">
						{component}
					</div>
				</div>
				<div class="right">
					<div class="inner">
						{right}
					</div>
				</div>
			</div>
		</div>
		<footer>
			<section>
				{footer}
			</section>
		</footer>
	</body>
</html>