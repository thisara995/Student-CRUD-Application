<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Student CRUD Application</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
</head>

<body>
    <!-- Add Student Modal -->
    <div class="modal fade" id="studentAddModal" tabindex="-1" aria-labelledby="addStudentLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="addStudentLabel">Add Student</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form action="Controller/add-student.php" method="POST">
                    <div class="modal-body">
                        <div id="errorMessage" class="alert alert-warning d-none"></div>
                        <div class="mb-3">
                            <label for="addName" class="form-label">Name</label>
                            <input type="text" name="name" id="addName" class="form-control" required />
                        </div>
                        <div class="mb-3">
                            <label for="addEmail" class="form-label">Email</label>
                            <input type="email" name="email" id="addEmail" class="form-control" required />
                        </div>
                        <div class="mb-3">
                            <label for="addAddress" class="form-label">Address</label>
                            <input type="text" name="address" id="addAddress" class="form-control" required />
                        </div>
                        <div class="mb-3">
                            <label for="addStatus" class="form-label">Status</label>
                            <select name="status" id="addStatus" class="form-select" required>
                                <option value="active">Active</option>
                                <option value="inactive">Inactive</option>
                            </select>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="submit" class="btn btn-primary">Save</button>
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- Edit Student Modal -->
    <div class="modal fade" id="studentEditModal" tabindex="-1" aria-labelledby="editStudentLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="editStudentLabel">Edit Student</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form id="editStudentForm" action="Controller/edit-student.php" method="post">
                    <div class="modal-body">
                        <div id="errorMessageUpdate" class="alert alert-warning d-none"></div>

                        <!-- Hidden field to store student ID -->
                        <input type="hidden" name="student_id" id="editStudentId" />

                        <div class="mb-3">
                            <label for="editName" class="form-label">Name</label>
                            <input type="text" name="name" id="editName" class="form-control" required />
                        </div>

                        <div class="mb-3">
                            <label for="editEmail" class="form-label">Email</label>
                            <input type="email" name="email" id="editEmail" class="form-control" required />
                        </div>

                        <div class="mb-3">
                            <label for="editAddress" class="form-label">Address</label>
                            <input type="text" name="address" id="editAddress" class="form-control" required />
                        </div>

                        <div class="mb-3">
                            <label for="editStatus" class="form-label">Status</label>
                            <select name="status" id="editStatus" class="form-select" required>
                                <option value="active">Active</option>
                                <option value="inactive">Inactive</option>
                            </select>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                        <button type="submit" name="update" class="btn btn-primary">Update Student</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- Delete Confirmation Modal -->
    <div class="modal fade" id="deleteConfirmModal" tabindex="-1" aria-labelledby="deleteConfirmModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="deleteConfirmModalLabel">Confirm Delete</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form action="Controller/delete-student.php" method="POST">
                    <div class="modal-body">
                        <input type="hidden" name="student_id" id="deleteStudentId" />
                        <p>Are you sure you want to delete this record?</p>
                    </div>
                    <div class="modal-footer">
                        <button type="submit" name="deletedata" class="btn btn-danger">Delete</button>
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <div class="container mt-4">
        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">
                        <h4>Student CRUD Application
                            <button type="button" class="btn btn-primary float-end" data-bs-toggle="modal" data-bs-target="#studentAddModal">
                                Add Student
                            </button>
                        </h4>
                    </div>
                    <div class="card-body">
                        <table id="myTable" class="table table-bordered table-striped">
                            <thead>
                                <tr>
                                    <th>Id</th>
                                    <th>Name</th>
                                    <th>Email</th>
                                    <th>Address</th>
                                    <th>Status</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                require_once "connection.php";
                                $sql_query = "SELECT * FROM students";
                                if ($result = $conn->query($sql_query)) {
                                    while ($row = $result->fetch_assoc()) {
                                        $Id = $row['id'];
                                        $Name = $row['name'];
                                        $Email = $row['email'];
                                        $Address = $row['address'];
                                        $status = $row['status'];
                                ?>
                                <tr>
                                    <td><?php echo $Id; ?></td>
                                    <td><?php echo $Name; ?></td>
                                    <td><?php echo $Email; ?></td>
                                    <td><?php echo $Address; ?></td>
                                    <td>
                                        <?php if ($status === 'active') : ?>
                                        <span class="badge bg-success">Active</span>
                                        <?php else : ?>
                                        <span class="badge bg-danger">Inactive</span>
                                        <?php endif; ?>
                                    </td>
                                    <td>
                                        <button type="button" class="btn btn-primary btn-sm editbtn" data-id="<?php echo $Id; ?>" data-name="<?php echo $Name; ?>" data-email="<?php echo $Email; ?>" data-address="<?php echo $Address; ?>" data-status="<?php echo $status; ?>" data-bs-toggle="modal" data-bs-target="#studentEditModal">Edit</button>
                                        <button type="button" class="btn btn-danger btn-sm deletebtn" data-id="<?php echo $Id; ?>" data-bs-toggle="modal" data-bs-target="#deleteConfirmModal">Delete</button>
                                    </td>
                                </tr>
                                <?php
                                    }
                                }
                                ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script>
        $(document).ready(function () {
            // Edit button click event
            $('.editbtn').on('click', function () {
                var id = $(this).data('id');
                var name = $(this).data('name');
                var email = $(this).data('email');
                var address = $(this).data('address');
                var status = $(this).data('status');

                $('#editStudentId').val(id);
                $('#editName').val(name);
                $('#editEmail').val(email);
                $('#editAddress').val(address);
                $('#editStatus').val(status);
            });

            // Delete button click event
            $('.deletebtn').on('click', function () {
                var id = $(this).data('id');
                $('#deleteStudentId').val(id);
            });
        });
    </script>
</body>

</html>
