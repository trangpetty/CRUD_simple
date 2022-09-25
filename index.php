 <?php 
    require 'components/header.php';
    $name = $email = $body = '';
    $name_err = $email_err = $body_err = '';
    if(isset($_POST['submit'])) {
        if(empty($_POST['name'])) {
            $name_err = 'Name is required!!!';
        } else {
            $name = htmlspecialchars($_POST['name']);
        }

        if(empty($_POST['email'])) {
            $email_err = 'Email is required!!!';
        } else {
            $email = filter_input(INPUT_POST, 'email',
                        FILTER_SANITIZE_EMAIL);
        }   
        if(empty($_POST['body'])) {
            $body_err = 'Comments is required!!!';
        } else {
            $body = htmlspecialchars($_POST['body']);
        }
        $validate_success = empty($name_err) && empty($email_err) && empty($body_err);
        if($validate_success) {
            $sql = "INSERT INTO feedback(name, email, body) VALUES(?, ?, ?)";
            try {
                $statement = $connect->prepare($sql);
                $statement->bindParam(1, $name);
                $statement->bindParam(2, $email);
                $statement->bindParam(3, $body);
                $statement->execute();
                echo "<script>alert('Feedback inserted successfully!!!');</script>";
            } catch(PODException $e) {
                echo "Cannot insert feedback into database. " .$e->getMessage();
            }
        }
    } 
 ?>
 
 <div class="container py-3 px-5">
        <h1>Enter your feedback here</h1>
        <form action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']); ?>" method="post">
            <div class="mb-3">
                <input type="text" class="form-control <?php echo $name_err ? 'is-invalid' :  ''; ?>" name="name" placeholder="What is your name?">
                <p class='text-danger'><?php echo $name_err; ?></p>
            </div>
            <div class="mb-3">
                <input type="email" class="form-control <?php echo $email_err ? 'is-invalid' :  '';?>" name="email" placeholder="Enter your email">
                <p class='text-danger'><?php echo $email_err; ?></p>
            </div>
            <div class="mb-3">
                <textarea cols="30" rows="10" class="form-control <?php echo $body_err ? 'is-invalid' :  '';?>" name="body" placeholder="Enter your comment"></textarea>
                <p class='text-danger'><?php echo $body_err; ?></p>
            </div>
            <div class="mb-3">
                <input type="submit" value="Send" class="btn btn-success" name="submit">
                <a href="feedback_list.php" class="btn btn-success">List</a>
            </div>
            
        </form>
    </div>

<?php include 'components/footer.php' ?>

<?php 
    // $connect = mysqli_connect('localhost', 'mysqli', 'Nghia26072001', 'mysqli');
    // Create table
    // $sql = "CREATE TABLE `mysqli`.`user` (`id` INT UNSIGNED NOT NULL AUTO_INCREMENT , `name` VARCHAR(20) NULL DEFAULT NULL ,
    // `email` VARCHAR(20) NULL DEFAULT NULL , `feedback` VARCHAR(200) NULL DEFAULT NULL , PRIMARY KEY (`id`)) ENGINE = InnoDB;";
    // mysqli_query($connect, $sql);

    // Add data
    // $sql = "INSERT INTO `user`(`name`, `email`, `feedback`) VALUES ('Trang le', 'trang200164@nuce.edu.vn', 'Trang is beautiful')";
    // mysqli_query($connect, $sql);

?>