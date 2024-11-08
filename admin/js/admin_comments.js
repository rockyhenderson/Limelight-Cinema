let allComments = [];

function initializeComments() {
  // Store the original comments when the page loads
  const commentsContainer = document.getElementById("commentBody");
  allComments = Array.from(commentsContainer.querySelectorAll(".comment"));
}

function filterComments() {
  // Get filter and sort inputs
  const userFilter = document
    .getElementById("filterByUser")
    .value.toLowerCase();
  const movieFilter = document
    .getElementById("filterByMovie")
    .value.toLowerCase();
  const sortOption = document.getElementById("sortOption").value;

  // If both filters are empty, reset to all comments
  if (!userFilter && !movieFilter) {
    console.log("Both filters are empty, displaying all comments");
    displayComments(allComments, sortOption);
    return;
  }

  // Filter comments based on user and movie inputs
  let filteredComments = allComments.filter((comment) => {
    const username =
      comment
        .querySelector(".comment-meta strong:first-of-type")
        ?.textContent.toLowerCase() || "";
    const movieTitle =
      comment
        .querySelector(".comment-meta strong:last-of-type")
        ?.textContent.toLowerCase() || "";

    // Determine if the comment matches the filter criteria
    const userMatch = !userFilter || username.includes(userFilter);
    const movieMatch = !movieFilter || movieTitle.includes(movieFilter);

    return userMatch && movieMatch;
  });

  // Debugging: Log the filtered comments
  console.log(`Number of comments after filtering: ${filteredComments.length}`);

  // Display the filtered and sorted comments
  displayComments(filteredComments, sortOption);
}

// Helper function to sort and display comments
function displayComments(comments, sortOption) {
  // Sort the comments based on the selected sort option
  if (sortOption === "date") {
    comments.sort((a, b) => {
      // Use the data-date attribute for consistent date parsing
      const dateA = new Date(a.getAttribute("data-date"));
      const dateB = new Date(b.getAttribute("data-date"));
      return dateB - dateA; // Newest first
    });
  } else if (sortOption === "movie") {
    comments.sort((a, b) => {
      const movieA = a.querySelector(
        ".comment-meta strong:last-of-type"
      ).textContent;
      const movieB = b.querySelector(
        ".comment-meta strong:last-of-type"
      ).textContent;
      return movieA.localeCompare(movieB);
    });
  } else if (sortOption === "user") {
    comments.sort((a, b) => {
      const userA = a.querySelector(
        ".comment-meta strong:first-of-type"
      ).textContent;
      const userB = b.querySelector(
        ".comment-meta strong:first-of-type"
      ).textContent;
      return userA.localeCompare(userB);
    });
  }

  // Clear the comments container and append the filtered/sorted comments
  const commentsContainer = document.getElementById("commentBody");
  commentsContainer.innerHTML = "";
  comments.forEach((comment) => {
    commentsContainer.appendChild(comment);
  });
}

// Attach the filterComments function to input and select change events
document.addEventListener("DOMContentLoaded", () => {
    // Initialize comments and set up listeners once the DOM is loaded
    initializeComments();
    document
      .getElementById("filterByUser")
      .addEventListener("input", filterComments);
    document
      .getElementById("filterByMovie")
      .addEventListener("input", filterComments);
    document
      .getElementById("sortOption")
      .addEventListener("change", filterComments);
  
    // Add event listener for modal opening (delegation approach)
    document.getElementById("commentBody").addEventListener("click", function (event) {
      if (event.target && event.target.classList.contains("view-details")) {
        // Find the parent comment element
        const commentElement = event.target.closest(".comment");
  
        // Extract comment text, meta information, and the comment ID
        const commentText = commentElement.querySelector(".comment-text").textContent;
        const commentMeta = commentElement.querySelector(".comment-meta").innerHTML;
        const commentId = commentElement.getAttribute("data-id");
  
        // Open the modal with the comment details and set the comment ID
        openModal(commentText, commentMeta, commentId);
      }
    });
  });
  

// Function to open the modal with the comment details
function openModal(commentText, commentMeta, commentId) {
  // Find the modal elements
  const modal = document.getElementById("commentModal");
  const modalCommentText = document.getElementById("modalCommentText");
  const modalCommentMeta = document.getElementById("modalCommentMeta");

  // Check if the modal elements are available
  if (!modal) {
    console.error("Modal element not found. Please check the ID: commentModal");
    return; // Exit if modal element is not found
  }
  if (!modalCommentText) {
    console.error(
      "Modal comment text element not found. Please check the ID: modalCommentText"
    );
    return; // Exit if modal comment text element is not found
  }
  if (!modalCommentMeta) {
    console.error(
      "Modal comment meta element not found. Please check the ID: modalCommentMeta"
    );
    return; // Exit if modal comment meta element is not found
  }

  // Set the content of the modal
  try {
    modalCommentText.textContent = commentText;
    modalCommentMeta.innerHTML = commentMeta; // Use innerHTML to maintain formatting
  } catch (e) {
    console.error("Error setting modal content:", e);
  }

  // Set the comment ID in the modal to use for deletion if needed
  if (commentId) {
    modal.setAttribute("data-comment-id", commentId);
  }

  // Display the modal
  modal.style.display = "block";

  // Add a slight delay to avoid rendering issues (sometimes helps with DOM not showing properly)
  setTimeout(() => {
    modal.style.opacity = "1";
    modal.style.transition = "opacity 0.2s ease-in-out";
  }, 50);
}

// Function to close the modal
function closeModal() {
  const modal = document.getElementById("commentModal");
  modal.style.display = "none";
}

// Event listener to close modal when clicking outside of it
window.onclick = function (event) {
  const modal = document.getElementById("commentModal");
  if (event.target == modal) {
    closeModal();
  }
};

// Function to delete the comment
function deleteComment() {
  const modal = document.getElementById("commentModal");
  const commentElement = document.querySelector(
    '.comment[data-id="' + modal.getAttribute("data-comment-id") + '"]'
  );

  if (confirm("Are you sure you want to delete this comment?")) {
    const commentId = commentElement.getAttribute("data-id");

    // Make a request to the backend to delete the comment
    fetch("http://webdev.edinburghcollege.ac.uk/~HNCWEBMR10/year%20two/semester%201/limelightcinema/Limelight-Cinema-/admin/admin_actions/delete_comment.php", {
      method: "POST",
      headers: {
        "Content-Type": "application/json",
      },
      body: JSON.stringify({ comment_id: commentId }),
    })
      .then((response) => response.json())
      .then((data) => {
        if (data.success) {
          alert("Comment deleted!");
          commentElement.remove(); // Remove the comment from the page
          closeModal(); // Close the modal
        } else {
          alert("Error deleting comment: " + data.error);
        }
      })
      .catch((error) => {
        console.error("Error:", error);
        alert("An error occurred while deleting the comment.");
      });
  }
}
