<?php
session_start();
?>

<script>
    if (confirm("Are you sure you want to logout?")) {
        // Redirect to another PHP file that handles session destruction
        window.location.href = "logout_confirm.php"; 
    } else {
        // Redirect back to the previous page
        window.location.href = "create.php";
    }
</script>
