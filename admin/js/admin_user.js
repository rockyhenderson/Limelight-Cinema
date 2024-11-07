let sortUserOrder = 1;
let sortAdminOrder = 1;

document.addEventListener("DOMContentLoaded", function () {
  const userBoxHeader = document.querySelector(".user-box-header-content");
  const userDatabaseContent = document.querySelector(".user-database-content");
  const arrowIcon = document.querySelector(".user-box-header-content .arrow");

  userBoxHeader.addEventListener("click", function () {
    if (userDatabaseContent.classList.contains("collapsed")) {
      // Remove collapsed state and add opened state
      userDatabaseContent.classList.remove("collapsed");
      userDatabaseContent.classList.add("opened");
      arrowIcon.classList.remove("collapsed");
    } else {
      // Remove opened state and add collapsed state
      userDatabaseContent.classList.remove("opened");
      userDatabaseContent.classList.add("collapsed");
      arrowIcon.classList.add("collapsed");
    }
  });
});
document.addEventListener("DOMContentLoaded", function () {
  const userBoxHeader = document.querySelector(".admin-box-header-content");
  const userDatabaseContent = document.querySelector(".admin-database-content");
  const arrowIcon = document.querySelector(".admin-box-header-content .arrow");

  userBoxHeader.addEventListener("click", function () {
    if (userDatabaseContent.classList.contains("collapsed")) {
      // Remove collapsed state and add opened state
      userDatabaseContent.classList.remove("collapsed");
      userDatabaseContent.classList.add("opened");
      arrowIcon.classList.remove("collapsed");
    } else {
      // Remove opened state and add collapsed state
      userDatabaseContent.classList.remove("opened");
      userDatabaseContent.classList.add("collapsed");
      arrowIcon.classList.add("collapsed");
    }
  });
});


function editUser(editIcon) {
  const row = editIcon.closest("tr");
  const cells = row.querySelectorAll("td");

  // Set the values in the modal from the table row
  document.getElementById("edit-username").value = cells[1].textContent.trim();
  document.getElementById("edit-email").value = cells[2].textContent.trim();
  document.getElementById("edit-first-name").value =
    cells[4].textContent.trim();
  document.getElementById("edit-last-name").value = cells[5].textContent.trim();
  document.getElementById("edit-dob").value = cells[6].textContent.trim();
  document.getElementById("edit-date-registered").value =
    cells[7].textContent.trim();

  // Show the modal
  document.getElementById("edit-user-modal").style.display = "block";
}
function closeEditUserModal() {
  document.getElementById("edit-user-modal").style.display = "none";
}
// JavaScript function to save user changes
function saveUserChanges() {
  // Make the fetch request
  fetch('http://webdev.edinburghcollege.ac.uk/~HNCWEBMR10/year%20two/semester%201/limelightcinema/Limelight-Cinema-/admin/admin_actions/update_user.php', {
    method: 'POST',
    headers: {
      'Content-Type': 'application/json',
    }
  })
    .then(response => response.text()) // Read the response as plain text
    .then(text => {
      // Log the entire response for easy visibility
      console.log('Response text:', text);
      alert('Response from PHP: ' + text);
    })
    .catch(error => {
      // Log any fetch errors to the console
      console.error('Fetch error:', error);
      alert('Fetch error: ' + error.message);
    });
}



function deleteUser() {
  const username = document.getElementById("edit-username").value.trim();

  if (confirm("Are you sure you want to delete this user?")) {
    fetch("../admin_actions/delete_user.php", {
      method: "POST",
      headers: {
        "Content-Type": "application/json",
      },
      body: JSON.stringify({
        username: username,
      }),
    })
      .then((response) => response.json())
      .then((data) => {
        if (data.success) {
          alert("User deleted successfully");
          location.reload(); // Reload the page to see the changes
        } else {
          alert("Failed to delete user: " + data.error);
        }
      })
      .catch((error) => {
        console.error("Error:", error);
      });
  }
}

window.onclick = function (event) {
  const modal = document.getElementById("edit-user-modal");
  if (event.target === modal) {
    modal.style.display = "none";
  }
};
function togglePassword(iconElement) {
  const passwordContainer = iconElement.parentElement;
  const passwordSpan = passwordContainer.querySelector(".password");

  if (passwordSpan.textContent === "********") {
    // Reveal the password
    passwordSpan.textContent = iconElement.getAttribute("data-password");
    iconElement.classList.remove("fa-eye-slash");
    iconElement.classList.add("fa-eye");
  } else {
    // Hide the password
    passwordSpan.textContent = "********";
    iconElement.classList.remove("fa-eye");
    iconElement.classList.add("fa-eye-slash");
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
    console.error(
      `Invalid column index: ${columnIndex} for table ID: ${tableId}`
    );
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
      return (
        orderVariable *
        cellA.localeCompare(cellB, undefined, { sensitivity: "base" })
      );
    }
  });

  console.log(
    "Rows after sorting:",
    rows.map((row) => row.cells[columnIndex]?.textContent.trim())
  );

  rows.forEach((row) => table.appendChild(row));

  // Update UI to reflect sorting direction and active column
  document.querySelectorAll(`#${tableId} th.th-top`).forEach((th) => {
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
