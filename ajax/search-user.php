<?php
include '../includes/db_connect.php';

if(isset($_POST['name'])){
	$sql = "SELECT * FROM users WHERE username LIKE :search OR name LIKE :search OR email LIKE :search  OR phone LIKE :search ";
	$query = $conn->prepare($sql);
	$query->execute([
		':search' => $_POST['name'].'%'
	]);
}else{
	$sql = "SELECT * FROM users";
	$query = $conn->prepare($sql);
	$query->execute();
}

if($query->rowCount() > 0){
	while ($row=$query->fetch(PDO::FETCH_ASSOC)) {
		echo "	<tr>
				  <th scope='row' class='px-4'>".$row['id']."</th>
		          <td>".$row['username']."</td>
		          <td>".$row['name']."</td>
		          <td>".$row['email']."</td>
		          <td>".$row['phone']."</td>
		        </tr>";
	}
}
else{
	echo "<tr><td>0 result found</td></tr>";
}