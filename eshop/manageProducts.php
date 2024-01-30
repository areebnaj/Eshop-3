<!DOCTYPE html>

<html>

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>Manage Products | Admins | eShop</title>

    <link rel="stylesheet" href="bootstrap.css" />
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.9.1/font/bootstrap-icons.css" />
    <link rel="stylesheet" href="style.css" />

    <link rel="icon" href="resource/logo.svg" />

</head>

<body style="background-color: #74EBD5; background-image: linear-gradient(90deg,#74EBD5 0%,#9FACE6 100%);">

    <div class="container-fluid">
        <div class="row">

            <div class="col-12 bg-light text-center">
                <label class="form-label text-primary fs-1 fw-bold">Manage All Products</label>
            </div>

            <div class="col-12 mt-3">
                <div class="row">
                    <div class="offset-0 offset-lg-3 col-12 col-lg-6 mb-3">
                        <div class="row">
                            <div class="col-9">
                                <input type="text" class="form-control shadow-none" placeholder="search products here..." style="height: 40px;" />
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

                    <div class="col-2 col-lg-1 py-2 text-center">
                        <span class="fs-5 fw-bold">#</span>
                    </div>
                    <div class="col-2 d-none d-lg-block text-center py-2">
                        <span class="fs-5 fw-bold">Product Image</span>
                    </div>
                    <div class="col-4 col-lg-3 text-center py-2">
                        <span class="fs-5 fw-bold">Title</span>
                    </div>
                    <div class="col-4 col-lg-2 text-center py-2">
                        <span class="fs-5 fw-bold">Price</span>
                    </div>
                    <div class="col-1 d-none d-lg-block text-center py-2">
                        <span class="fs-5 fw-bold">Quantity</span>
                    </div>
                    <div class="col-2 d-none d-lg-block text-center py-2">
                        <span class="fs-5 fw-bold">Registered Date</span>
                    </div>
                    <div class="col-2 col-lg-1 text-center"></div>

                </div>
            </div>

            <?php
            require "connection.php";

            $query = "SELECT * FROM `product`";
            $pageno;

            if (isset($_GET["page"])) {
                $pageno = $_GET["page"];
            } else {
                $pageno = 1;
            }

            $product_rs = database::search($query);
            $product_num = $product_rs->num_rows;

            $results_per_page = 15;
            $number_of_pages = ceil($product_num / $results_per_page);

            $page_results = ($pageno - 1) * $results_per_page;
            $selected_rs =  Database::search($query . " LIMIT " . $results_per_page . " OFFSET " . $page_results . "");

            $selected_num = $selected_rs->num_rows;

            for ($x = 0; $x < $selected_num; $x++) {
                $selected_data = $selected_rs->fetch_assoc();

            ?>

                <div class="col-12 bg-light border">
                    <div class="row">

                        <div class="col-2 col-lg-1 border-end py-2 text-center">
                            <span class="fs-5 fw-bold"><?php echo $x + 1; ?></span>
                        </div>
                        <div class="col-2 d-none d-lg-block border-end text-center py-2" onclick="viewProductModal('<?php echo $selected_data['id']; ?>');">
                            <?php
                            $img = array();

                            $images_rs = Database::search("SELECT * FROM `images` WHERE `product_id`='" . $selected_data["id"] . "'");
                            $images_data = $images_rs->fetch_assoc();

                            ?>
                            <img src="<?php echo $images_data["code"]; ?>" alt="" style="height: 40px;">
                        </div>
                        <div class="col-4 col-lg-3 text-center border-end py-2">
                            <span class="fs-5 fw-bold"><?php echo $selected_data["title"]; ?></span>
                        </div>
                        <div class="col-4 col-lg-2 text-center border-end py-2">
                            <span class="fs-5 fw-bold"><?php echo $selected_data["price"]; ?></span>
                        </div>
                        <div class="col-1 d-none d-lg-block text-center border-end py-2">
                            <span class="fs-5 fw-bold"><?php echo $selected_data["qty"]; ?></span>
                        </div>
                        <div class="col-2 d-none d-lg-block text-center border-end py-2">
                            <span class="fs-5 fw-bold"><?php echo $selected_data["datetime_added"]; ?></span>
                        </div>
                        <div class="col-2 col-lg-1 text-center py-2 border-end">
                            <button class="btn btn-danger">Block</button>
                        </div>

                    </div>
                </div>

                <!--modal-->
                <div class="modal" tabindex="-1" id="viewProductModal<?php echo $selected_data['id']; ?>">
                    <div class="modal-dialog">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title text-secondary fw-bold"><?php echo $selected_data["title"]; ?></h5>
                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                            </div>
                            <div class="modal-body">
                                <div class="col-12 text-center">
                                    <img src="<?php echo $images_data["code"]; ?>" alt="" style="height: 150px;">
                                </div>
                                <div class="col-12 mt-3">
                                    <span class="fw-bold">Price : </span>
                                    <span class="fw-bold text-primary">Rs. <?php echo $selected_data["price"]; ?> .00</span><br>
                                    <span class="fw-bold">Quantity : </span>
                                    <span class="fw-bold text-primary"> <?php echo $selected_data["qty"]; ?> items left</span><br>
                                    <span class="fw-bold">Seller : </span>
                                    <span class="fw-bold text-primary">Rimas</span><br>
                                    <span class="fw-bold">Description : </span>
                                    <span class="fw-bold text-primary"><?php echo $selected_data["description"]; ?></span>
                                </div>
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                            </div>
                        </div>
                    </div>
                </div>
                <!--modal-->

            <?php

            }

            ?>

            <hr class="mt-3 mb-3" />

            <div class="col-12 text-center">
                <h3 class="text-black-50 fw-bold">Manage Categories</h3>
            </div>

            <div class="col-12 mt-3 mb-3">
                <div class="row gap-2 justify-content-center">

                    <?php

                    $category_rs = database::search("SELECT * FROM `category`");
                    $category_num = $category_rs->num_rows;
                    for ($x = 0; $x < $category_num; $x++) {
                        $category_data = $category_rs->fetch_assoc();
                    ?>

                        <div class="col-12 col-lg-3 border border-danger rounded" style="height: 50px;">
                            <div class="row">

                                <div class="col-10 text-center mt-2 mb-2">
                                    <label class="form-label fw-bold fs-5"><?php echo $category_data["name"]; ?></label>
                                </div>
                                <div class="col-2 border-start border-secondary text-center mt-2 mb-2">
                                    <label class="form-label fs-4"><i class="bi bi-trash-fill text-danger fs-4"></i></label>
                                </div>

                            </div>
                        </div>

                    <?php
                    }
                    ?>

                    <div class="col-12 col-lg-3 border border-success rounded" style="height: 50px;" onclick="addNewCategory();">
                        <div class="row">

                            <div class="col-10 text-center mt-2 mb-2">
                                <label class="form-label fw-bold fs-5" style="cursor:pointer;">Add New Category</label>
                            </div>
                            <div class="col-2 border-start border-secondary text-center mt-2 mb-2">
                                <label class="form-label fs-4"><i class="bi bi-plus-square-fill fs-5 text-success" style="cursor:pointer;"></i></label>
                            </div>

                        </div>
                    </div>

                </div>
            </div>

            <!--modal2-->
            <div class="modal" tabindex="-1" id="addCategoryModal">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title fw-bold">Add New Category</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <div class="modal-body">
                            <div class="col-12">
                                <label class="form-label">New Category Name : </label>
                                <input type="text" class="form-control" id="n" />
                            </div>
                            <div class="col-12 mt-2">
                                <label class="form-label">Enter Your Email : </label>
                                <input type="text" class="form-control" id="e" />
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-primary" onclick="verifyCategory();">Save New Category</button>
                        </div>
                    </div>
                </div>
            </div>
            <!--modal2-->

            <!--modal3-->
            <div class="modal" tabindex="-1" id="addCategoryVerificationModal">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title">Verification</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <div class="modal-body">
                            <div class="col-12 mt-3 mb-3">
                                <label class="form-label">Enter Your Verification Code :</label>
                                <input type="text" class="form-control" id="txt" />
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                            <button type="button" class="btn btn-primary" onclick="saveCategory();">Save changes</button>
                        </div>
                    </div>
                </div>
            </div>
            <!--modal3-->

        </div>
    </div>

    <script src="script.js"></script>
    <script src="bootstrap.js"></script>
</body>

</html>