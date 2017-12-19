<!DOCTYPE html>

<html>
	<head>
		<title>Virtual Humanities Lab</title>
		<link href="index.css" rel="stylesheet">
		<?php
			if(!$_COOKIE["login"]) {
				header("Location: blogin.php");
			}
			else {
			}
		?>
	</head>
		
	<body style="padding-right: 0.5em;">
		<form name="new_blog" class="contact" method="POST" id="remove" action="blog_admin.php">
			<p class="middle_title"><span class="underline"><b>New Blog Post</b></span></p>
			<p>
				Create a new blog post:
			</p>
			<table>
				<tr>
					<td class="warning">
						<?php print $warningText; ?>
					</td>
				</tr>
				<tr>
					<td class="label">
						<label for="title">BLOG TITLE:<span style="color: red">*</span></label>
					</td>
				</tr>
				<tr>
					<td>
						<input type="text" name="title" value="<?php print $blogTitle; ?>"/>
					</td>
				</tr>
				<tr>
					<td class="label">
						<label for="content">ENTER BLOG CONTENT BELOW<span style="color: red">*</span></label>
					</td>
				</tr>
				<tr>
					<td>
						<textarea name="content" form="remove" rows="10" value="<?php print $blogPost; ?>"></textarea>
					</td>
				</tr>
				<tr>
					<td class="legend">
						<span style="color: red">*</span> INDICATES THAT THE FIELD IS REQUIRED
					</td>
				</tr>
				<tr>
					<td class="contactsubmit">
						<br />
						<input type="submit" name="blogsubmit" value="Submit" />
					</td>
				</tr>
			</table>
			<?php
				$user_name = "root";
				$password = "";
				$database = "vhl";
				$server = "127.0.0.1";

				$conn = new mysqli($server, $user_name, $password, $database);
				if (!$conn) {
					die("Connection failed: " . $conn->connect_error);
				}
				else {
					$SQL = "SELECT Post, Title, Date, Time, Text FROM blog_posts ORDER BY Post ASC";
					$result = mysqli_query($conn, $SQL);

					if (mysqli_num_rows($result) > 0) {
						echo "<table class='posts'>
								<form method='POST' name='removePost' action='blog_admin.php'>
								<tr>
									<td colspan='5'>
										<p>Blog Posts:</p>
									</td>
								</tr>
								<tr>
									<th></th>
									<th>Title</th>
									<th>Date</th>
									<th>Time</th>
									<th>Text</th>
								</tr>";
						while($row = $result->fetch_assoc()) {
							echo "<tr>
									<td class='removePost'>
										<input type='checkbox' name='remove".$row["Post"]."' value=".$row["Post"]." />
									</td>
									<td>".$row["Title"]."</td>
									<td>".$row["Date"]."</td>
									<td>".$row["Time"]."</td>
									<td>".$row["Text"]."</td>
								</tr>";
						}
						echo "<tr>
								<td colspan='5' class='removeButton'>
									<input type='submit' name='removePost' value='Remove Posts' />
								</td>
							</tr>
							</form>
							</table>";
					} else {
						echo "No blog posts found";
					}
					$conn->close();
				}
			?>
		</form>
	</body>
</html>