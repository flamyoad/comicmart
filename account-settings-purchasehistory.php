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

        .table-row-main {
            display: block;
            color: #3C3C3C;
            font-weight: 600;
        }

        .table-row-main:hover {
            color: #333;
            text-decoration: underline;
        }

        .table-row-sub {
            color: #333;
            font-size: 12px;
            font-weight: 400;
        }

        .table-row-sub:hover {
            color: #333;
            text-decoration: underline;
        }

        .table-row-image {
            display: block;
            margin: 0 auto;
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
                    <a class="topbar-links" href="account-settings-topuphistory.php">
                        <i class="fa fa-credit-card" style="margin-right: 5px;" aria-hidden="true"></i>
                        Topup History
                    </a>

                    <a class="topbar-links link-active" style="margin-left: 50px;" href="account-settings-purchasehistory.php">
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
                    <table id="purchaseHistoryTable" class="table table-bordered table-hover" style="width:100%">
                        <thead class="thead-dark">
                            <tr>
                                <th>Thumbnail</th>
                                <th>Title</th>
                                <th>Price</th>
                                <th>Date Purchased</th>
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
        $('#purchaseHistoryTable').DataTable({
            scrollX: true,
            pagingType: "numbers",
            processing: true,
            serverSide: false,
            ajax: {
                url: "PurchaseHistorySearchHandle.php"
            },

            // The value of "data" comes from the array sent by ajax URL (in this case, it's PurchaseHistorySearchHandle.php)
            columns: [{
                    "data": "coverImg",
                    render: getImg,
                    width: "20%"
                },

                {
                    "data": "mangaTitle",
                    width: "35%",
                    render: getMangaInfo
                },

                {
                    "data": "price",
                    width: "15%"
                },

                {
                    "data": "datetime_purchased",
                    width: "30%",
                    render: getReadableDate
                }
            ],
        });
    });

    function getImg(data, type, row, meta) {
        return '<img class="table-row-image" src="' + data + '" height="64" width="64" object-fit="cover"/>';
    }

    function getMangaInfo(data, type, row, meta) {
        return "<a class='table-row-main' target='_blank' href='" + "comicpage.php?id=" + row.mangaId + "'>" +
            row.mangaTitle +
            "</a>" +

            "<a class='table-row-sub' href='" + "comicreader.php?id=" + row.chapterId + "'>" +
            "Chapter " + row.chapterNumber + ": " + row.chapterTitle +
            "</a>"
    }

    function getReadableDate(data, type, row, meta) {
        // example data is 2020-05-26 11:07:36
        var date = new Date(data);
        return date.toUTCString();
    }

</script>

<!--
<a class='table-row-main' href="comicreader.php?id=" 4">
    row.mangaTitle
</a>

<a class="table-row-sub" href="fff">
    Chapter 3: Rccc
</a>
-->