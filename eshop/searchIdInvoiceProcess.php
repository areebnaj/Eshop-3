<?php

require "connection.php";

if (isset($_GET["id"])) {
    $invoice_id = $_GET["id"];

    $invoice_rs = database::search("SELECT * FROM `invoice` WHERE `id`='" . $invoice_id . "'");
    $invoice_num = $invoice_rs->num_rows;

    if ($invoice_num == 1) {
        $invoice_data = $invoice_rs->fetch_assoc();
?>
        <div class="row mt-2 mb-2">

            <div class="col-1 text-end">
                <label class="form-label fs-5 fw-bold"><?php echo $invoice_data["id"]; ?></label>
            </div>

            <?php

            $product_rs = database::search("SELECT * FROM `product` WHERE `id`='" . $invoice_data["product_id"] . "'");
            $product_data = $product_rs->fetch_assoc();

            ?>

            <div class="col-3 text-end">
                <label class="form-label fs-5 fw-bold"><?php echo $product_data["title"]; ?></label>
            </div>

            <?php
            $user_rs = database::search("SELECT * FROM `user` WHERE `email`='" . $invoice_data["user_email"] . "'");
            $user_data = $user_rs->fetch_assoc();
            ?>

            <div class="col-3 text-end">
                <label class="form-label fs-5 fw-bold"><?php echo $user_data["fname"] . " " . $user_data["lname"]; ?></label>
            </div>
            <div class="col-2 text-end">
                <label class="form-label fs-5 fw-bold"><?php echo $invoice_data["total"]; ?></label>
            </div>
            <div class="col-1 text-end">
                <label class="form-label fs-5 fw-bold"><?php echo $invoice_data["qty"]; ?></label>
            </div>
            <div class="col-2">
                <?php

                if ($invoice_data["status"] == 0) {
                ?>
                    <button class="btn btn-success" onclick="changeStatus('<?php echo $invoice_data['id']; ?>');" id="btn<?php echo $invoice_data["id"]; ?>">Confirm Order</button>
                <?php
                } else if ($invoice_data["status"] == 1) {
                ?>
                    <button class="btn btn-warning" onclick="changeStatus('<?php echo $invoice_data['id']; ?>');" id="btn<?php echo $invoice_data["id"]; ?>">Packing</button>
                <?php
                } else if ($invoice_data["status"] == 2) {
                ?>
                    <button class="btn btn-info" onclick="changeStatus('<?php echo $invoice_data['id']; ?>');" id="btn<?php echo $invoice_data["id"]; ?>">Dispatch</button>
                <?php
                } else if ($invoice_data["status"] == 3) {
                ?>
                    <button class="btn btn-primary" onclick="changeStatus('<?php echo $invoice_data['id']; ?>');" id="btn<?php echo $invoice_data["id"]; ?>">Shipping</button>
                <?php
                } else if ($invoice_data["status"] == 4) {
                ?>
                    <button class="btn btn-danger" onclick="changeStatus('<?php echo $invoice_data['id']; ?>');" id="btn<?php echo $invoice_data["id"]; ?>">Delivered</button>
                <?php
                }

                ?>
            </div>

        </div>
<?php

    } else {
        echo ("Invalid Invoice Id!");
    }
}

?>