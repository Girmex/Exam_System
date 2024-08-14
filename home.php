<?php
    include 'db_connect.php';
    include 'auth.php';
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <?php include('header.php') ?>
    <title>Home |  Online Exam System</title>
</head>
<body style="display:flex">
	<div>
	<?php include('nav_bar.php') ?>
	</div>
    <div class="container-fluid admin " style="display:flex; align-items:center">
        <div class="card col-md-5 offset-2">
            <div class="card-body">
            <table class="table table-striped">
    <thead>
        <th>Exam</th>
        <th>Items</th>
        <th>Status</th>
    </thead>
    <tbody>
        <?php
        if ($_SESSION['login_user_type'] == 3) {
            $qry = "SELECT e.title, h.total_score, h.status
                    FROM exam_list e 
                    LEFT JOIN history h ON e.id = h.exam_id 
                    WHERE h.user_id = '".$_SESSION['login_id']."'";
        } else {
            $qry = "SELECT DISTINCT e.title, h.total_score, h.status
                    FROM exam_list e
                    LEFT JOIN history h ON e.id = h.exam_id 
                    WHERE h.status = 'taken' 
                    ORDER BY e.title ASC";
        }

        $result = $conn->query($qry);

        while ($row = $result->fetch_assoc()) {
            ?>
            <tr>
                <td><?php echo $row['title'] ?></td>
                <td class='text-center'><?php echo $row["total_score"] ?></td>
                <td class='text-center'><?php echo $row['status'] ?></td>
            </tr>
            <?php
        }
        ?>
    </tbody>  
</table>


            </div>
        </div>
       </div>
</body>
</html>