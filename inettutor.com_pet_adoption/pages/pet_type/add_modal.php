<!-- Your modal HTML code -->
<div class="modal fade" id="addnew">
    <div class="modal-dialog modal-md">
        <form method="post" action="function/addPetType.php">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title">Add Record</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="form-group">
                        <label for="pet_type_name">Pet Type Name</label>
                        <input class="form-control" type="text" id="pet_type_name" name="pet_type_name" required>
                        <div id="response"></div> <!-- Response container -->
                    </div>
                </div>
                <div class="modal-footer justify-content-between">
                    <button type="button" class="btn btn-default btn-flat" data-dismiss="modal">Close</button>
                    <button type="submit" id="add_button" name="add" class="btn btn-primary"><span class="glyphicon glyphicon-check"></span> Save</button>
                </div>
            </div>
        </form>
        <!-- /.modal-content -->
    </div>
    <!-- /.modal-dialog -->
</div>
<!-- /.modal -->

<!-- Include jQuery library -->
<!--<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>-->
<script src="../../plugins/jquery/jquery.min.js"></script>
<!-- Integrate the provided JavaScript code -->
<script>
    // Define a function to check for duplicate pet_type_name
    function checkDuplicate() {
        var pet_type_name = $('#pet_type_name').val().trim();
        if (pet_type_name != '') {
            $.ajax({
                url: 'function/checkDuplicate.php', // PHP script to check for duplicate
                type: 'post',
                data: { pet_type_name: pet_type_name },
                success: function (response) {
                    console.log('Success:', response); // Log success message
                    $('#response').html(response); // Display response message
                },
                error: function(xhr, status, error) {
                    console.log('Error:', error); // Log error message
                }
            });
        } else {
            $("#response").html(""); // Clear response container
        }
    }

    $(document).ready(function () {
        // Call the checkDuplicate function each time a key is pressed in the #pet_type_name input field
        $("#pet_type_name").keyup(checkDuplicate);
    });
</script>
