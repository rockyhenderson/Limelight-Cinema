// THIS WORKS PLEASE TO NOT TOUCH THIS !!!!!!!!!!!!!



// Initialize all comments on the page and store them in a global array.
function initializeComments() {
  const commentsContainer = document.getElementById("commentBody");
  allComments = Array.from(commentsContainer.querySelectorAll(".comment"));
}

// Filter comments based on user and movie inputs and then display the filtered results.
function filterComments() {
  const userFilter = document
    .getElementById("filterByUser")
    .value.toLowerCase();
  const movieFilter = document
    .getElementById("filterByMovie")
    .value.toLowerCase();
  const sortOption = document.getElementById("sortOption").value;

  if (!userFilter && !movieFilter) {
    console.log("Both filters are empty, displaying all comments");
    displayComments(allComments, sortOption);
    return;
  }

  let filteredComments = allComments.filter((comment) => {
    const username =
      comment
        .querySelector(".comment-meta strong:first-of-type")
        ?.textContent.toLowerCase() || "";
    const movieTitle =
      comment
        .querySelector(".comment-meta strong:last-of-type")
        ?.textContent.toLowerCase() || "";

    const userMatch = !userFilter || username.includes(userFilter);
    const movieMatch = !movieFilter || movieTitle.includes(movieFilter);

    return userMatch && movieMatch;
  });

  console.log(`Number of comments after filtering: ${filteredComments.length}`);

  displayComments(filteredComments, sortOption);
}

// Display the given array of comments, sorting them based on the selected sort option.
function displayComments(comments, sortOption) {
  if (sortOption === "date") {
    comments.sort((a, b) => {
      const dateA = new Date(a.getAttribute("data-date"));
      const dateB = new Date(b.getAttribute("data-date"));
      return dateB - dateA;
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

  const commentsContainer = document.getElementById("commentBody");
  commentsContainer.innerHTML = "";
  comments.forEach((comment) => {
    commentsContainer.appendChild(comment);
  });
}

// Initialize event listeners after the DOM content is fully loaded.
document.addEventListener("DOMContentLoaded", () => {
  console.log("DOM fully loaded and parsed.");

  initializeComments();

  const filterByUser = document.getElementById("filterByUser");
  const filterByMovie = document.getElementById("filterByMovie");
  const sortOption = document.getElementById("sortOption");

  if (filterByUser && filterByMovie && sortOption) {
    filterByUser.addEventListener("input", filterComments);
    filterByMovie.addEventListener("input", filterComments);
    sortOption.addEventListener("change", filterComments);
  } else {
    console.error("Filter or sort elements not found.");
  }

  const commentBody = document.getElementById("commentBody");
  if (commentBody) {
    commentBody.addEventListener("click", function (event) {
      if (event.target && event.target.classList.contains("view-details")) {
        const commentElement = event.target.closest(".comment");
        if (!commentElement) {
          console.error("Parent comment element not found.");
          return;
        }

        const commentText =
          commentElement.querySelector(".comment-text").textContent;
        const commentMeta =
          commentElement.querySelector(".comment-meta").innerHTML;
        const commentId = commentElement.getAttribute("data-id");

        console.log("Opening modal for comment ID:", commentId);
        openModal(commentText, commentMeta, commentId);
      }
    });
  } else {
    console.error("Comment body not found.");
  }

  const modalDeleteButton = document.getElementById("modalDeleteButton");
  if (modalDeleteButton) {
    const newDeleteButton = modalDeleteButton.cloneNode(true);
    modalDeleteButton.parentNode.replaceChild(
      newDeleteButton,
      modalDeleteButton
    );

    newDeleteButton.addEventListener("click", () => {
      const modal = document.getElementById("commentModal");
      if (!modal) {
        console.error("Modal not found for deleting a comment.");
        return;
      }

      const commentId = modal.getAttribute("data-comment-id");

      if (commentId) {
        console.log("Attempting to delete comment with ID:", commentId);
        deleteComment(commentId);
      } else {
        console.error("No comment ID found in modal for deletion.");
      }
    });
  } else {
    console.error("Modal delete button not found.");
  }
});

// Delete a comment with the given comment ID by sending a POST request to the server.
function deleteComment(commentId) {
  console.log("Delete button clicked for comment ID:", commentId);

  const formData = new FormData();
  formData.append("comment_id", commentId);

  fetch(
    "https://webdev.edinburghcollege.ac.uk/~HNCWEBMR10/year%20two/semester%201/limelightcinema/Limelight-Cinema-/admin/admin_actions/delete_comment.php",
    {
      method: "POST",
      body: formData,
    }
  )
    .then((response) => response.text())
    .then((data) => {
      console.log("Server response:", data);

      if (data.includes("Comment deleted!")) {
        console.log(
          "Comment deleted successfully. Refreshing comments list..."
        );
        fetchComments();
      } else {
        console.log("Failed to delete comment");
      }
    })
    .catch((error) => {
      console.error("Error during delete request:", error);
    });
}

// Open the modal window with the given comment details and set its visibility.
function openModal(commentText, commentMeta, commentId) {
  const modal = document.getElementById("commentModal");
  const modalCommentText = document.getElementById("modalCommentText");
  const modalCommentMeta = document.getElementById("modalCommentMeta");

  if (!modal || !modalCommentText || !modalCommentMeta) {
    console.error("One or more modal elements not found.");
    return;
  }

  try {
    modalCommentText.textContent = commentText;
    modalCommentMeta.innerHTML = commentMeta;
    modal.setAttribute("data-comment-id", commentId);
    console.log("Modal set with comment ID:", commentId);
  } catch (e) {
    console.error("Error setting modal content:", e);
  }

  modal.style.display = "block";
  setTimeout(() => {
    modal.style.opacity = "1";
    modal.style.transition = "opacity 0.2s ease-in-out";
  }, 50);
}

// Close the modal window by setting its display property to none.
function closeModal() {
  const modal = document.getElementById("commentModal");
  modal.style.display = "none";
}

// Close the modal if the user clicks outside of it.
window.onclick = function (event) {
  const modal = document.getElementById("commentModal");
  if (event.target == modal) {
    closeModal();
  }
};

// Fetch the updated list of comments from the server and update the comments container.
function fetchComments() {
  console.log("Starting to fetch comments...");

  fetch(window.location.href, {
    method: "GET",
    headers: {
      "Content-Type": "text/html",
    },
  })
    .then((response) => {
      console.log("Received response from server...");

      // Check if response is okay
      if (!response.ok) {
        console.error(
          `Network response was not ok, status: ${response.status}`
        );
        throw new Error("Network response was not ok");
      }
      return response.text();
    })
    .then((data) => {
      console.log("Received HTML data from server.");

      const tempDiv = document.createElement("div");
      tempDiv.innerHTML = data;

      const newComments = tempDiv.querySelector("#commentBody");

      if (newComments) {
        console.log(
          "Fetched new comments successfully, updating the comment section..."
        );

        const commentsContainer = document.getElementById("commentBody");
        if (!commentsContainer) {
          console.error("Comment container not found in current document!");
          return;
        }

        commentsContainer.innerHTML = newComments.innerHTML;

        initializeComments();

        console.log("Comments updated successfully.");
      } else {
        console.error(
          "No new comments found in the fetched HTML. #commentBody not found in response."
        );
      }
    })
    .catch((error) => {
      console.error("Error while fetching comments:", error);
      alert(
        "An error occurred while fetching comments. Please try again later."
      );
    });
}
