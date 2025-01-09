<!-- Add Pet Modal -->
<div class="modal fade" id="addnew">
    <div class="modal-dialog modal-lg"> <!-- Modal size set to large -->
        <form method="post" action="function/addPet.php" enctype="multipart/form-data">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title">Add New Pet</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="row"> <!-- Row Start -->

                        <!-- First Column -->
                        <div class="col-md-4">
                            <div class="form-group">
                                <label for="pet_owner_id">Pet Owner</label>
                                <select class="form-control" id="pet_owner_id" name="pet_owner_id" required>
                                    <option value="" selected disabled>Select Pet Owner</option>
                                    <?php
                                        require_once('../includes/dbcon.php');
                                        $sql = "SELECT pet_owner_id, pet_owner_name FROM tbl_pet_owner";
                                        $query = $conn->query($sql);
                                        while($row = $query->fetch_assoc()) {
                                            echo "<option value='".$row['pet_owner_id']."'>".$row['pet_owner_name']."</option>";
                                        }
                                    ?>
                                </select>
                            </div>
                            <div class="form-group">
                                <label for="pet_name">Pet Name</label>
                                <input class="form-control" type="text" id="pet_name" name="pet_name" required>
                            </div>
                            <div class="form-group">
                                <label for="pet_type_id">Pet Type</label>
                                <select class="form-control" id="pet_type_id" name="pet_type_id" required>
                                    <option value="" selected disabled>Select Pet Type</option>
                                    <?php
                                        $sql = "SELECT pet_type_id, pet_type_name FROM tbl_pet_type";
                                        $query = $conn->query($sql);
                                        while($row = $query->fetch_assoc()) {
                                            echo "<option value='".$row['pet_type_id']."'>".$row['pet_type_name']."</option>";
                                        }
                                    ?>
                                </select>
                            </div>
                            <div class="form-group">
                                <label for="description">Description</label>
                                <textarea class="form-control" id="description" name="description" required></textarea>
                            </div>
                            <div class="form-group">
                                <label for="age">Age (in years)</label>
                                <input class="form-control" type="number" id="age" name="age" min="0" required>
                            </div>
                            <div class="form-group">
                                <label for="gender">Gender</label>
                                <select class="form-control" id="gender" name="gender" required>
                                    <option value="" selected disabled>Select Gender</option>
                                    <option value="Male">Male</option>
                                    <option value="Female">Female</option>
                                </select>
                            </div>
                        </div>
                        <!-- End First Column -->

                        <!-- Second Column -->
                        <div class="col-md-4">
                            <div class="form-group">
                                <label for="health_status">Health Status</label>
                                <select class="form-control" id="health_status" name="health_status" required>
                                    <option value="" selected disabled>Select Health Status</option>
                                    <option value="Healthy">Healthy</option>
                                    <option value="Needs Treatment">Needs Treatment</option>
                                </select>
                            </div>
                            <div class="form-group">
                                <label for="upload_health_history">Upload Health History</label>
                                <input class="form-control-file" type="file" id="upload_health_history" name="upload_health_history" accept=".pdf, .docx">
                            </div>
                            <div class="form-group">
                                <label for="vaccination_status">Vaccination Status</label>
                                <select class="form-control" id="vaccination_status" name="vaccination_status" required>
                                    <option value="" selected disabled>Select Vaccination Status</option>
                                    <option value="Vaccinated">Vaccinated</option>
                                    <option value="Not Vaccinated">Not Vaccinated</option>
                                </select>
                            </div>
                            <div class="form-group">
                                <label for="proof_of_vaccination">Upload Proof of Vaccination</label>
                                <input class="form-control-file" type="file" id="proof_of_vaccination" name="proof_of_vaccination" accept=".pdf, .jpg, .png">
                            </div>
                            <div class="form-group">
                                <label for="adoption_status">Adoption Status</label>
                                <select class="form-control" id="adoption_status" name="adoption_status" required>
                                    <option value="" selected disabled>Select Adoption Status</option>
                                    <option value="Available">Available</option>
                                    <option value="Pending">Pending</option>
                                    <option value="Adopted">Adopted</option>
                                </select>
                            </div>
                            <div class="form-group">
                                <label for="date_registered">Date Registered</label>
                                <input class="form-control" type="date" id="date_registered" name="date_registered" required>
                            </div>
                        </div>
                        <!-- End Second Column -->

                        <!-- Third Column -->
                        <div class="col-md-4">
                            <div class="form-group">
                                <label for="pet_profile_image">Upload Pet Profile Image</label>
                                <input class="form-control-file" type="file" id="pet_profile_image" name="pet_profile_image" accept="image/*" onchange="previewImage()">
                            </div>
                            <img id="imagePreview" src="#" alt="Profile Image Preview" style="max-width: 100%; display: none;">
                        </div>
                        <!-- End Third Column -->
                    </div> <!-- End Row -->
                </div>
                <div class="modal-footer justify-content-between">
                    <button type="button" class="btn btn-default btn-flat" data-dismiss="modal">Close</button>
                    <button type="submit" name="add" class="btn btn-primary">Save</button>
                </div>
            </div>
        </form>
    </div>
</div>

<script>
    // Function to preview the selected image
    function previewImage() {
        var fileInput = document.getElementById('pet_profile_image');
        var imagePreview = document.getElementById('imagePreview');

        // Check if a file is selected
        if (fileInput.files && fileInput.files[0]) {
            var reader = new FileReader();

            // When image file is loaded
            reader.onload = function(e) {
                imagePreview.src = e.target.result;
                imagePreview.style.display = 'block'; // Show the image preview
            };

            // Read the image file
            reader.readAsDataURL(fileInput.files[0]);
        }
    }
</script>
