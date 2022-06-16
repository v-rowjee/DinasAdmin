<?php
include '../config/db_connect.php';

if(isset($_POST['search'])){
	$sql = "SELECT * FROM users 
			WHERE (is_admin = 'no') 
			AND (username LIKE :search OR name LIKE :search OR email LIKE :search  OR phone LIKE :search)
			ORDER BY username";
	$query = $conn->prepare($sql);
	$query->execute([
		':search' => '%'.$_POST['search'].'%'
	]);

	if($query->rowCount() > 0){
		while ($row=$query->fetch(PDO::FETCH_ASSOC)) {
			echo "	<tr>
					<th scope='row' class='ps-4'>".$row['id']."</th>
					<td>".$row['username']."</td>
					<td>".$row['name']."</td>
					<td>".getEmail($row)."</td>
					<td>".$row['phone']."</td>
					<td class='text-end pe-3'>
						<a href='users.php?edit=".$row['id']."'><i class='bx bxs-edit px-1' style='font-size:larger'></i></a>
						<a href='users.php?dlt=".$row['id']."'><i class='bx bxs-trash px-1' style='font-size:larger; color: var(--bs-danger)'></i></a>
					</td>
					</tr>";
		}
	}
	else{
		echo '<p class="msg">No Result Found</p>';
	}
}

function getEmail($row){
	$result = $row['email'];

	if($row['google_id'] != null) $result .= ' '.'[<i class="bx bxl-google"></i>]';

	return $result;
}

