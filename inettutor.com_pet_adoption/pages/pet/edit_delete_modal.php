<!-- Edit Modal -->
<div class="modal fade" id="edit_<?php echo $row['pet_id']; ?>" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title">Edit Pet</h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="container-fluid">
                    <form method="POST" action="function/editPet.php" enctype="multipart/form-data">
                        <input type="hidden" name="pet_id" value="<?php echo $row['pet_id']; ?>">

                        <div class="row">
                            <!-- First Column -->
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="pet_owner_id">Pet Owner</label>
                                    <select class="form-control" name="pet_owner_id" required>
                                        <!-- Add your options here based on available pet owners -->
                                        <option value="<?php echo $row['pet_owner_id']; ?>" selected><?php echo $row['pet_owner_name']; ?></option>
                                    </select>
                                </div>
                                <div class="form-group">
                                    <label for="pet_name">Pet Name</label>
                                    <input class="form-control" type="text" name="pet_name" value="<?php echo $row['pet_name']; ?>" required>
                                </div>
                                <div class="form-group">
                                    <label for="pet_type_id">Pet Type</label>
                                    <select class="form-control" name="pet_type_id" required>
                                        <!-- Add your options here based on pet types -->
                                        <option value="<?php echo $row['pet_type_id']; ?>" selected><?php echo $row['pet_type_name']; ?></option>
                                    </select>
                                </div>
                                <div class="form-group">
                                    <label for="description">Description</label>
                                    <textarea class="form-control" name="description" required><?php echo $row['description']; ?></textarea>
                                </div>
                                <div class="form-group">
                                    <label for="age">Age</label>
                                    <input class="form-control" type="text" name="age" value="<?php echo $row['age']; ?>" required>
                                </div>
                                <div class="form-group">
                                    <label for="gender">Gender</label>
                                    <select class="form-control" name="gender" required>
                                        <option value="Male" <?php echo ($row['gender'] == 'Male') ? 'selected' : ''; ?>>Male</option>
                                        <option value="Female" <?php echo ($row['gender'] == 'Female') ? 'selected' : ''; ?>>Female</option>
                                    </select>
                                </div>
                            </div>

                            <!-- Second Column -->
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="health_status">Health Status</label>
                                    <select class="form-control" name="health_status" required>
                                        <option value="Healthy" <?php echo ($row['health_status'] == 'Healthy') ? 'selected' : ''; ?>>Healthy</option>
                                        <option value="Needs Treatment" <?php echo ($row['health_status'] == 'Needs Treatment') ? 'selected' : ''; ?>>Needs Treatment</option>
                                    </select>
                                </div>
                                <div class="form-group">
                                    <label for="upload_health_history">Upload Health History</label>
                                    <input class="form-control" type="file" name="upload_health_history">
                                    <small>
                                        Current file: 
                                        <?php 
                                            if (!empty($row['upload_health_history'])) {
                                                echo '<a href="health_history_upload/' . $row['upload_health_history'] . '" target="_blank">View Health History</a>';
                                            } else {
                                                echo 'No file uploaded';
                                            }
                                        ?>
                                    </small>
                                </div>
                                <div class="form-group">
                                    <label for="vaccination_status">Vaccination Status</label>
                                    <select class="form-control" name="vaccination_status" required>
                                        <option value="Vaccinated" <?php echo ($row['vaccination_status'] == 'Vaccinated') ? 'selected' : ''; ?>>Vaccinated</option>
                                        <option value="Not Vaccinated" <?php echo ($row['vaccination_status'] == 'Not Vaccinated') ? 'selected' : ''; ?>>Not Vaccinated</option>
                                    </select>
                                </div>
                                <div class="form-group">
                                    <label for="proof_of_vaccination">Proof of Vaccination</label>
                                    <input class="form-control" type="file" name="proof_of_vaccination">
                                    <small>
                                        Current file: 
                                        <?php 
                                            if (!empty($row['proof_of_vaccination'])) {
                                                echo '<a href="vaccination_proof_upload/' . $row['proof_of_vaccination'] . '" target="_blank">View Proof of Vaccination</a>';
                                            } else {
                                                echo 'No file uploaded';
                                            }
                                        ?>
                                    </small>
                                </div>
                                <div class="form-group">
                                    <label for="adoption_status">Adoption Status</label>
                                    <select class="form-control" name="adoption_status" required>
                                        <option value="Available" <?php echo ($row['adoption_status'] == 'Available') ? 'selected' : ''; ?>>Available</option>
                                        <option value="Pending" <?php echo ($row['adoption_status'] == 'Pending') ? 'selected' : ''; ?>>Pending</option>
                                        <option value="Adopted" <?php echo ($row['adoption_status'] == 'Adopted') ? 'selected' : ''; ?>>Adopted</option>
                                    </select>
                                </div>
                                <div class="form-group">
                                    <label for="date_registered">Date Registered</label>
                                    <input class="form-control" type="date" name="date_registered" value="<?php echo $row['date_registered']; ?>" required>
                                </div>
                            </div>
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
<div class="modal fade" id="delete_<?php echo $row['pet_id']; ?>" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title">Delete Pet</h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <p class="text-center">Are you sure you want to delete this pet?</p>
                <h2 class="text-center"><?php echo $row['pet_name']; ?></h2>
            </div>
            <div class="modal-footer justify-content-between">
                <button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>
                <a href="function/deletePet.php?id=<?php echo $row['pet_id']; ?>" class="btn btn-danger">Yes, Delete</a>
            </div>
        </div>
    </div>
</div>
