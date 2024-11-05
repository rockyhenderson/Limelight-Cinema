<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Roboto:400,500&display=swap" />
  <script src="https://kit.fontawesome.com/b6b5f43622.js" crossorigin="anonymous"></script>
  <link rel="stylesheet" href="css/admin_styles.css">
  <title>Limelight Cinema Admin Panel</title>
</head>

<body>
  <?php include '../includes/db_connection.php'; ?>
  <div class="navbar">
    <h1>limelightcinemaADMIN</h1>
    <div class="tabs">
      <button class="tab-button" onclick="showTab('overview')">
        Overview
      </button>
      <button class="tab-button" onclick="showTab('movies')">Movies</button>
      <button class="tab-button" onclick="showTab('users')">Users</button>
      <button class="tab-button" onclick="showTab('comments')">
        Comments
      </button>
    </div>
  </div>

  <div class="content">
    <div id="overview" class="tab-content active">
      <h2>Overview</h2>
      <p>
        Lorem ipsum dolor sit amet, consectetur adipiscing elit. Vivamus
        tincidunt.
      </p>
    </div>
    <div id="movies" class="tab-content">
      <h2>Movies</h2>
      <p>
        Lorem ipsum dolor sit amet, consectetur adipiscing elit. Suspendisse
        egestas sapien.
      </p>
    </div>
    <div id="users" class="tab-content">
      <h2>Users</h2>
      <div class="user-database-filter">
        <h2>User Database</h2>
        <div class="user-controls">
          <div class="user-controls-wrapper">
            <input type="text" class="filter-input" id="user-filter" placeholder="Search users..."
              onkeyup="filterUsers('user-table', 'user-filter')" />
            <div class="dropdown">
              <button class="add-user-button">Filter</button>
              <div class="dropdown-content">
                <label>
                  <input type="checkbox" onclick="toggleUserColumnVisibility(0)" checked />
                  Username
                </label>
                <label>
                  <input type="checkbox" onclick="toggleUserColumnVisibility(1)" checked />
                  Email
                </label>
                <label>
                  <input type="checkbox" onclick="toggleUserColumnVisibility(3)" checked />
                  First Name
                </label>
                <label>
                  <input type="checkbox" onclick="toggleUserColumnVisibility(4)" checked />
                  Last Name
                </label>
                <label>
                  <input type="checkbox" onclick="toggleUserColumnVisibility(5)" checked />
                  DOB
                </label>
                <label>
                  <input type="checkbox" onclick="toggleUserColumnVisibility(6)" checked />
                  Date Registered
                </label>
              </div>
            </div>
          </div>
          <button class="add-user-button">Add New User</button>
        </div>
        <i>Click a header to sort</i>
        <div style="overflow-x: auto">
          <table class="user-table" id="user-table">
            <thead>
              <tr>
                <th>Edit</th>
                <th onclick="sortUserTable(0, this)" class="th-top">
                  <div class="th-wrapper">
                    Username
                    <i class="fa-solid fa-angle-up"></i>
                    <i class="fa-solid fa-angle-down"></i>
                  </div>
                </th>
                <th onclick="sortUserTable(1, this)" class="th-top">
                  <div class="th-wrapper">
                    Email
                    <i class="fa-solid fa-angle-up"></i>
                    <i class="fa-solid fa-angle-down"></i>
                  </div>
                </th>
                <th>Password</th>
                <th onclick="sortUserTable(3, this)" class="th-top">
                  <div class="th-wrapper">
                    First Name
                    <i class="fa-solid fa-angle-up"></i>
                    <i class="fa-solid fa-angle-down"></i>
                  </div>
                </th>
                <th onclick="sortUserTable(4, this)" class="th-top">
                  <div class="th-wrapper">
                    Last Name
                    <i class="fa-solid fa-angle-up"></i>
                    <i class="fa-solid fa-angle-down"></i>
                  </div>
                </th>
                <th onclick="sortUserTable(5, this)" class="th-top">
                  <div class="th-wrapper">
                    DOB
                    <i class="fa-solid fa-angle-up"></i>
                    <i class="fa-solid fa-angle-down"></i>
                  </div>
                </th>
                <th onclick="sortUserTable(6, this)" class="th-top">
                  <div class="th-wrapper">
                    Date Registered
                    <i class="fa-solid fa-angle-up"></i>
                    <i class="fa-solid fa-angle-down"></i>
                  </div>
                </th>
              </tr>
            </thead>
            <tbody>
              <?php
              $conn = connectDB();

              if (!$conn) {
                die("Connection failed: " . mysqli_connect_error());
              }

              $sql = "SELECT username, email, first_name, password, last_name, DOB, date_registered FROM users WHERE is_admin = 0";
              $result = $conn->query($sql);

              if (!$result) {
                die("Query failed: " . $conn->error);
              }

              if ($result->num_rows > 0) {
                while ($row = $result->fetch_assoc()) {
                  echo "<tr>";
                  echo "<td><i class='fa-solid fa-edit' onclick='editUser(this)'></i></td>";
                  echo "<td>" . htmlspecialchars($row['username']) . "</td>";
                  echo "<td>" . htmlspecialchars($row['email']) . "</td>";
                  echo "<td>";
                  echo "<div class='password-container'>";
                  echo "<span class='password'>********</span>";
                  echo "<i class='fa-solid fa-eye-slash' data-password='" . htmlspecialchars($row['password']) . "' onclick='togglePassword(this)'></i>";
                  echo "</div>";
                  echo "</td>";
                  echo "<td>" . htmlspecialchars($row['first_name']) . "</td>";
                  echo "<td>" . htmlspecialchars($row['last_name']) . "</td>";
                  echo "<td>" . htmlspecialchars($row['DOB']) . "</td>";
                  echo "<td>" . htmlspecialchars($row['date_registered']) . "</td>";
                  echo "</tr>";
                }
              } else {
                echo "<tr><td colspan='8'>No users found</td></tr>";
              }

              $conn->close();
              ?>

            </tbody>
          </table>
        </div>
      </div>
      <div class="admin-database-filter">
        <h2>Admin Database</h2>
        <div class="admin-controls">
          <div class="admin-controls-wrapper">
            <input type="text" class="filter-input" id="admin-filter" placeholder="Search Admins..."
              onkeyup="filterAdmins('admin-table', 'admin-filter')" />
            <div class="dropdown">
              <button class="add-admin-button">Filter</button>
              <div class="dropdown-content">
                <label>
                  <input type="checkbox" onclick="toggleAdminColumnVisibility(0)" checked />
                  Username
                </label>
                <label>
                  <input type="checkbox" onclick="toggleAdminColumnVisibility(1)" checked />
                  Email
                </label>
                <label>
                  <input type="checkbox" onclick="toggleAdminColumnVisibility(3)" checked />
                  First Name
                </label>
                <label>
                  <input type="checkbox" onclick="toggleAdminColumnVisibility(4)" checked />
                  Last Name
                </label>
                <label>
                  <input type="checkbox" onclick="toggleAdminColumnVisibility(5)" checked />
                  DOB
                </label>
                <label>
                  <input type="checkbox" onclick="toggleAdminColumnVisibility(6)" checked />
                  Date Registered
                </label>
              </div>
            </div>
          </div>
          <button class="add-admin-button">Add New Admin</button>
        </div>
        <i>Click a header to sort</i>
        <div style="overflow-x: auto">
          <table class="user-table" id="admin-table">
            <thead>
              <tr>
                <th onclick="sortAdminTable(0, this)" class="th-top">
                  <div class="th-wrapper">
                    Username
                    <i class="fa-solid fa-angle-up"></i>
                    <i class="fa-solid fa-angle-down"></i>
                  </div>
                </th>
                <th onclick="sortAdminTable(1, this)" class="th-top">
                  <div class="th-wrapper">
                    Email
                    <i class="fa-solid fa-angle-up"></i>
                    <i class="fa-solid fa-angle-down"></i>
                  </div>
                </th>
                <th>Password</th>
                <th onclick="sortAdminTable(3, this)" class="th-top">
                  <div class="th-wrapper">
                    First Name
                    <i class="fa-solid fa-angle-up"></i>
                    <i class="fa-solid fa-angle-down"></i>
                  </div>
                </th>
                <th onclick="sortAdminTable(4, this)" class="th-top">
                  <div class="th-wrapper">
                    Last Name
                    <i class="fa-solid fa-angle-up"></i>
                    <i class="fa-solid fa-angle-down"></i>
                  </div>
                </th>
                <th onclick="sortAdminTable(5, this)" class="th-top">
                  <div class="th-wrapper">
                    DOB
                    <i class="fa-solid fa-angle-up"></i>
                    <i class="fa-solid fa-angle-down"></i>
                  </div>
                </th>
                <th onclick="sortAdminTable(6, this)" class="th-top">
                  <div class="th-wrapper">
                    Date Registered
                    <i class="fa-solid fa-angle-up"></i>
                    <i class="fa-solid fa-angle-down"></i>
                  </div>
                </th>
              </tr>
            </thead>
            <tbody>
              <?php
              $conn = connectDB();

              if (!$conn) {
                die("Connection failed: " . mysqli_connect_error());
              }

              $sql = "SELECT username, email, password, first_name, last_name, DOB, date_registered FROM users WHERE is_admin = 1";
              $result = $conn->query($sql);

              if (!$result) {
                die("Query failed: " . $conn->error);
              }

              if ($result->num_rows > 0) {
                while ($row = $result->fetch_assoc()) {
                  echo "<tr>";
                  echo "<td>" . htmlspecialchars($row['username']) . "</td>";
                  echo "<td>" . htmlspecialchars($row['email']) . "</td>";
                  echo "<td>";
                  echo "<div class='password-container'>";
                  echo "<span class='password'>********</span>";
                  echo "<i class='fa-solid fa-eye-slash' data-password='" . htmlspecialchars($row['password']) . "' onclick='togglePassword(this)'></i>";
                  echo "</div>";
                  echo "</td>";

                  echo "<td>" . htmlspecialchars($row['first_name']) . "</td>";
                  echo "<td>" . htmlspecialchars($row['last_name']) . "</td>";
                  echo "<td>" . htmlspecialchars($row['DOB']) . "</td>";
                  echo "<td>" . htmlspecialchars($row['date_registered']) . "</td>";
                  echo "</tr>";
                }
              } else {
                echo "<tr><td colspan='8'>No users found</td></tr>";
              }

              $conn->close();
              ?>

            </tbody>
          </table>
        </div>
      </div>
    </div>
    <!-- Modal for Editing User -->
    <div id="edit-user-modal" class="modal">
      <div class="modal-content">
        <span class="close-button" onclick="closeEditUserModal()">&times;</span>
        <h2>Edit User</h2>
        <form id="edit-user-form">
          <label for="edit-username">Username:</label>
          <input type="text" id="edit-username" name="username" readonly /><br />

          <label for="edit-email">Email:</label>
          <input type="email" id="edit-email" name="email" /><br />

          <label for="edit-first-name">First Name:</label>
          <input type="text" id="edit-first-name" name="first_name" /><br />

          <label for="edit-last-name">Last Name:</label>
          <input type="text" id="edit-last-name" name="last_name" /><br />

          <label for="edit-dob">Date of Birth:</label>
          <input type="date" id="edit-dob" name="dob" /><br />

          <label for="edit-date-registered">Date Registered:</label>
          <input type="text" id="edit-date-registered" name="date_registered" readonly /><br />

          <div class="modal-buttons">
            <button type="button" class="save-button" onclick="saveUserChanges()">Save</button>
            <button type="button" class="delete-button" onclick="deleteUser()">Delete</button>
          </div>
        </form>
      </div>
    </div>

    <div id="comments" class="tab-content">
      <h2>Comments</h2>
      <p>
        Lorem ipsum dolor sit amet, consectetur adipiscing elit. Proin
        tristique turpis vel lectus fermentum tincidunt.
      </p>
    </div>
  </div>

  <script>
    let sortUserOrder = 1; // Start with ascending order by default for user table
    let sortAdminOrder = 1; // Start with ascending order by default for admin table
    function editUser(editIcon) {
      const row = editIcon.closest('tr');
      const cells = row.querySelectorAll('td');

      // Set the values in the modal from the table row
      document.getElementById('edit-username').value = cells[1].textContent.trim();
      document.getElementById('edit-email').value = cells[2].textContent.trim();
      document.getElementById('edit-first-name').value = cells[4].textContent.trim();
      document.getElementById('edit-last-name').value = cells[5].textContent.trim();
      document.getElementById('edit-dob').value = cells[6].textContent.trim();
      document.getElementById('edit-date-registered').value = cells[7].textContent.trim();

      // Show the modal
      document.getElementById('edit-user-modal').style.display = 'block';
    }

    function closeEditUserModal() {
      document.getElementById('edit-user-modal').style.display = 'none';
    }

    // Placeholder functions for Save and Delete
    function saveUserChanges() {
      // FILLER CODE HERE
      alert('Save user changes');
    }

    function deleteUser() {
      // FILLER CODE HERE
      alert('Delete user');
    }

    // Close modal if clicking outside of it
    window.onclick = function (event) {
      const modal = document.getElementById('edit-user-modal');
      if (event.target === modal) {
        modal.style.display = 'none';
      }
    }

    function togglePassword(iconElement) {
      const passwordContainer = iconElement.parentElement;
      const passwordSpan = passwordContainer.querySelector('.password');

      if (passwordSpan.textContent === '********') {
        // Reveal the password
        passwordSpan.textContent = iconElement.getAttribute('data-password');
        iconElement.classList.remove('fa-eye-slash');
        iconElement.classList.add('fa-eye');
      } else {
        // Hide the password
        passwordSpan.textContent = '********';
        iconElement.classList.remove('fa-eye');
        iconElement.classList.add('fa-eye-slash');
      }
    }

    function sortTable(tableId, columnIndex, thElement, orderVariable) {
      const table = document.querySelector(`#${tableId} tbody`);

      if (!table) {
        console.error(`Table body not found for table ID: ${tableId}`);
        return; // Exit if no table is found
      }

      const rows = Array.from(table.rows);

      if (rows.length === 0) {
        console.error(`No rows found in table with ID: ${tableId}`);
        return; // Exit if no rows are found
      }

      // Determine the number of columns based on the table type (user vs admin)
      const columnCount = tableId === "user-table" ? 8 : 6; // User table has 8 columns, Admin table has 6 columns

      // Ensure the column index being used is within bounds
      if (columnIndex < 0 || columnIndex >= columnCount) {
        console.error(`Invalid column index: ${columnIndex} for table ID: ${tableId}`);
        return; // Exit if the columnIndex is out of bounds
      }

      // Debug: Log the rows before sorting
      console.log(`Sorting rows for table ${tableId} by column ${columnIndex}:`);
      rows.forEach((row, index) => {
        console.log(`Row ${index} values:`);
        Array.from(row.cells).forEach((cell, idx) => {
          console.log(`Column ${idx}: "${cell.textContent.trim()}"`);
        });
      });

      rows.sort((a, b) => {
        // Fetch the values from the correct cells using the provided columnIndex
        const cellA = a.cells[columnIndex]?.textContent.trim() || "";
        const cellB = b.cells[columnIndex]?.textContent.trim() || "";

        console.log(`Comparing "${cellA}" to "${cellB}"`);

        // Handle different data types for sorting
        if (Date.parse(cellA) && Date.parse(cellB)) {
          return orderVariable * (new Date(cellA) - new Date(cellB));
        } else if (!isNaN(cellA) && !isNaN(cellB)) {
          return orderVariable * (parseFloat(cellA) - parseFloat(cellB));
        } else {
          return orderVariable * cellA.localeCompare(cellB, undefined, { sensitivity: 'base' });
        }
      });

      console.log("Rows after sorting:", rows.map(row => row.cells[columnIndex]?.textContent.trim()));

      rows.forEach(row => table.appendChild(row));

      // Update UI to reflect sorting direction and active column
      document.querySelectorAll(`#${tableId} th.th-top`).forEach(th => {
        th.classList.remove("sort-asc", "sort-desc");
        th.style.backgroundColor = "";
      });

      thElement.classList.add(orderVariable === 1 ? "sort-asc" : "sort-desc");
      thElement.style.backgroundColor = "#6A0DAD";

      // Flip the sorting order for the next click
      if (tableId === "user-table") {
        sortUserOrder *= -1;
      } else if (tableId === "admin-table") {
        sortAdminOrder *= -1;
      }
    }

    // Example usage for the "Username" column in HTML
    function sortUserTable(columnIndex, thElement) {
      // Adjust index to account for skipping the "Edit" column (which is at index 0)
      const adjustedIndex = columnIndex + 1; // Skip the "Edit" column
      sortTable("user-table", adjustedIndex, thElement, sortUserOrder);
    }

    function sortAdminTable(columnIndex, thElement) {
      // Directly use the provided column index, as there is no non-sortable "Edit" column in the admin table
      sortTable("admin-table", columnIndex, thElement, sortAdminOrder);
    }


    function toggleUserColumnVisibility(columnIndex) {
      const adjustedIndex = columnIndex + 1;

      const th = document.querySelectorAll("#user-table th")[adjustedIndex];
      const td = document.querySelectorAll(
        `#user-table tbody tr td:nth-child(${adjustedIndex + 1})`
      );

      if (th.style.display === "none") {
        th.style.display = "";
        td.forEach((cell) => (cell.style.display = ""));
      } else {
        th.style.display = "none";
        td.forEach((cell) => (cell.style.display = "none"));
      }
    }

    function toggleAdminColumnVisibility(columnIndex) {
      const adjustedIndex = columnIndex + 1;

      const th = document.querySelectorAll("#admin-table th")[adjustedIndex];
      const td = document.querySelectorAll(
        `#admin-table tbody tr td:nth-child(${adjustedIndex + 1})`
      );

      if (th.style.display === "none") {
        th.style.display = "";
        td.forEach((cell) => (cell.style.display = ""));
      } else {
        th.style.display = "none";
        td.forEach((cell) => (cell.style.display = "none"));
      }
    }

    function filterUsers(tableId, filterId) {
      const input = document.getElementById(filterId).value.toLowerCase();
      const rows = document.querySelectorAll(`#${tableId} tbody tr`);

      rows.forEach((row) => {
        const cells = row.querySelectorAll("td");
        let match = false;
        for (let i = 0; i < cells.length; i++) {
          if (i === 2) continue; // Skip the password column
          if (cells[i].textContent.toLowerCase().includes(input)) {
            match = true;
            break;
          }
        }
        row.style.display = match ? "" : "none";
      });
    }
    function showTab(tabId) {
      const tabContents = document.querySelectorAll(".tab-content");
      const tabButtons = document.querySelectorAll(".tab-button");

      tabContents.forEach((tabContent) => {
        tabContent.classList.remove("active");
      });

      tabButtons.forEach((tabButton) => {
        tabButton.classList.remove("selected");
      });

      document.getElementById(tabId).classList.add("active");
      document
        .querySelector(`[onclick="showTab('${tabId}')"]`)
        .classList.add("selected");
    }
    function filterAdmins(tableId, filterId) {
      const input = document.getElementById(filterId).value.toLowerCase();
      const rows = document.querySelectorAll(`#${tableId} tbody tr`);

      rows.forEach((row) => {
        const cells = row.querySelectorAll("td");
        let match = false;
        for (let i = 0; i < cells.length; i++) {
          if (i === 2) continue; // Skip the password column
          if (cells[i].textContent.toLowerCase().includes(input)) {
            match = true;
            break;
          }
        }
        row.style.display = match ? "" : "none";
      });
    }
  </script>
</body>

</html>