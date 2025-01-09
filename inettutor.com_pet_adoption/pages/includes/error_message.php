<?php if(isset($_SESSION['error']) && !empty($_SESSION['error'])): ?>
    <div id="error-message" class="alert alert-danger" role="alert">
        <?php echo $_SESSION['error']; ?>
    </div>
    <?php unset($_SESSION['error']); ?>
<?php endif; ?>

<script>
    // Automatically hide success message after 3 seconds
    $(document).ready(function() {
        setTimeout(function() {
            $("#error-message").fadeOut("slow");
        }, 3000); // 3000 milliseconds = 3 seconds
    });
</script>