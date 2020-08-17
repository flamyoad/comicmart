<?php 
    session_start();
    $userId = $_SESSION['user_id'];
?>

<head>
    <meta name="viewport" content="width=device-width, initial-scale=1"> <!-- Ensures optimal rendering on mobile devices. -->
    <meta http-equiv="X-UA-Compatible" content="IE=edge" /> <!-- Optimal Internet Explorer compatibility -->

    <script src="scripts/jquery-3.4.1.js"></script>
    <script src="https://www.paypal.com/sdk/js?client-id=ATUNMEEEZSbQyxzGMcb2JxJT0LW2g5BYznLxfUZMW0Jd7SK0TPBz0FIl4RtMX37HCpXm-I4R1lHp4ZgI"></script>

    <style>
        body {
            background-color: rgb(242, 243, 247);
        }

        .header {
            background-color: rgb(246, 246, 246);
        }

        .header-text {
            display: inline-block;
            font-weight: bold;
            margin-left: 24px;
            background-color: rgb(246, 246, 246);
            color: rgb(51, 60, 69);
        }

        .container {
            margin: 36px;
            border: solid rgb(239, 239, 240) 3px;
        }

        .amount-panel {
            display: flex;
        }

        .money-item {
            padding-right: 20px;
        }

        .btn-continue {
            border: 0;
            margin-top: 30px;
            color: white;
            background-color: rgb(242, 170, 0);
            padding: 15px 30px;
            font-weight: bold;
        }

        .btn-continue:hover {
            cursor: pointer;
        }
    </style>
</head>

<body>

    <div class="container">
        <div class="header">
            <p class="header-text">PAYMENT</p>
        </div>

        <form style="margin: 30px;" action="TopupHandle.php" method="POST">
            <div class="amount-panel">
                <div class="money-item">
                    <input type="radio" id="1" value="1" name="amount" checked>
                    <label for="1">100 MPoints</label>
                </div>

                <div class="money-item">
                    <input type="radio" id="5" value="5" name="amount">
                    <label for="5">500 MPoints</label>
                </div>

                <div class="money-item">
                    <input type="radio" id="10" value="10" name="amount">
                    <label for="10">1000 MPoints</label>
                </div>

                <div class="money-item">
                    <input type="radio" id="25" value="25" name="amount">
                    <label for="25">2500 MPoints</label>
                </div>

                <div class="money-item">
                    <input type="radio" id="50" value="50" name="amount">
                    <label for="50">5000 MPoints</label>
                </div>
            </div>

            <!-- <input class="btn-continue" type="submit" value="CONTINUE"> -->

        </form>

        <div id="paypal-button-container"></div>

    </div>

</body>

<script>
    paypal.Buttons({
        createOrder: function(data, actions) {
            // The amount of money chosen from form
            var userId = <?php echo $userId ?>;
            var selectedMoneyAmount = $("input[name=amount]:checked").val();

            // This function sets up the details of the transaction, including the amount and line item details.
            return actions.order.create({
                purchase_units: [{
                    amount: {
                        value: selectedMoneyAmount
                    }
                }]
            });
        },
        onApprove: function(data, actions) {
            // This function captures the funds from the transaction.
            return actions.order.capture().then(function(details) {
                // This function shows a transaction success message to your buyer.
                var userId = <?php echo $userId ?>;
                var selectedMoneyAmount = $("input[name=amount]:checked").val();

                $.ajax({
                    url: "TopupHandle.php",
                    type: "POST",
                    data: {
                        "user_id": userId,
                        "amount": selectedMoneyAmount * 100
                    }
                });
            });
        }
    }).render('#paypal-button-container');
    //This function displays Smart Payment Buttons on your web page.
</script>