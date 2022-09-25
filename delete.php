<?php 
    require 'components/header.php';

    if($id = trim($_GET["id"])) {
        $sql = "DELETE FROM feedback WHERE id=?";
        $statement = $connect->prepare($sql);
        try {
            $statement->execute([$id]);
            header("Location: feedback_list.php");
            echo "<script>alert('Feedback deleteed successfully!!!');</script>";
        } catch(PODException $e) {
            echo "Cannot delete feedback into database. " .$e->getMessage();
        }
    }

?>
                 