<!-- Add Modal -->
<div class="modal fade" id="addnew">
    <div class="modal-dialog modal-lg">
        <form method="post" action="function/addUser.php" enctype="multipart/form-data">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title">Add Member</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="complete_name">Complete Name</label>
                                <input class="form-control" type="text" id="complete_name" name="complete_name" required>
                                <div id="response"></div>
                            </div>
                            <div class="form-group">
                                <label for="designation">Designation</label>
                                <textarea class="form-control" id="designation" name="designation" required></textarea>
                            </div>
                            <div class="form-group">
                                <label for="user_type">User Type</label>
                                <select class="form-control" id="user_type" name="user_type" required>
                                    <option value="admin">Admin</option>
                                    <option value="user">User</option>
                                </select>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="username">Username</label>
                                <input class="form-control" type="text" id="username" name="username" required>
                            </div>
                            <div class="form-group">
                                <label for="password">Password</label>
                                <input type="password" class="form-control" id="password" name="password" required>
                            </div>
                            <div class="form-group">
                                <label for="profile_image">Profile Picture (upload limit is 2mb)</label>
                                <input class="form-control-file" type="file" id="profile_image" name="profile_image" required accept="image/*" onchange="previewImage()">
                                <img id="imagePreview" src="#" alt="Image Preview" style="max-width: 100%; display: none;">
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer justify-content-between">
                    <button type="button" class="btn btn-default btn-flat" data-dismiss="modal">Close</button>
                    <button type="submit" id="add_button" name="add" class="btn btn-primary"><span class="glyphicon glyphicon-check"></span> Save</button>
                </div>
            </div>
        </form>
    </div>
</div>

<!-- Include jQuery library -->
<script src="../../plugins/jquery/jquery.min.js"></script>
<script>
    function previewImage() {
        var fileInput = document.getElementById('profile_image');
        var imagePreview = document.getElementById('imagePreview');

        if (fileInput.files && fileInput.files[0]) {
            var reader = new FileReader();

            reader.onload = function(e) {
                imagePreview.src = e.target.result;
                imagePreview.style.display = 'block';
            }

            reader.readAsDataURL(fileInput.files[0]);
        }
    }
</script>
