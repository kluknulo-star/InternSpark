<?php
if (isset($_SESSION["error"]) && isset(ALL_TABLE_ARRAY[$_SESSION["error"]])) { ?>
    <div class="alert alert-danger alert-dismissible fade show" role="alert">
        <strong><?php echo ALL_TABLE_ARRAY[$_SESSION["error"]] ?></strong>
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
    <?php
    $_SESSION["error"] = "";
} elseif (isset($_SESSION["success"]) && isset(ALL_TABLE_ARRAY[$_SESSION["success"]])) { ?>
    <div class="alert alert-success alert-dismissible fade show" role="alert">
        <strong><?php echo ALL_TABLE_ARRAY[$_SESSION["success"]] ?></strong>
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
    <?php
    unset($_SESSION["success"]);
}
?>
