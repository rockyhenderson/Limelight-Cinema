<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Roboto:400,500&display=swap" />
  <script src="https://kit.fontawesome.com/b6b5f43622.js" crossorigin="anonymous"></script>
  <link rel="stylesheet" href="css/global_styles.css">
  <link rel="stylesheet" href="css/admin_user_styles.css">
  <link rel="stylesheet" href="css/admin_movie_styles.css">
  <link rel="stylesheet" href="css/admin_comments_styles.css">
  <title>Limelight Cinema Admin Panel</title>
</head>

<body>
  <?php
  include '../includes/db_connection.php';
  ?>

  <i class="fa-solid fa-burger fa-xl burger" onclick="toggleNav()"></i>
  <div class="navbar">
    <div class="nav-top-content">
      <h1>Limelight<wbr>cinema<wbr>ADMIN</h1>
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
      <script src="js/admin_global.js"></script>
    </div>
    <div class="nav-bottom-content">
      <div class="profile-photo" style="margin:0;"></div>
      <div class="navbar-bottom-text">
        <i style="margin-top:5px;">Welcome back<br /></i>
        <h3 style="margin-top:0;">Username</h3>
      </div>
    </div>
  </div>
  <div class="debug-box" style="
        width: 50px;
        height: 50px;
        position: absolute;
        top: 0;
        left: 50%;
        transform: translateX(-50%);
        z-index: 9999;"></div>
  <div class="content">
    <div id="overview" class="tab-content active">
      <h1>Overview</h1>
      <p>
        Snapshot of Key Metrics:
        Display a few key numbers like total users, total movies, and total bookings.
        Perhaps a simple bar or pie chart showing ticket sales per day or per movie (if you think this fits within your
        simplified scope).<br /><br />

        Recent Activity Feed:
        A list showing recent comments, new user registrations, or movie additions, giving a quick view of what's new.
        Clicking on an item could take the admin directly to the related section.<br /><br />

        Quick Links or Actions:
        Provide buttons or links to the most common actions, such as "Add New Movie," "Manage Users," or "View
        Comments." This could streamline admin workflow by letting them jump right into frequently used
        tasks.<br /><br />

        System Alerts or Notifications:
        A small section for system updates or maintenance notifications, if you plan to add any alerts for things like
        low seat availability or movie listings close to fully booked.<br /><br />

        Search Bar or Filtered View:
        If there's a search function, having it right on the Overview might be convenient, especially for quick lookups
        of users or movies.<br /><br />
      </p>
    </div>
    <div id="movies" class="tab-content">
      <h1>Movies</h1>
      <div class="movie-content">
        <div class="filter-section">
          <!-- Search Bar -->
          <div class="search-bar">
            <input type="text" placeholder="Search for a movie..." id="movieSearch" />
            <button type="button">Search</button>
          </div>

          <!-- Genre Filter -->
          <div class="filter-dropdown">
            <label for="genreFilter">Genre:</label>
            <select id="genreFilter">
              <option value="all">All Genres</option>
              <option value="action">Action</option>
              <option value="comedy">Comedy</option>
              <option value="drama">Drama</option>
              <option value="fantasy">Fantasy</option>
              <!-- Add more genres as needed -->
            </select>
          </div>

          <!-- Age Rating Filter -->
          <div class="filter-dropdown">
            <label for="ageFilter">Age Rating:</label>
            <select id="ageFilter">
              <option value="all">All Ages</option>
              <option value="pg">PG</option>
              <option value="12">12+</option>
              <option value="15">15+</option>
              <option value="18">18+</option>
            </select>
          </div>

          <!-- Release Date Sort -->
          <div class="filter-dropdown">
            <label for="releaseSort">Sort by:</label>
            <select id="releaseSort">
              <option value="newest">Newest First</option>
              <option value="oldest">Oldest First</option>
            </select>
          </div>
          <div class="add-movie">
            <button class="add-movie-button">+ Add New Movie</button>
          </div>

        </div>
        <div class="movie-wrapper">
          <div class="movie-card" id="movie-1">
            <div class="poster-container">
              <img src="../public/src/filler_url.png" alt="The Enchanted Forest Poster" class="poster" />
              <div class="overlay-buttons">
                <button>Edit</button>
                <button>View Bookings</button>
              </div>
            </div>
            <div class="movie-info">
              <h3>The Enchanted Forest</h3>
            </div>
          </div>
        </div>
      </div>
    </div>
    <div id="users" class="tab-content">
      <h1 style="padding-left:35px;">Users</h1>
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
            <div class="filter-controls-button-wrapper">
              <button class="add-user-button">Add New User</button>
            </div>
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

                ?>

              </tbody>
            </table>
          </div>
        </div>
      </div>
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
              <button type="button" class="delete-button" onclick="deleteUser()">Delete</button>
              <button type="button" class="save-button" onclick="saveUserChanges()">Save</button>
            </div>
          </form>
        </div>
      </div>
    </div>
    <!-- Modal for Editing User -->


    <div id="comments" class="tab-content">
      <div class="comment-header">
        <h1>Comments</h1>
        <div class="comments-filter">
          <input type="text" id="filterByUser" placeholder="Search by User" style="margin:0px;"
            oninput="filterComments()" />
          <input type="text" id="filterByMovie" placeholder="Search by Movie" style="margin:0px;"
            oninput="filterComments()" />
          <select id="sortOption" onchange="filterComments()">
            <option value="date">Sort by Date</option>
            <option value="movie">Sort by Movie</option>
            <option value="user">Sort by User</option>
          </select>
        </div>
      </div>
      <div class="comment-body-wrapper" id="commentBody">
        <?php
        // Example PHP code to display comments
        require_once '../includes/db_connection.php';

        $query = "SELECT comments.*, users.username, movies.title AS movie_title
                  FROM comments
                  JOIN users ON comments.user_id = users.id
                  JOIN movies ON comments.movie_id = movies.id
                  ORDER BY comment_date DESC";

        $result = mysqli_query($conn, $query);

        if (!$result) {
          echo "Error executing query: " . mysqli_error($conn);
        } else {
          if (mysqli_num_rows($result) > 0) {
            while ($row = mysqli_fetch_assoc($result)) {
              $commentText = htmlspecialchars($row['comment_text']);
              $commentMeta = "Posted by <strong>" . htmlspecialchars($row['username']) . "</strong> on <strong>" . htmlspecialchars($row['movie_title']) . "</strong> - " . htmlspecialchars($row['comment_date']);
              $commentDate = htmlspecialchars($row['comment_date']); // Assuming it's in a valid date format
              $commentId = htmlspecialchars($row['id']); // Assuming the comment ID is in the `id` column

              echo '
            <div class="comment" data-id="' . $commentId . '" data-date="' . $commentDate . '">
                <div class="profile-photo"></div>
                <div class="comment-details">
                    <p class="comment-text">"' . $commentText . '"</p>
                    <p class="comment-meta">' . $commentMeta . '</p>
                </div>
                <a href="javascript:void(0);" class="view-details">View Details</a>
            </div>
            ';
            }
          } else {
            echo '<p>No comments found.</p>';
          }
        }
        ?>



        <!-- Modal -->
        <div id="commentModal" class="modal">
          <div class="modal-content">
            <span class="close-button" onclick="closeModal()">&times;</span>
            <div class="modal-details">
              <h2>Comment Details</h2>
              <p id="modalCommentText"></p>
              <p id="modalCommentMeta"></p>
              <button class="delete-button" id="modalDeleteButton" onclick="deleteComment()">Delete Comment</button>
            </div>
          </div>
        </div>
      </div>



    </div>
  </div>
  </div>
  <script src="js/admin_user.js"></script>
  <script src="js/admin_comments.js"></script>
</body>

</html>