<!DOCTYPE html>
<html lang="en">

  <head>

    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="italian_studies_vhl" content="">
    <meta name="Stanley_Yip" content="">

    <title>Virtual Humanities Lab</title>

    <!-- Core CSS -->
    <link href="index.css" rel="stylesheet">
	
	<?php
		$loginText = "";
		$userinput = "";
		if(isset($_POST["login"])) {
			$userinput = $_POST["username"];
			$passinput = $_POST["password"];
			$username = md5(strip_tags(htmlspecialchars($userinput)));	
			$password = md5(strip_tags(htmlspecialchars($passinput)));
			if ($username == md5("mriva")) {
				if ($password == md5("italStudiesVHL!")) {
					$loginText = "Successful login";
					setcookie("login", true);
					header("Location: blog_admin.php");
				}
				else {
					$loginText = "Username or password incorrect";
				}
			}
			else {
				$loginText = "Username or password incorrect";
			}
		}
	?>
	
  </head>

  <body>
	<div class="form">
		<form name="login" method="POST" action="blogin.php">
			<table class="formtable">
				<tr>
					<td>
						<label for="username">
							Username:
						</label>
					</td>
					<td>
						<input type="text" name="username" value="<?php print $userinput; ?>" />
					</td>
				</tr>
				<tr>
					<td>
						<label for="password">
							Password:
						</label>
					</td>
					<td>
						<input type="password" name="password" />
					</td>
				</tr>
				<tr>
					<td colspan="2" class="submit">
						<input type="submit" name="login" value="Login" />
					</td>
				</tr>
				<tr>
					<td colspan="2">
						<br />
						<?php
							print $loginText;
						?>
					</td>
				</tr>
			</table>
		</form>
	</div>
	
  </body>

</html>
