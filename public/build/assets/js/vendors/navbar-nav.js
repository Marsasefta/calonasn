document.addEventListener("DOMContentLoaded", function () {
  const currentURL = window.location.href; // Get the current URL
  const navLinks = document.querySelectorAll(".sidenav .nav-link"); // Select all navigation links
  const collapseItems = document.querySelectorAll(".nav-collapse"); // Select all collapsible nav items
  const sidenav = document.getElementById("sidenav");
  const toggleButton = document.querySelector('[data-bs-target="#sidenav"]');

  // Function to set active link and keep parent menu open
  function setActiveNavLink() {
    let activeLinkFound = false;

    navLinks.forEach((link) => {
      link.classList.remove("active");

      if (link.href === currentURL) {
        link.classList.add("active");
        activeLinkFound = true;

        // Store active link in localStorage
        localStorage.setItem("activeLink", link.href);

        // If the active link is inside a collapsed menu, open it
        const parentCollapse = link.closest(".collapse navbar-collapse .collapse");
        if (parentCollapse) {
          parentCollapse.classList.add("show"); // Add 'show' to keep it open
          const parentToggle = parentCollapse.previousElementSibling;
          if (parentToggle && parentToggle.hasAttribute("aria-expanded")) {
            parentToggle.setAttribute("aria-expanded", "true"); // Set aria-expanded to true
          }
        }

        // If the active link is inside a collapsible nav item, activate the parent link
        const navCollapse = link.closest(".nav-collapse");
        if (navCollapse) {
          const parentLink = navCollapse.querySelector(".nav-sub-link");
          if (parentLink) {
            parentLink.classList.add("active");
            const collapseElement = navCollapse.querySelector(" .collapse");
            if (collapseElement) {
              collapseElement.classList.add("show");
            }
            parentLink.setAttribute("aria-expanded", "true");
          }
        }
      }
    });

    // If no active link is found, clear the stored active link
    if (!activeLinkFound) {
      localStorage.removeItem("activeLink");
    }
  }

  // Retrieve the active link from localStorage
  const storedActiveLink = localStorage.getItem("activeLink");
  if (storedActiveLink) {
    navLinks.forEach((link) => {
      if (link.href === storedActiveLink) {
        link.classList.add("active");

        // If the active link is inside a collapsed menu, keep it open
        const parentCollapse = link.closest(".collapse navbar-collapse .collapse");
        if (parentCollapse) {
          parentCollapse.classList.add("show");
          const parentToggle = parentCollapse.previousElementSibling;
          if (parentToggle && parentToggle.hasAttribute("aria-expanded")) {
            parentToggle.setAttribute("aria-expanded", "true");
          }
        }

        // If the active link is inside a collapsible nav item, activate the parent link
        const navCollapse = link.closest(".nav-collapse");
        if (navCollapse) {
          const parentLink = navCollapse.querySelector(".nav-link");
          if (parentLink) {
            parentLink.classList.add("active");
            const collapseElement = navCollapse.querySelector(".collapse navbar-collapse .collapse");
            if (collapseElement) {
              collapseElement.classList.add("show");
            }
            parentLink.setAttribute("aria-expanded", "true");
          }
        }
      }
    });
  }

  // Function to ensure the parent of the active link stays open after toggling
  function maintainActiveLinkOnToggle() {
    setTimeout(function () {
      const isCollapsed = !sidenav.classList.contains("show"); // Check if the sidenav is collapsed
      if (isCollapsed) {
        // Ensure parent of active link stays open
        navLinks.forEach((link) => {
          if (link.classList.contains("active")) {
            const parentCollapse = link.closest(".collapse navbar-collapse .collapse");
            if (parentCollapse) {
              parentCollapse.classList.add("show");
              const parentToggle = parentCollapse.previousElementSibling;
              if (parentToggle && parentToggle.hasAttribute("aria-expanded")) {
                parentToggle.setAttribute("aria-expanded", "true");
              }
            }
          }
        });
      } else {
        setActiveNavLink(); // Reset active state when expanded
      }
    }, 300); // Timeout to allow the collapse animation to complete
  }

  // Listen for the collapse toggle event to maintain active link
  if (toggleButton) {
    toggleButton.addEventListener("click", maintainActiveLinkOnToggle);
  }

  // Initial setup on page load
  setActiveNavLink();
});
