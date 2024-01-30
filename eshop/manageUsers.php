<?php

require "connection.php";

?>

<!DOCTYPE html>

<html>

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>Manage Users | Admins | eShop</title>

    <link rel="stylesheet" href="bootstrap.css" />
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.9.1/font/bootstrap-icons.css" />
    <link rel="stylesheet" href="style.css" />

    <link rel="icon" href="resource/logo.svg" />

</head>

<body style="background-color: #74EBD5; background-image: linear-gradient(90deg,#74EBD5 0%,#9FACE6 100%);">

    <div class="container-fluid">
        <div class="row">

            <div class="col-12 bg-light text-center">
                <label class="form-label text-primary fs-1 fw-bold">Manage All Users</label>
            </div>

            <div class="col-12 mt-3">
                <div class="row">
                    <div class="offset-0 offset-lg-3 col-12 col-lg-6 mb-3">
                        <div class="row">
                            <div class="col-9">
                                <input type="text" class="form-control shadow-none" placeholder="search users here..." style="height: 40px;" />
                            </div>
                            <div class="col-3 d-grid">
                                <button class="btn btn-warning">Search</button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-12 mt-3 bg-secondary text-white">
                <div class="row">

                    <div class="col-2 col-lg-1 py-2 text-end">
                        <span class="fs-5 fw-bold">#</span>
                    </div>
                    <div class="col-2 d-none d-lg-block text-center py-2">
                        <span class="fs-5 fw-bold">Profile Picture</span>
                    </div>
                    <div class="d-none d-lg-block col-lg-2 text-center py-2">
                        <span class="fs-5 fw-bold">Username</span>
                    </div>
                    <div class="col-4 col-lg-3 text-center py-2">
                        <span class="fs-5 fw-bold">Email</span>
                    </div>
                    <div class="col-1 d-none d-lg-block text-center py-2">
                        <span class="fs-5 fw-bold">Mobile</span>
                    </div>
                    <div class="col-2 d-none d-lg-block text-center py-2">
                        <span class="fs-5 fw-bold">Registered Date</span>
                    </div>
                

                </div>
            </div>

            <?php

            $query = "SELECT * FROM `user`";
            $pageno;

            if (isset($_GET["page"])) {
                $pageno = $_GET["page"];
            } else {
                $pageno = 1;
            }

            $user_rs = Database::search($query);
            $user_num = $user_rs->num_rows;

            $results_per_page = 10;
            $number_of_pages = ceil($user_num / $results_per_page);

            $page_results = ($pageno - 1) * $results_per_page;
            $selected_rs =  Database::search($query . " LIMIT " . $results_per_page . " OFFSET " . $page_results . "");

            $selected_num = $selected_rs->num_rows;

            for ($x = 0; $x < $selected_num; $x++) {
                $selected_data = $selected_rs->fetch_assoc();

            ?>

                <div class="col-12 bg-light border">
                    <div class="row">

                        <div class="col-1 col-lg-1 border-end py-2 text-end">
                            <span class="fs-5 fw-bold"><?php echo $x + 1; ?></span>
                        </div>
                        <div class="col-2 d-none d-lg-block border-end text-center py-2" onclick="viewMsgModal('<?php echo $selected_data['email']; ?>');">
                            <?php

                            $images_rs = Database::search("SELECT * FROM `profile_image` WHERE `user_email`='" . $selected_data["email"] . "'");
                            $images_data = $images_rs->fetch_assoc();

                            ?>
                            <img src="<?php echo $images_data["path"] ?>" alt="" style="height: 40px;">
                        </div>
                        <div class="d-none d-lg-block col-lg-2 text-center border-end py-2">
                            <span class="fs-5 fw-bold"><?php echo $selected_data["fname"] . " " . $selected_data["lname"]; ?></span>
                        </div>
                        <div class="col-8 col-lg-3 text-center border-end py-2">
                            <span class="fs-5 fw-bold"><?php echo $selected_data["email"]; ?></span>
                        </div>
                        <div class="col-1 d-none d-lg-block text-center border-end py-2">
                            <span class="fs-5 fw-bold"><?php echo $selected_data["mobile"]; ?></span>
                        </div>
                        <div class="col-2 d-none d-lg-block text-center border-end py-2">
                            <span class="fs-5 fw-bold"><?php echo $selected_data["joined_date"]; ?></span>
                        </div>
                        <div class="col-3 col-lg-1 text-center py-2 d-grid border-end">
                            <?php

                            if ($selected_data["status"] == 1) {
                            ?>
                                <button class="btn btn-danger" id="ub<?php echo $selected_data['email']; ?>" onclick="blockUser('<?php echo $selected_data['email']; ?>');">Block</button>
                            <?php
                            } else {
                            ?>
                                <button class="btn btn-success" id="ub<?php echo $selected_data['email']; ?>" onclick="blockUser('<?php echo $selected_data['email']; ?>');">Unblock</button>
                            <?php
                            }

                            ?>

                        </div>

                    </div>
                </div>

                <!--modal-->
                <div class="modal" tabindex="-1" id="userMsgModal<?php echo $selected_data['email']; ?>">
                    <div class="modal-dialog">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title"><?php echo $selected_data["fname"] . " " . $selected_data["lname"]; ?></h5>
                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                            </div>
                            <div class="modal-body overflow-auto" style="height: 300px;" id="chatBox">
                            <!--viewarea-->
                            </div>
                            <div class="modal-footer">
                                <div class="col-12">
                                    <div class="row">
                                        <div class="col-9">
                                            <input type="text" class="form-control" id="msgtxt" />
                                        </div>
                                        <div class="col-3">
                                            <button type="button" class="btn btn-primary" onclick="sendAdminMsg('<?php echo $selected_data['email']; ?>');">Send</button>
                                        </div>
                                    </div>
                                </div>

                            </div>
                        </div>
                    </div>
                </div>
                <!--modal-->

            <?php
            }

            ?>

            <!--  -->
            <div class="offset-2 offset-lg-3 col-8 col-lg-6 text-center mb-3">
                <nav aria-label="Page navigation example">
                    <ul class="pagination pagination-lg justify-content-center">
                        <li class="page-item">
                            <a class="page-link" href=" <?php if ($pageno <= 1) {
                                                            echo ("#");
                                                        } else {
                                                            echo "?page=" . ($pageno - 1);
                                                        } ?>" aria-label="Previous">
                                <span aria-hidden="true">&laquo;</span>
                            </a>
                        </li>
                        <?php

                        for ($x = 1; $x <= $number_of_pages; $x++) {
                            if ($x == $pageno) {
                        ?>
                                <li class="page-item active">
                                    <a class="page-link" onclick="(<?php echo ($x) ?>);"><?php echo $x; ?></a>
                                </li>
                            <?php
                            } else {
                            ?>
                                <li class="page-item">
                                    <a class="page-link" onclick="(<?php echo ($x) ?>);"><?php echo $x; ?></a>
                                </li>
                        <?php
                            }
                        }

                        ?>

                        <li class="page-item">
                            <a class="page-link" href="<?php if ($pageno >= $number_of_pages) {
                                                            echo ("#");
                                                        } else {
                                                            echo "?page="($pageno + 1);
                                                        } ?>" aria-label="Next">
                                <span aria-hidden="true">&raquo;</span>
                            </a>
                        </li>
                    </ul>
                </nav>
            </div>
            <!--  -->

        </div>
    </div>

    <script src="script.js"></script>
    <script src="bootstrap.js"></script>
</body>

</html>