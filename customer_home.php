<?php
    include "validate_customer.php";
    include "header.php";
    include "customer_navbar.php";
    include "customer_sidebar.php";
    include "session_timeout.php";

    $id = $_SESSION['loggedIn_cust_id'];

    $sql0 = "SELECT * FROM customer WHERE cust_id=".$id;
    $result0 = $conn->query($sql0);
    $row0 = $result0->fetch_assoc();

    $sql1 = "SELECT * FROM passbook".$id." WHERE trans_id=(
                    SELECT MAX(trans_id) FROM passbook".$id.")";
    $result1 = $conn->query($sql1);
    $row1 = $result1->fetch_assoc();

    if ($row1["debit"] == 0) {
        $transaction = $row1["credit"];
        $type = "credit";
    }
    else {
        $transaction = $row1["debit"];
        $type = "debit";
    }

    $time = strtotime($row1["trans_date"]);
    $sanitized_time = date("d/m/Y, g:i A", $time);

    $sql2 = "SELECT COUNT(*) FROM beneficiary".$id;
    $result2 = $conn->query($sql2);
    $row2 = $result2->fetch_assoc();
?>

<!DOCTYPE html>
<html>
<head>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="admin_home_style1.css">
</head>

<body>
    <div class="flex-container">

        <div class="flex-item">
            
            <h2 id="customer">
                > Current Balance: <?php echo number_format($row1["balance"]); ?>/-
               
            </h2>
        </div>
    </div>
 
</body>
</html>

<?php include "easter_egg.php"; ?>
