<!-- Change Username and Password Modal -->
<div class="modal fade" id="change_credentials_<?php echo $row['pet_owner_id']; ?>" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title">Change Username and Password for <?php echo $row['pet_owner_username']; ?></h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form method="post" action="function/updateCredentials.php">
                    <input type="hidden" name="pet_owner_id" value="<?php echo $row['pet_owner_id']; ?>">
                    <div class="form-group">
                        <label for="new_username">New Username</label>
                        <input type="text" class="form-control" id="new_username" name="new_username" value="<?php echo $row['pet_owner_username']; ?>" required>
                    </div>
                    <div class="form-group">
                        <label for="new_password">New Password</label>
                        <input type="password" class="form-control" id="new_password" name="new_password" required>
                    </div>
                    <div class="form-group">
                        <label for="confirm_password">Confirm Password</label>
                        <input type="password" class="form-control" id="confirm_password" name="confirm_password" required>
                    </div>
            </div>
            <div class="modal-footer justify-content-between">
                    <button type="button" class="btn btn-default btn-flat" data-dismiss="modal">Close</button>
                    <button type="submit" name="change_credentials" class="btn btn-info"><span class="glyphicon glyphicon-check"></span> Update Credentials</button>
                </div>
            </form>
        </div>
    </div>
</div>
