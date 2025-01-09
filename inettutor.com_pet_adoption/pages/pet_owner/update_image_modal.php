<!-- Upload and Update Profile Picture Modal -->
<div class="modal fade" id="edit_image_<?php echo $row['pet_owner_id']; ?>" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title">Upload and Update Profile Picture for <?php echo $row['pet_owner_name']; ?></h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form method="post" action="function/uploadPetOwnerImage.php" enctype="multipart/form-data">
                    <input type="hidden" name="pet_owner_id" value="<?php echo $row['pet_owner_id']; ?>">
                    <div class="form-group">
                        <label for="pet_owner_image">Select Pet Owner Image</label>
                        <input type="file" class="form-control-file" id="pet_owner_image_<?php echo $row['pet_owner_id']; ?>" name="pet_owner_image" accept="image/*" required>
                        <img id="preview_<?php echo $row['pet_owner_id']; ?>" src="" alt="Preview" style="max-width: 100%; margin-top: 10px; display: none;">
                    </div>
                   
            </div>
                <div class="modal-footer justify-content-between">
                    <button type="button" class="btn btn-default btn-flat" data-dismiss="modal">Close</button>
                    <button type="submit" name="upload_pet_owner_image" class="btn btn-warning">Upload Image</button>
                </div>
            </form>
        </div>
    </div>
</div>



<script>
    $(document).ready(function() {
        $('input[type="file"]').change(function(e) {
            var id = $(this).attr('id');
            var previewId = id.replace('pet_owner_image_', 'preview_');
            previewImage(e.target, previewId);
        });

        function previewImage(input, previewId) {
            if (input.files && input.files[0]) {
                var reader = new FileReader();
                reader.onload = function(e) {
                    $('#' + previewId).attr('src', e.target.result).show();
                }
                reader.readAsDataURL(input.files[0]);
            }
        }
    });
</script>
