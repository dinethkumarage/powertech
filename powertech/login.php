<?php
   include("connection.php");

   if (isset($_POST['submit'])) {
       $username = $_POST['username'];
       $password = $_POST['password'];

       // Query to select user based on username and password
       $sql = "SELECT * FROM users WHERE username = '$username' AND password = '$password'";
       $result = mysqli_query($conn, $sql);
       $row = mysqli_fetch_array($result, MYSQLI_ASSOC);
       $count = mysqli_num_rows($result);

       if ($count == 1) {
           // Check user role and redirect accordingly
           if ($row['role'] == 'Admin') {
               header("Location: admindash.php");
           } elseif ($row['role'] == 'Sales Representative') {
               header("Location: repdash.php");
           } else {
               echo "<script>
                   alert('Role not recognized');
                   window.location.href = 'home.php';
                   </script>";
           }
       } else {
           echo "<script>
               alert('Login Failed: Invalid username or password');
               window.location.href = 'home.php';
               </script>";
       }
   }
?>
