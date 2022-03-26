document.addEventListener("DOMContentLoaded", function (event) {
  const showNavbar = (toggleId, navId, bodyId) => {
    const toggle = document.getElementById(toggleId),
      nav = document.getElementById(navId),
      bodypd = document.getElementById(bodyId)

    // Validate that all variables exist
    if (toggle && nav && bodypd) {
      toggle.addEventListener("click", () => {
        // show navbar
        nav.classList.toggle("show-nav");
        // change icon
        $('#header-toggle').toggleClass("bx-menu-alt-left bx-left-arrow-alt");
        // add padding to body
        bodypd.classList.toggle("body-pd");
      });
    }
  };

  showNavbar("header-toggle", "nav-bar", "body-pd");
});

// Navbar shadow
window.addEventListener("scroll", (e) => {
  const nav = document.querySelector(".header");
  if (window.pageYOffset > 0) {
    nav.classList.add("add-shadow");
  } else {
    nav.classList.remove("add-shadow");
  }
});

// Tooltip
var tooltipTriggerList = [].slice.call(
  document.querySelectorAll('[data-bs-toggle="tooltip"]')
);
var tooltipList = tooltipTriggerList.map(function (tooltipTriggerEl) {
  return new bootstrap.Tooltip(tooltipTriggerEl);
});

// Date picker
// let today = new Date().toISOString().substr(0, 10);
// document.querySelector("#datepicker").value = today;

// Modal
var myModal = document.getElementById("myModal");
var myInput = document.getElementById("myInput");

// Disable forms
// $("form").attr("autocomplete", "off");

// Bootstrap modal
myModal.addEventListener("shown.bs.modal", function () {
  myInput.focus();
});
