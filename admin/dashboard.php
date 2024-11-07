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
      <h1 style="padding-left:35px;">Users</h1>
      <div>
        <div class="user-database-filter">
          <div class="user-box-header-content">
            <h2>User Database</h2>
            <span class="arrow">&#9660;</span>
          </div>
          <div class="user-database-content opened">
            <div class="user-controls">
              <div class="user-controls-wrapper">
                <input type="text" class="filter-input" id="user-filter" placeholder="Search users..."
                  onkeyup="filterUsers('user-table', 'user-filter')" style="color:black;" />
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
        </div>

        <div class="admin-database-filter">
          <div class="admin-box-header-content">
            <h2>Admin Database</h2>
            <span class="arrow">&#9660;</span>
          </div>
          <div class="admin-database-content opened">
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

    <script src="js/admin_user.js"></script>
</body>

</html>