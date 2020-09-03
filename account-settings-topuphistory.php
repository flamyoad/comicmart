<?php
session_start();
?>

<html>

<head>
    <link rel="stylesheet" href="css/bootstrap-4.4.1-dist/css/bootstrap.css">
    <link rel="stylesheet" href="https://cdn.datatables.net/1.10.21/css/dataTables.bootstrap4.min.css">
    <script src="scripts/jquery-3.4.1.js"></script>
    <script src="https://cdn.datatables.net/1.10.21/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/1.10.21/js/dataTables.bootstrap4.min.js"></script>

    <style>
        /* */
        .my-container {
            display: grid;
            grid-template-columns: min-content 1fr;
            font-family: system-ui, sans-serif;
            background-color: #f7f8f9;
            height: 1000px;
        }

        nav {
            background-color: #37474F;
            box-shadow: 7px 5px 5px silver;
        }

        nav ul {
            list-style: none;
            position: sticky;
            top: 0;
            padding: 0px;
        }

        nav ul li {
            display: flex;
            flex-direction: row;
        }

        nav ul li a {
            display: block;
            padding-left: 36px;
            padding-right: 36px;
            padding-top: 20px;
            padding-bottom: 20px;
            width: 100%;
            text-decoration: none;
            white-space: nowrap;
            color: white;
            font-family: Arial, Helvetica, sans-serif;
        }

        nav ul li a:hover {
            background-color: #56707c;
            text-decoration: none;
            color: white;
        }

        .nav-icons {
            margin: auto 0;
            margin-right: 10px;
            color: white;
        }

        .content {
            border-style: solid;
            border-width: 1px;
            border-color: white;
            border-radius: 10px;
            margin-left: 80px;
            margin-right: 8px;
            margin-top: 20px;
            background-color: white;
            padding: 32px;
            padding-top: 16px;
        }

        .content-title {
            font-size: 25px;
            font-weight: bold;
            margin-left: 80px;
            margin-top: 20px;
            color: #7b7c7c;
        }

        .topbar {
            display: flex;
        }

        .topbar-links {
            color: #7b7c7c;
            font-family: Arial, Helvetica, sans-serif;
            font-weight: bold;
        }

        .topbar-links:hover {
            text-decoration: none;
            color: black;
        }

        .link-active {
            color: #1C1C1C;
        }
    </style>
</head>

<body>
    <?php require_once "header.php" ?>

    <div class="my-container">

        <nav id="sidebar">
            <ul>

                <li>
                    <a href="account-settings.php">
                        <i class="fa fa-user-o nav-icons" aria-hidden="true"></i>
                        <span>User Profile</span>
                    </a>
                </li>

                <li>
                    <a href="account-settings-library.php">
                        <i class="fa fa-book nav-icons" aria-hidden="true"></i>
                        <span>Library</span>
                    </a>
                </li>

                <li>
                    <a href="account-settings-topuphistory.php"">
                        <i class=" fa fa-credit-card nav-icons" aria-hidden="true"></i>
                        <span>Wallet</span>
                    </a>
                </li>

                <li>
                    <a href="account-settings-upload.php">
                        <i class="fa fa-upload nav-icons" aria-hidden="true"></i>
                        <span>Uploaded Works</span>
                    </a>
                </li>
                
                <li>
                    <a href="account-settings-earnings.php">
                        <i class="fa fa-dollar nav-icons" aria-hidden="true"></i>
                        <span>Earnings</span>
                    </a>
                </li>

            </ul>
        </nav>

        <div>
            <p class="content-title">Wallet</p>

            <div class="content">
                <div class="topbar">
                    <a class="topbar-links link-active" href="account-settings-topuphistory.php">
                        <i class="fa fa-credit-card" style="margin-right: 5px;" aria-hidden="true"></i>
                        Topup History
                    </a>

                    <a class="topbar-links" style="margin-left: 50px;" href="account-settings-purchasehistory.php">
                        <i class="fa fa-cart-plus" style="margin-right: 5px;" aria-hidden="true"></i>
                        Purchase History
                    </a>

                    <a class="btn-topup bttn-jelly bttn-sm bttn-warning" style="margin-left: auto; margin-right: 40px; font-size: 15px; padding-left: 32px; padding-right: 32px;">
                        <i class="fa fa fa-dollar"></i>
                        TOP UP
                    </a>
                </div>

                <hr />

                <div>
                    <table id="topupTable" class="table table-bordered table-hover" style="width:100%">
                        <thead class="thead-dark">
                            <tr>
                                <th>Date & Time</th>
                                <th>Amount</th>
                            </tr>
                        </thead>

                        <tbody>
                            <!-- <tr>
                                <td>Tiger Nixon</td>
                                <td>System Architect</td>
                            </tr> -->
                        </tbody>

                    </table>
                </div>

            </div>
        </div>

</body>

<script>
    $(document).ready(function() {
        $('#topupTable').DataTable({
            scrollX: true,
            pagingType: "numbers",
            processing: true,
            serverSide: false,
            ajax: {
                url: "TopupHistorySearchHandle.php"
            },
            columns: [{
                    "data": "datetime",
                    render: getReadableDate
                },

                {
                    "data": "amount"
                }
            ]
        });
    });

    function getReadableDate(data, type, row, meta) {
        // example data is 2020-05-26 11:07:36
        var date = new Date(data);
        return date.toUTCString();
    }
</script>