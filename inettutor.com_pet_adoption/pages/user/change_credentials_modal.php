<!-- Change Username and Password Modal -->
<div class="modal fade" id="change_credentials_<?php echo $row['user_id']; ?>" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title">Change Username and Password for: <br>
                    <?php echo $row['complete_name']; ?></h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form method="post" action="function/updateCredentials.php">
                    <input type="hidden" name="user_id" value="<?php echo $row['user_id']; ?>">
                    <div class="form-group">
                        <label for="new_username">New Username</label>
                        <input type="text" class="form-control" id="new_username" name="new_username" value="<?php echo $row['username']; ?>" required>
                    </div>
                    <div class="form-group">
                        <label for="new_password">New Password</label>
                        <input type="password" class="form-control" id="new_password" name="new_password" required>
                    </div>
                    <div class="form-group">
                        <label for="confirm_password">Confirm Password</label>
                        <input type="password" class="form-control" id="confirm_password" name="confirm_password" required>
                    </div>
                    <button type="submit" name="change_credentials" class="btn btn-info btn-block">Update Credentials</button>
                </form>
            </div>
        </div>
    </div>
</div>