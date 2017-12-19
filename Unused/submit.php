<!DOCTYPE html>

<html>
	<head>
		<title>Virtual Humanities Lab</title>
		<link href="index.css" rel="stylesheet">
		<?php]
			$name = $email = $phone = $text = "";
			date_default_timezone_set("America/New_York");

			$user_name = "root";
			$password = "";
			$database = "vhl";
			$server = "127.0.0.1";

			$conn = new mysqli($server, $user_name, $password, $database);
			if ($conn->connect_error) {
				die("Connection failed: " . $conn->connect_error);
			}
			else {
				if(isset($_POST["contact"])) {
					$name = $_POST["name"];
					$email = $_POST["email"];
					$phone = $_POST["phone_number"];
					$text = $_POST["question"];
					$datetime = date("l, M j, Y, g:i A, T");
					if($name != "" && $email != "" && $text != "") {
						$SQL = $conn->prepare("INSERT INTO `blog_posts` (`Title`, `Date`, `Time`, `Text`) VALUES (?, ?, ?, ?)");
						$SQL->bind_param("ssss", $blogTitle, $date, $time, $blogPost);
						$SQL->execute();
						$result = $SQL->get_result();
						$warningText = "";
					}
					else {
						$warningText = "Please fill in all required fields";
					}
				}
				if(isset($_POST["removePost"])) {
						$conn2 = new mysqli($server, $user_name, $password, $database);
						$connectSQL = $conn2->prepare("SELECT * FROM blog_posts");
						$connectSQL->execute();
						$result = $connectSQL->get_result();

						if ($result->num_rows > 0) {
							while($row = $result->fetch_assoc()) {
								$id = "remove".$row['Post'];
								if(isset($_POST["$id"])) {
									$id = $_POST[$id];
									$deleteSQL = $conn2->prepare("DELETE FROM `blog_posts` WHERE Post = ?");
									$deleteSQL->bind_param("i", $id);
									$deleteSQL->execute();
								}
							}
						}
						else {
							echo "No blog posts found";
						}
				$conn->close();
					}
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
									<div class='blog_post_cont'><td style='width: 15%'>".$row["Title"]."</td></div>
									<div class='blog_post_cont'><td>".$row["Date"]."</td></div>
									<div class='blog_post_cont'><td>".$row["Time"]."</td></div>
									<div class='blog_post_cont'><td style='width: 50%'>".$row["Text"]."</td></div>
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