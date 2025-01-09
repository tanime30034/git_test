<!-- Edit -->
<div class="modal fade" id="edit_<?php echo $row['user_id']; ?>" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title">Edit Member</h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="container-fluid">
                    <form method="POST" action="function/editUser.php">
                        <input type="hidden" class="form-control" name="id" value="<?php echo $row['user_id']; ?>">
                        <div class="form-group">
                            <label for="complete_name">Complete Name</label>
                            <input class="form-control" type="text" id="complete_name" name="complete_name" value="<?php echo $row['complete_name']; ?>" required>
                        </div>
                        <div class="form-group">
                            <label for="designation">Designation</label>
                            <textarea class="form-control" id="designation" name="designation" required><?php echo htmlspecialchars($row['designation']); ?></textarea>
                        </div>
                        <div class="form-group">
                            <label for="user_type">User Type</label>
                            <select class="form-control" id="user_type" name="user_type" required>
                                <option value="admin" <?php echo ($row['user_type'] == 'admin') ? 'selected' : ''; ?>>Admin</option>
                                <option value="user" <?php echo ($row['user_type'] == 'user') ? 'selected' : ''; ?>>User</option>
                            </select>
                        </div>
                        
                </div> 
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal"><span class="glyphicon glyphicon-remove"></span> Cancel</button>
                <button type="submit" name="edit" class="btn btn-success"><span class="glyphicon glyphicon-check"></span> Update</button>
                    </form>
            </div>
        </div>
    </div>
</div>

<!-- Delete -->
<div class="modal fade" id="delete_<?php echo $row['user_id']; ?>" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title">Delete Record</h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">    
                <p class="text-center">Are you sure you want to delete member?</p>
                <h2 class="text-center"><?php echo $row['complete_name']; ?></h2>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal"><span class="glyphicon glyphicon-remove"></span> Cancel</button>
                <a href="function/deleteUser.php?id=<?php echo $row['user_id']; ?>" class="btn btn-danger"><span class="glyphicon glyphicon-trash"></span> Yes</a>
            </div>
        </div>
    </div>
</div>
