<?php 
    require 'components/header.php';

    $name = $email = $body = "";
    $name_err = $email_err = $body_err = "";
    $id = trim($_GET["id"]);
    if(isset($_POST['edit'])) {
        
        $input_name = trim($_POST["name"]);
        if(empty($input_name)) {
            $name_err = "Please enter your name!!!";
        }   else {
            $name = $input_name;
        }
        $input_email = trim($_POST["email"]);
        if(empty($input_email)) {
            $email_err = "Please enter your email!!!";
        }   else {
            $email = $input_email;
        }
        $input_body = trim($_POST["body"]);
        if(empty($input_body)) {
            $body_err = "Please enter your comment!!!";
        }   else {
            $body = $input_body;
        }
        $validate_success = empty($name_err) && empty($email_err) && empty($body_err);
        if($validate_success) {
            $sql = "UPDATE feedback SET name=?, email=?, body=? WHERE id=?";
            if($statement = $connect->prepare($sql)) {
            try {                    
                    if($statement->execute([$name, $email, $body, $id])) {
                        header("Location: feedback_list.php");
                        exit();
                    }   else {
                        echo "Error";
                    }
                    echo "<script>alert('Feedback edited successfully!!!');</script>";
                }   catch(PODException $e) {
                echo "<script>alert('Cannot edit feedback into database: .$e->getMessage()')</script>";
                }
            }
            
        }
        
    }   else {
        if(isset($_GET["id"]) && !empty(trim($_GET["id"]))) {
            $id = trim($_GET["id"]);

            $sql = "SELECT * FROM feedback WHERE id =".$id;
            try {
                $statement = $connect->prepare($sql);
                //$statement->execute([$id]);
                $result = $connect -> query($sql) -> fetchAll();
                foreach($result as $fields) {
                    $name = $fields["name"];
                    $email = $fields["email"];
                    $body = $fields["body"];
                }
                
            } catch(PODException $e) {
                echo "Cannot get feedback into database. " .$e->getMessage();
            }
        }
    }
    
?>
<div class="container my-3">
        <h1>Edit your feedback here</h1>
        <form action="<?php echo htmlspecialchars(basename($_SERVER['REQUEST_URI'])); ?>" method="post">
            <div class="mb-3">
                <input type="text" class="form-control name <?php echo empty($name_err) ? 'has-error' :  ''; ?>" name="name" value="<?php echo $name; ?>">
                <p class='text-danger'><?php echo $name_err; ?></p>
            </div>
            <div class="mb-3">
                <input type="email" class="form-control email <?php echo empty($email_err) ? 'has-error' :  '';?>" name="email" value="<?php echo $email; ?>">
                <p class='text-danger'><?php echo $email_err; ?></p>
            </div>
            <div class="mb-3">
                <textarea cols="30" rows="10" class="form-control <?php echo empty($body_err) ? 'has-error' :  '';?>" name="body"><?php echo $body; ?></textarea>
                <p class='text-danger'><?php echo $body_err; ?></p>
            </div>
            <div class="mb-3">
                <input type="submit" value="Edit" class="btn btn-success" name="edit">
                <a href="feedback_list.php" class="btn btn-danger">Cancel</a>
            </div>
            
        </form>
</div>
<?php
    include 'components/footer.php'; 
?>