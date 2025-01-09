<?php
    // Check if success message is set
    if (isset($_SESSION['success'])) {
        echo '<div id="successMessage" class="alert alert-success" style="background-color: #cce5ff; border-color: #b8daff; color: #004085;">' . $_SESSION['success'] . '</div>';
        unset($_SESSION['success']); // Clear the session variable
    }
?>

<script>
    // Automatically hide success message after 3 seconds
    $(document).ready(function() {
        setTimeout(function() {
            $("#successMessage").fadeOut("slow");
        }, 3000); // 3000 milliseconds = 3 seconds
    });
</script>