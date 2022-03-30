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

// Toggle password
// $('.toggle-password').click(function(){
//   $(this).children().toggleClass('fa-eye fa-eye-slash');
//   let input = $(this).prev();
//   input.attr('type', input.attr('type') === 'password' ? 'text' : 'password');
// });

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

// Bootstrap Modal
// var myModal = document.getElementById("myModal");
// var myInput = document.getElementById("myInput");
// myModal.addEventListener("shown.bs.modal", function () {
//   myInput.focus();
// });

// Disable forms
$("form").attr("autocomplete", "off");


