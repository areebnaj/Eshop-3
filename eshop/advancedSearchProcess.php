<?php

require "connection.php";

$text = $_POST["t"];
$category = $_POST["cat"];
$brand = $_POST["br"];
$model = $_POST["md"];
$condition = $_POST["con"];
$color = $_POST["clr"];
$pfrom = $_POST["from"];
$pto = $_POST["to"];
$sortby = $_POST["sby"];
$page = $_POST["page"];

$query = "SELECT * FROM `product`";
$status = 0;

if ($sortby == 0) {

    if (!empty($text)) {
        $query .= " WHERE `title` LIKE '%" . $text . "%'";
        $status = 1;
    }

    if ($status == 0 && $category != 0) {

        $query .= " WHERE `category_id`='" . $category . "'";
        $status = 1;
    } else if ($status != 0 && $category != 0) {
        $query .= " AND `category_id`='" . $category . "'";
    }

    $pid = 0;
    if($brand != 0 && $model == 0){

        $brand_rs = Database::search("SELECT * FROM `brand_has_model` WHERE `brand_id`='".$brand."'");
        $brand_num = $brand_rs->num_rows;
        for ($x = 0;$x < $brand_num;$x++){
            $brand_data = $brand_rs->fetch_assoc();
            $pid = $brand_data["id"];
        }

        if($status == 0){
            $query .= " WHERE `brand_has_model_id`='".$pid."'";
            $status = 1;
        }else if($status != 0){
            $query .= " AND `brand_has_model_id`='".$pid."'";
        }

    }
    if ($brand == 0 && $model != 0) {

        $model_rs = database::search("SELECT * FROM `brand_has_model` WHERE `model_id`='" . $model . "'");
        $model_num = $model_rs->num_rows;
        for ($x = 0; $x < $model_num; $x++) {
            $model_data = $model_rs->fetch_assoc();
            $pid = $model_data["id"];
        }

        if ($status == 0) {
            $query .= " WHERE `brand_has_model_id`='" . $pid . "'";
            $status = 1;
        } else if ($status != 0) {
            $query .= " AND `brand_has_model_id`='" . $pid . "'";
        }
    }

    if ($brand != 0 && $model != 0) {

        $brand_has_model_rs = database::search("SELECT * FROM `brand_has_model` WHERE `brand_id`='" . $brand . "' AND `model_id`='" . $model . "'");
        $brand_has_model_num = $brand_has_model_rs->num_rows;
        for ($x = 0; $x < $brand_has_model_num; $x++) {
            $brand_has_model_data = $brand_has_model_rs->fetch_assoc();
            $pid = $brand_has_model_data["id"];
        }

        if ($status == 0) {
            $query .= " WHERE `brand_has_model_id`='" . $pid . "'";
            $status = 1;
        } else if ($status != 0) {
            $query .= " AND `brand_has_model_id`='" . $pid . "'";
        }
    }

    if ($status == 0 && $condition != 0) {
        $query .= " WHERE `condition_id`='" . $condition . "'";
        $status = 1;
    } else if ($status != 0 && $condition != 0) {
        $query .= " AND `condition_id`='" . $condition . "'";
    }

    if ($status == 0 && $color != 0) {
        $query .= " WHERE `colour_id`='" . $color . "'";
        $status = 1;
    } else if ($status != 0 && $color != 0) {
        $query .= " AND `colour_id`='" . $color . "'";
    }

    if (!empty($pfrom) && empty($pto)) {
        if ($status == 0) {
            $query .= " WHERE `price` >= '" . $pfrom . "' ";
            $status = 1;
        } else if ($status != 0) {
            $query .= " AND `price` >= '" . $pfrom . "' ";
        }
    } else if (empty($pfrom) && !empty($pto)) {
        if ($status == 0) {
            $query .= " WHERE `price` <= '" . $pto . "' ";
            $status = 1;
        } else if ($status != 0) {
            $query .= " AND `price` <= '" . $pto . "' ";
        }
    } else if (!empty($pfrom) && !empty($pto)) {
        if ($status == 0) {
            $query .= " WHERE `price` BETWEEN '" . $pfrom . "' AND '" . $pto . "' ";
            $status = 1;
        } else if ($status != 0) {
            $query .= " AND `price` BETWEEN '" . $pfrom . "' AND '" . $pto . "' ";
        }
    }
} else if ($sortby == 1) {

    if (!empty($text)) {
        $query .= " WHERE `title` LIKE '%" . $text . "%' ORDER BY `price` DESC";
        $status = 1;
    } else if (empty($text)) {
        $query .= " ORDER BY `price` DESC";
    }
} else if ($sortby == 2) {

    if (!empty($text)) {
        $query .= " WHERE `title` LIKE '%" . $text . "%' ORDER BY `price` ASC";
        $status = 1;
    } else if (empty($text)) {
        $query .= " ORDER BY `price` ASC";
    }
} else if ($sortby == 3) {
    if (!empty($text)) {
        $query .= " WHERE `title` LIKE '%" . $text . "%' ORDER BY `qty` DESC";
        $status = 1;
    } else if (empty($text)) {
        $query .= " ORDER BY `qty` DESC";
    }
} else if ($sortby == 4) {
    if (!empty($text)) {
        $query .= " WHERE `title` LIKE '%" . $text . "%' ORDER BY `qty` ASC";
        $status = 1;
    } else if (empty($text)) {
        $query .= " ORDER BY `qty` ASC";
    }
}


if ($_POST["page"] != "0") {

    $pageno = $_POST["page"];
} else {

    $pageno = 1;
}

$product_rs = Database::search($query);
$product_num = $product_rs->num_rows;

$results_per_page = 10;
$number_of_pages = ceil($product_num / $results_per_page);

$viewed_results_count = ((int)$pageno - 1) * $results_per_page;

$query .= " LIMIT " . $results_per_page . " OFFSET " . $viewed_results_count . "";
$results_rs = Database::search($query);
$results_num = $results_rs->num_rows;

while ($results_data = $results_rs->fetch_assoc()) {
?>

    <div class="card mb-3 mt-3 col-12 col-lg-6">
        <div class="row">

            <div class="col-md-4 mt-4">

                <?php

                $product_img_rs = database::search("SELECT * FROM `images` WHERE `product_id`='" . $results_data["id"] . "' ");
                $product_img_data = $product_img_rs->fetch_assoc();

                ?>

                <img src="<?php echo $product_img_data["code"]; ?>" class="img-fluid rounded-start" alt="...">
            </div>
            <div class="col-md-8">
                <div class="card-body">

                    <h5 class="card-title fw-bold"><?php echo $results_data["title"]; ?></h5>
                    <span class="card-text text-primary fw-bold"><?php echo $results_data["price"]; ?></span>
                    <br />
                    <span class="card-text text-success fw-bold fs"><?php echo $results_data["qty"]; ?> Items left</span>

                    <div class="row">
                        <div class="col-12">

                            <div class="row g-1">
                                <div class="col-12 col-lg-6 d-grid">
                                    <a href="#" class="btn btn-success fs">Buy Now</a>
                                </div>
                                <div class="col-12 col-lg-6 d-grid">
                                    <a href="#" class="btn btn-danger fs">Add Cart</a>
                                </div>
                            </div>

                        </div>
                    </div>

                </div>
            </div>
        </div>
    </div>

<?php
}

?>


<div class="offset-2 offset-lg-3 col-8 col-lg-6 text-center mb-3">
    <nav aria-label="Page navigation example">
        <ul class="pagination pagination-lg justify-content-center">
            <li class="page-item">
                <a class="page-link" <?php if ($pageno <= 1) {
                                            echo "#";
                                        } else {
                                        ?> onclick="advancedSearch('<?php echo ($pageno - 1); ?>')" <?php
                                                                                                } ?>aria-label="Previous">
                    <span aria-hidden="true">&laquo;</span></a>
            </li>

            <?php

            for ($page = 1; $page <= $number_of_pages; $page++) {

                if ($page == $pageno) {

            ?>
                    <li class="page-item active">
                        <a class="page-link" onclick="advancedSearch('<?php echo ($page); ?>')" class="active">
                            <?php echo $page; ?>
                        </a>
                    </li>
                <?php

                } else {

                ?>
                    <a class="page-link" onclick="advancedSearch('<?php echo ($page); ?>')">
                        <?php echo $page; ?>
                    </a>
            <?php

                }
            }

            ?>

            <a class="page-link" <?php if ($pageno >= $number_of_pages) {
                                        echo "#";
                                    } else {
                                    ?> onclick="advancedSearch('<?php echo ($pageno + 1); ?>')" <?php
                                                                                            } ?>>&raquo;</a>
        </ul>
    </nav>
</div>
