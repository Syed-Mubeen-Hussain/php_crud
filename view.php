<?php
include('connection.php');
if(isset($_GET['page'])){
$page = mysqli_real_escape_string($con, $_GET['page']);
if ($page > 0) {
    $start = ($page - 1) * 3;
    $res = mysqli_query($con, "select * from Student limit $start, 3");
}
}else{
    $res = mysqli_query($con, "select * from Student limit 3");
}
$total_students = mysqli_fetch_assoc(mysqli_query($con, "select count(*) as count from Student"));
$total_students = $total_students['count'] / 4;
$pageination_count = ceil($total_students);


?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="viewport" content="width=device-width, initial-scale=2.0">
    <meta name="viewport" content="width=device-width, initial-scale=3.0">
    <meta name="viewport" content="width=device-width, initial-scale=Next.0">
    <title>Students Data</title>
    <link rel="stylesheet" href="bootstrap.min.css">
    <style>
        .pagination {
            color: white;
            padding: 5px 15px;
            text-align: center;
            margin: 10px 5px;
        }

        .pagination:hover {
            color: whitesmoke;
            text-decoration: none;
        }
    </style>
</head>

<body>
    <div style="padding: 10px;">
        <a href="insert.php" class="btn-primary" style="padding: 5px;">Add New Student</a>
    </div>

    <table class="text-center table table-striped table-hover">
        <thead>
            <tr>
                <th class="text-center">Id</th>
                <th class="text-center">Image</th>
                <th class="text-center">Name</th>
                <th class="text-center">Age</th>
                <th class="text-center">Gender</th>
                <th></th>
            </tr>
        </thead>
        <tbody>
            <?php if (mysqli_num_rows($res) > 0) {
                while ($row = mysqli_fetch_assoc($res)) { ?>
                    <tr>
                        <td><?php echo $row['id'] ?></td>
                        <td>
                            <img src="images/<?php echo $row['image'] ?>" width="20" height="20" alt="">
                        </td>
                        <td><?php echo $row['name'] ?></td>
                        <td><?php echo $row['age'] ?></td>
                        <td><?php echo $row['gender'] ?></td>
                        <td>
                            <a href="edit.php?id=<?php echo $row['id'] ?>" class="btn-primary" style="padding: 5px;">Edit</a>
                            <a href="delete.php?id=<?php echo $row['id'] ?>" class="btn-danger" style="padding: 5px;">Delete</a>
                        </td>
                    </tr>
            <?php }
            } else {
                echo '<tr>
                <td colspan="6">No Data Found</td>
                </tr>';
            } ?>
        </tbody>
    </table>
    <div style="display: flex;justify-content: center;">
        <?php for ($i = 1; $i <= $pageination_count; $i++) { ?>
            <a href="?page=<?php echo $i ?>" style="background-color: <?php echo $page == $i ? "red;" : "purple;"?>" class="pagination"><?php echo $i ?></a>
        <?php } ?>
    </div>
</body>

</html>