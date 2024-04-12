<!DOCTYPE html>
<html lang='en'>

<head>
    <meta charset='UTF-8'>
    <meta name='viewport' content='width=device-width, initial-scale=1.0'>
    <title>User Profile</title>
    <!-- <link rel='stylesheet' href='nav.css'> -->
    <link rel="stylesheet" href="books.css" />
</head>

<body>
    <!-- ------------------- SIDEBAR ---------------------------- -->
    <div class="sidebar">
        <h2>Filters</h2>
        <div>
            <input type="checkbox" id="pending" name="filter" value="0" onclick="handleCheckboxClick(this)">
            <label for="pending">Pending Bookings</label>
        </div>
        <div>
            <input type="checkbox" id="accepted" name="filter" value="2" onclick="handleCheckboxClick(this)">
            <label for="accepted">Accepted Bookings</label>
        </div>
        <div>
            <input type="checkbox" id="declined" name="filter" value="1" onclick="handleCheckboxClick(this)">
            <label for="declined">Declined Bookings</label>
        </div>

        <div class="line"></div>
        <div>
            <input type="button" id="back" name="filter" onclick="back()">
            <label for="back">Back</label>
        </div>
        <div>
            <input type="button" id="signout" name="filter" onclick="signout()">
            <label for="signout">Sign Out</label>
        </div>
    </div>
    <!-- ------------------- SIDEBAR ---------------------------- -->
    <div class="main">
        <table border='1' id="bookingsTable">
            <thead>
                <tr>
                    <th>Name</th>
                    <th>Phone</th>
                    <th>Email</th>
                    <th>Location</th>
                    <th>Date and Time</th>
                    <th colspan='2'>Status</th>
                </tr>
            </thead>
            <?php
            session_start();
            include "../connect.php"; // Include your database connection script
            $userId = $_SESSION['user_id'];
            $getBooking = "SELECT * FROM bookings WHERE worker_id=$userId";
            $result2 = $con->query($getBooking);

            if (mysqli_num_rows($result2) > 0) {
                // Loop through each row of data
                while ($row2 = mysqli_fetch_assoc($result2)) {
                    // Retrieve booking details
                    $userId1 = $row2['user_id'];
                    $status = $row2['status'];
                    $dnt = $row2['dateTime'];
                    $bid = $row2['id'];

                    // Retrieve user details
                    $getUserDetail = "SELECT * FROM users WHERE id=$userId1";
                    $result3 = $con->query($getUserDetail);
                    $row3 = mysqli_fetch_assoc($result3);
                    $uname = $row3['username'];
                    $umail = $row3['email'];
                    $uphone = $row3['phone'];
                    $ulocation = $row3['location'];

                    // Output booking row
                    echo "<tr class='booking-row status-$status'>
                        <td>$uname</td>
                        <td>$umail</td>
                        <td>$uphone</td>
                        <td>$ulocation</td>
                        <td>$dnt</td>";

                    // Output booking status or action buttons
                    if ($status == 1) {
                        echo "<td colspan='2' class='red'>Declined</td>";
                    } else if ($status == 2) {
                        echo "<td colspan='2' class='green'>Approved</td>";
                    } else {
                        echo "<td>
                                <form action='booksA_D.php' method='post'>
                                    <input type='hidden' name='bid' value='$bid'>
                                    <button type='submit' name='approve'>Approve</button>
                                </form>
                            </td>
                            <td>
                                <form action='booksA_D.php' method='post'>
                                    <input type='hidden' name='bid' value='$bid'>
                                    <button type='submit' name='decline'>Decline</button>
                                </form>
                            </td>";
                    }
                    echo "</tr>";
                }
                // Close table and div tags after all bookings are displayed
                echo "</table></div>";
            } else {
                // No data found in the database
                echo "<tr><td colspan='6'>No Bookings</td></tr>";
            }
            ?>
    </div>
    <script>
    function handleCheckboxClick(clickedCheckbox) {
        var checkboxes = document.querySelectorAll('input[name="filter"]');
        checkboxes.forEach(function(checkbox) {
            if (checkbox !== clickedCheckbox) {
                checkbox.checked = false;
            }
        });

        filterBookings();
    }

    function filterBookings() {
    var checkedFilter = document.querySelector('input[name="filter"]:checked');
    var selectedStatus = checkedFilter ? checkedFilter.value : null;

    var rows = document.getElementsByClassName('booking-row');
    var noBookingsRow = document.getElementById('noBookingsRow'); // Get the "No bookings found" row

    var foundBookings = false; // Flag to track if any bookings were found

    for (var i = 0; i < rows.length; i++) {
        var status = rows[i].classList[1].split('-')[1];
        if (selectedStatus === null || selectedStatus === status) {
            rows[i].style.display = 'table-row';
            foundBookings = true; // Set the flag to true if at least one booking matches the filter
        } else {
            rows[i].style.display = 'none';
        }
    }

    // Display or hide the "No bookings found" message based on the flag and filter selection
    if (!foundBookings && selectedStatus !== null) { // No bookings found and filter selected
        if (!noBookingsRow) { // If the message row doesn't exist, create it
            noBookingsRow = document.createElement('tr');
            noBookingsRow.id = 'noBookingsRow'; // Set the ID for future reference
            var noBookingsCell = document.createElement('td');
            noBookingsCell.colSpan = "6"; // Span across all columns
            noBookingsCell.textContent = "No bookings found.";
            noBookingsRow.appendChild(noBookingsCell);
            var bookingsTable = document.getElementById('bookingsTable');
            bookingsTable.appendChild(noBookingsRow);
        }
    } else { // Bookings found or no filter selected
        if (noBookingsRow) { // If the message row exists, remove it
            noBookingsRow.parentNode.removeChild(noBookingsRow);
        }
    }
}
    function back() {
        window.location.href = 'Wprofile.php';
    }

    function signout() {
        window.location.href = 'signout.php';
    }
</script>

</body>

</html>
