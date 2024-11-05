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
            <input type="text" class="filter-input" placeholder="Search users..." onkeyup="filterUsers()" />
            <div class="dropdown">
              <button class="add-user-button">Filter</button>
              <div class="dropdown-content">
                <label>
                  <input type="checkbox" onclick="toggleColumnVisibility(0)" checked />
                  Username
                </label>
                <label>
                  <input type="checkbox" onclick="toggleColumnVisibility(1)" checked />
                  Email
                </label>
                <label>
                  <input type="checkbox" onclick="toggleColumnVisibility(3)" checked />
                  First Name
                </label>
                <label>
                  <input type="checkbox" onclick="toggleColumnVisibility(4)" checked />
                  Last Name
                </label>
                <label>
                  <input type="checkbox" onclick="toggleColumnVisibility(5)" checked />
                  DOB
                </label>
                <label>
                  <input type="checkbox" onclick="toggleColumnVisibility(6)" checked />
                  Date Registered
                </label>
              </div>
            </div>
          </div>
          <button class="add-user-button">Add New User</button>
        </div>
        <i>Click a header to sort</i>
        <div style="overflow-x: auto">
          <table class="user-table">
            <thead>
              <tr>
                <th>Edit</th>
                <th onclick="sortTable(0, this)" class="th-top">
                  <div class="th-wrapper">
                    Username
                    <i class="fa-solid fa-angle-up"></i>
                    <i class="fa-solid fa-angle-down"></i>
                  </div>
                </th>
                <th onclick="sortTable(1, this)" class="th-top">
                  <div class="th-wrapper">
                    Email
                    <i class="fa-solid fa-angle-up"></i>
                    <i class="fa-solid fa-angle-down"></i>
                  </div>
                </th>
                <th>Password</th>
                <th onclick="sortTable(3, this)" class="th-top">
                  <div class="th-wrapper">
                    First Name
                    <i class="fa-solid fa-angle-up"></i>
                    <i class="fa-solid fa-angle-down"></i>
                  </div>
                </th>
                <th onclick="sortTable(4, this)" class="th-top">
                  <div class="th-wrapper">
                    Last Name
                    <i class="fa-solid fa-angle-up"></i>
                    <i class="fa-solid fa-angle-down"></i>
                  </div>
                </th>
                <th onclick="sortTable(5, this)" class="th-top">
                  <div class="th-wrapper">
                    DOB
                    <i class="fa-solid fa-angle-up"></i>
                    <i class="fa-solid fa-angle-down"></i>
                  </div>
                </th>
                <th onclick="sortTable(6, this)" class="th-top">
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

              $sql = "SELECT username, email, password, first_name, last_name, DOB, date_registered FROM users";
              $result = $conn->query($sql);

              if (!$result) {
                die("Query failed: " . $conn->error);
              }

              if ($result->num_rows > 0) {
                while ($row = $result->fetch_assoc()) {
                  echo "<tr>";
                  echo "<td><i class='fa-solid fa-edit' onclick='editUser()'></i></td>";
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

    <div id="comments" class="tab-content">
      <h2>Comments</h2>
      <p>
        Lorem ipsum dolor sit amet, consectetur adipiscing elit. Proin
        tristique turpis vel lectus fermentum tincidunt.
      </p>
    </div>
  </div>

  <script>
    let sortOrder = 1; // Start with ascending order by default

    function sortTable(columnIndex, thElement) {
      const table = document.querySelector(".user-table tbody");
      const rows = Array.from(table.rows);

      rows.sort((a, b) => {
        const cellA = a.cells[columnIndex].textContent.trim();
        const cellB = b.cells[columnIndex].textContent.trim();

        if (columnIndex === 5 || columnIndex === 6) {
          return sortOrder * (new Date(cellA) - new Date(cellB));
        }
        return (
          sortOrder * cellA.localeCompare(cellB, undefined, { numeric: true })
        );
      });

      rows.forEach((row) => table.appendChild(row));

      // Update sorting icons
      document.querySelectorAll("th.th-top").forEach((th) => {
        th.classList.remove("sort-asc", "sort-desc");
        th.style.backgroundColor = "";
      });
      thElement.classList.add(sortOrder === 1 ? "sort-asc" : "sort-desc");
      thElement.style.backgroundColor = "#6A0DAD";

      // Toggle sort order for the next click
      sortOrder *= -1;
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

    function togglePassword(element) {
      const passwordSpan = element.previousElementSibling;
      const currentPassword = element.dataset.password;

      if (passwordSpan.textContent === "********") {
        passwordSpan.textContent = currentPassword;
        element.classList.remove("fa-eye-slash");
        element.classList.add("fa-eye");
      } else {
        passwordSpan.textContent = "********";
        element.classList.remove("fa-eye");
        element.classList.add("fa-eye-slash");
      }
    }
    function toggleColumnVisibility(columnIndex) {
      // Adjust columnIndex to skip the first column (edit button)
      const adjustedIndex = columnIndex + 1;

      const th = document.querySelectorAll(".user-table th")[adjustedIndex];
      const td = document.querySelectorAll(
        `.user-table tbody tr td:nth-child(${adjustedIndex + 1})`
      );

      if (th.style.display === "none") {
        th.style.display = "";
        td.forEach((cell) => (cell.style.display = ""));
      } else {
        th.style.display = "none";
        td.forEach((cell) => (cell.style.display = "none"));
      }
    }

    function filterUsers() {
      const input = document
        .querySelector(".filter-input")
        .value.toLowerCase();
      const rows = document.querySelectorAll(".user-table tbody tr");

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
    function editUser() {
      alert("Test");
    }
  </script>
</body>

</html>