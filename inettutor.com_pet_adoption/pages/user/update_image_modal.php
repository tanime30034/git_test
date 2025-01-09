<!-- Upload and Update Profile Picture Modal -->
<div class="modal fade" id="edit_image_<?php echo $row['user_id']; ?>" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title">Upload and Update Profile Picture for: <br>
                    <?php echo $row['complete_name']; ?></h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form method="post" action="function/uploadProfileImage.php" enctype="multipart/form-data">
                    <input type="hidden" name="user_id" value="<?php echo $row['user_id']; ?>">
                    <div class="form-group">
                        <label for="profile_image">Select Rider Image</label>
                        <input type="file" class="form-control-file" id="profile_image_<?php echo $row['user_id']; ?>" name="profile_image" accept="image/*" required>
                        <img id="preview_<?php echo $row['user_id']; ?>" src="" alt="Preview" style="max-width: 100%; margin-top: 10px; display: none;">
                    </div>
                    <button type="submit" name="upload_profile_image" class="btn btn-warning btn-block">Update Profile Image</button>
                </form>
            </div>
        </div>
    </div>
</div>

<script>
    $(document).ready(function() {
        $('input[type="file"]').change(function(e) {
            var id = $(this).attr('id');
            var previewId = id.replace('profile_image_', 'preview_');
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
