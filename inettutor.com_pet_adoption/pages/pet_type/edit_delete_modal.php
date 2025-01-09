<!-- Edit Modal -->
<div class="modal fade" id="edit_<?php echo $row['pet_type_id']; ?>" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title">Edit Record</h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="container-fluid">
                    <form method="POST" action="function/editPetType.php">
                        <input type="hidden" name="id" value="<?php echo $row['pet_type_id']; ?>">
                        <div class="form-group">
                            <label for="pet_type_name">Pet Type Name</label>
                            <input class="form-control pet_type_name_input" type="text" name="pet_type_name" value="<?php echo $row['pet_type_name']; ?>" required>
                            <div class="response"></div> <!-- Response container -->
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


<!-- Delete -->
<div class="modal fade" id="delete_<?php echo $row['pet_type_id']; ?>" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
			<div class="modal-header">
              <h4 class="modal-title">Delete Record</h4>
              <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
              </button>
            </div>
            <div class="modal-body">	
            	<p class="text-center">Are you sure you want to Delete</p>
				<h2 class="text-center"><?php echo $row['pet_type_name']; ?></h2>
			</div>
            <div class="modal-footer justify-content-between">
                <button type="button" class="btn btn-default" data-dismiss="modal"><span class="glyphicon glyphicon-remove"></span> Cancel</button>
                <a href="function/deletePetType.php?id=<?php echo $row['pet_type_id']; ?>" class="btn btn-danger"><span class="glyphicon glyphicon-trash"></span> Yes</a>
            </div>

        </div>
    </div>
</div>

<!-- Include jQuery library -->
<!--<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>-->
<script src="../../plugins/jquery/jquery.min.js"></script>

<script>
    $(document).ready(function () {
        $(".pet_type_name_input").keyup(function () {
            var pet_type_name = $(this).val().trim();
            var responseContainer = $(this).closest('.form-group').find('.response');
            var submitButton = $(this).closest('.modal-content').find('button[type="submit"]');
            
            if (pet_type_name != '') {
                $.ajax({
                    url: 'function/checkDuplicate.php', // PHP script to check for duplicate
                    type: 'post',
                    data: { pet_type_name: pet_type_name },
                    success: function (response) {
                        responseContainer.html(response); // Display response message
                        if (!response.includes('Pet Type already exists. Please enter a different pet_type_name.')) {
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
