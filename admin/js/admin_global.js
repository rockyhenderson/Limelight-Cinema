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
function toggleNav() {
  const navbar = document.querySelectorAll(".navbar");
  navbar.forEach(element => {
    if (element.classList.contains("navOpen")) {
      element.classList.remove("navOpen");
      element.classList.add("navClosed");
    } else if (element.classList.contains("navClosed")) {
      element.classList.remove("navClosed");
      element.classList.add("navOpen");
    } else {
      // If neither class is present, add "navOpen" as the default state
      element.classList.add("navOpen");
    }
  });
}

function removeNavClassesOnDesktopResize() {
  const navbar = document.querySelectorAll(".navbar");

  if (window.innerWidth >= 992) { // Example desktop breakpoint (1024px and wider)
    navbar.forEach(element => {
      element.classList.remove("navOpen", "navClosed");
    });
  }
}

window.addEventListener("resize", removeNavClassesOnDesktopResize);