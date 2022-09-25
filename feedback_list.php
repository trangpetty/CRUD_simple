<?php 
    require 'components/header.php';
    
    echo "<br><a class='ms-5 mt-3 btn btn-success'
                href='index.php'>Add new</a>";
    $sql = "SELECT id, name, email, body from feedback;";
    if($connect != null) {
        try {
            $statement = $connect->prepare($sql);
            $statement->execute();
            $result = $statement->setFetchMode(PDO::FETCH_ASSOC);
            $feedbacks = $statement->fetchAll();
            echo "<div class='container mt-3'>";
            echo "<h2 class='h2'>List Feedback</h2>";
            echo "<table class='table'>";
            echo "<thead class='table-success'>
                        <tr>
                        <th>Id</th>
                        <th>Name</th>
                        <th>Email</th>
                        <th>Comments</th>
                        <th>Action</th>
                        </tr>
                    </thead>";
            foreach($feedbacks as $feedback) {
                $name = $feedback['name'] ?? '';
                $email = $feedback['email'] ?? '';
                $body = $feedback['body'] ?? '';
                $id = $feedback['id'] ?? '';
                echo "<tr>";
                echo "<td>$id</td>";
                echo "<td>$name</td>";
                echo "<td>$email</td>";
                echo "<td>$body</td>";
                echo "<td>";
                echo "<button onclick='Delete()' class='btn btn-danger p-2'>Delete</button>";
                echo "<a href='edit.php?id=". $id ."' class='btn btn-info p-2 ms-2'>Edit</a>";
                echo "</td>";
                echo "</tr>";
            }
            if(!isset($id)) {
                $id = 0;
            }
            echo "</table>";
            echo "</div>";
            echo "<script>
                function Delete() {
                    let text = 'Are you sure you want to delete this record?';
                    if (confirm(text) == true) {
                        location.replace('delete.php?id=". $id ."');
                    } else {
                        location.replace('feedback_list.php');
                    }
                }
                </script>";
        } catch (PDOException $e) {
            echo "Cannot query data. Error: " . $e->getMessage();
        }
    }
 
    include 'components/footer.php'; 
?>