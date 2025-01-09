<!-- Edit Modal -->
<div class="modal fade" id="edit_<?php echo $row['pet_owner_id']; ?>" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title">Edit Pet Owner</h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="container-fluid">
                    <form method="POST" action="function/editPetOwner.php" enctype="multipart/form-data">
                        <input type="hidden" name="id" value="<?php echo $row['pet_owner_id']; ?>">
                        <div class="form-group">
                            <label for="pet_owner_name">Pet Owner Name</label>
                            <input class="form-control" type="text" name="pet_owner_name" value="<?php echo $row['pet_owner_name']; ?>" required>
                            <div id="response"></div>
                        </div>
                        <div class="form-group">
                            <label for="pet_owner_contact">Contact Number</label>
                            <input class="form-control" type="text" name="pet_owner_contact" value="<?php echo $row['pet_owner_contact']; ?>" required>
                        </div>
                        <div class="form-group">
                            <label for="pet_owner_email">Email Address</label>
                            <input class="form-control" type="email" name="pet_owner_email" value="<?php echo $row['pet_owner_email']; ?>" required>
                        </div>
                        <div class="form-group">
                            <label for="pet_owner_address">Address</label>
                            <input class="form-control" type="text" name="pet_owner_address" value="<?php echo $row['pet_owner_address']; ?>" required>
                        </div>
                </div>
            </div>
            <div class="modal-footer justify-content-between">
                <button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>
                <button type="submit" name="edit" class="btn btn-success">Update</button>
            </div>
            </form>
        </div>
    </div>
</div>

<!-- Delete Modal -->
<div class="modal fade" id="delete_<?php echo $row['pet_owner_id']; ?>" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title">Delete Pet Owner</h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">    
                <p class="text-center">Are you sure you want to delete the pet owner?</p>
                <h2 class="text-center"><?php echo $row['pet_owner_name']; ?></h2>
            </div>
            <div class="modal-footer justify-content-between">
                <button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>
                <a href="function/deletePetOwner.php?id=<?php echo $row['pet_owner_id']; ?>" class="btn btn-danger">Yes, Delete</a>
            </div>
        </div>
    </div>
</div>

<!-- Include jQuery library -->
<script src="../../plugins/jquery/jquery.min.js"></script>

<script>
    $(document).ready(function () {
        $(".form-control").keyup(function () {
            var petOwnerName = $(this).val().trim();
            var responseContainer = $(this).closest('.form-group').find('#response'); // Adjusted to target the correct response container
            var submitButton = $(this).closest('.modal-content').find('button[type="submit"]');
            
            if (petOwnerName != '') {
                $.ajax({
                    url: 'function/checkDuplicate.php', // PHP script to check for duplicate
                    type: 'post',
                    data: { petOwnerName: petOwnerName }, // Changed the parameter name to match the PHP script
                    success: function (response) {
                        responseContainer.html(response); // Display response message
                        if (!response.includes('Owner name already exists. Please enter a different owner name.')) {
                            submitButton.prop('disabled', false); // Enable submit button
                        } else {
                            submitButton.prop('disabled', true); // Disable submit button
                        }
                    },
                    error: function (xhr, status, error) {
                        console.log('Error:', error); // Log error message
                    }
                });
            } else {
                responseContainer.html(""); // Clear response container
                submitButton.prop('disabled', true); // Disable submit button
            }
        });
    });
</script>
