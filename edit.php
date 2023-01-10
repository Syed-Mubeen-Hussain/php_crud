<?php
include('connection.php');
$id = mysqli_real_escape_string($con,$_GET['id']);
$Student_data = mysqli_fetch_assoc(mysqli_query($con, "select * from Student where id = '$id'"));
if(isset($_POST['submit'])){

    $id = mysqli_real_escape_string($con,$_POST['id']);
    $name = mysqli_real_escape_string($con,$_POST['name']);
    $age = mysqli_real_escape_string($con,$_POST['age']);
    $gender = mysqli_real_escape_string($con,$_POST['gender']);
    if(is_uploaded_file($_FILES['image']['tmp_name'])){
        $image_name = $_FILES['image']['name'];
        $image_type = $_FILES['image']['type'];
        $temp_name = $_FILES['image']['tmp_name'];
        $image_size = $_FILES['image']['size'];
        if(strtolower($image_type) == "image/jpg" || strtolower($image_type) == "image/jpeg" || strtolower($image_type) == "image/png"){
            if($image_size <= 1000000){
                $folder = "images/" . $image_name;
                $res = mysqli_query($con,"update Student set name = '$name', age = '$age', gender = '$gender', image = '$image_name' where id = '$id'");
                if($res){
                    move_uploaded_file($temp_name,$folder);
                    echo "<script>
                    window.location.href = 'view.php';
                    </script>";
                }
            }else{
            echo "<script>alert('Image size must be in 1 MB !!')</script>";
            }
        }else{
            echo "<script>alert('Image format not supported !!')</script>";
        }
    }else{
        $res = mysqli_query($con,"update Student set name = '$name', age = '$age', gender = '$gender' where id = '$id'");
        if($res){
            echo "<script>
            window.location.href = 'view.php';
            </script>";
        }
    }
    
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add Student</title>
    <link rel="stylesheet" href="bootstrap.min.css">
    <style>
        body {
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            flex-direction: column;
        }
    </style>
</head>

<body>
    <h3 class="text-center" style="padding: 0px;margin: 0;margin-bottom: 15px;">Update Student Form</h3>
    <form method="post" action="" enctype="multipart/form-data" style="box-shadow: 0px 0px 10px lightblue;padding: 20px 10px;">
        <br>
        <input type="text" value="<?php echo $Student_data['name']?>" required name="name" class="form-control" placeholder="Enter Name">
        <br>
        <input type="number" value="<?php echo $Student_data['age']?>" required name="age" class="form-control" placeholder="Enter Age">
        <br>
        <select required name="gender" class="form-control">
            <?php 
            if($Student_data['gender'] == "Male"){
                echo '
                <option value="">Select Gender</option>
                <option value="Male" selected>Male</option>
                <option value="Female">Female</option>';
            }else if($Student_data['gender'] == "Female"){
                echo '
                <option value="">Select Gender</option>
                <option value="Male">Male</option>
                <option value="Female" selected>Female</option>';
            }else{
                echo '
                <option value="">Select Gender</option>
                <option value="Male">Male</option>
                <option value="Female">Female</option>';
            }
            ?>
        </select>
        <br>
        <?php
        if($Student_data['image'] != null){
            echo "<img src='images/$Student_data[image]' width='70' height='70' alt='image'>";
        }
        ?>
        <br/>
        <input type="file" name="image" class="form-control">
        <br>
        <input type="submit" value="Update" name="submit" class="btn btn-primary btn-block">
        <input type="hidden" name="id" value="<?php echo $Student_data['id']?>">
    </form>
</body>

</html>