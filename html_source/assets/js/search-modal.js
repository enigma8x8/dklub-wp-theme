jQuery(document).ready(function ($) {
  // Search modal functionality
  $(".search-toggle").on("click", function (e) {
    e.preventDefault();
    $("#searchModal").modal("show");

    // Focus on search field when modal opens
    setTimeout(function () {
      $("#searchModal .search-field").focus();
    }, 500);
  });

  // Handle search form submission
  $("#searchModal .search-form").on("submit", function (e) {
    var searchQuery = $("#searchModal .search-field").val().trim();

    if (searchQuery === "") {
      e.preventDefault();
      alert("Lūdzu, ievadiet meklēšanas vaicājumu");
      return false;
    }

    // Close modal after submission
    $("#searchModal").modal("hide");
  });

  // Handle search button click
  $("#searchModal .search-submit").on("click", function (e) {
    e.preventDefault();
    $("#searchModal .search-form").submit();
  });

  // Handle Enter key in search field
  $("#searchModal .search-field").on("keypress", function (e) {
    if (e.which === 13) {
      // Enter key
      e.preventDefault();
      $("#searchModal .search-form").submit();
    }
  });

  // Close modal on escape key
  $(document).on("keydown", function (e) {
    if (e.key === "Escape" && $("#searchModal").hasClass("show")) {
      $("#searchModal").modal("hide");
    }
  });

  // Auto-focus search field when modal is shown
  $("#searchModal").on("shown.bs.modal", function () {
    $("#searchModal .search-field").focus();
  });

  // Clear search field when modal is hidden
  $("#searchModal").on("hidden.bs.modal", function () {
    $("#searchModal .search-field").val("");
  });
});
