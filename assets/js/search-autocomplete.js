jQuery(document).ready(function ($) {
  var searchTimeout;
  var $searchField = $("#searchModal .search-field");
  var $searchResults = $("#searchModal .search-results");

  // Create results container if it doesn't exist
  if ($searchResults.length === 0) {
    $searchField.after('<div class="search-results"></div>');
    $searchResults = $("#searchModal .search-results");
  }

  // Handle input changes
  $searchField.on("input", function () {
    var searchTerm = $(this).val().trim();

    // Clear previous timeout
    clearTimeout(searchTimeout);

    // Hide results if search term is too short
    if (searchTerm.length < 2) {
      $searchResults.hide().empty();
      return;
    }

    // Set timeout to avoid too many requests
    searchTimeout = setTimeout(function () {
      performSearch(searchTerm);
    }, 300);
  });

  // Perform AJAX search
  function performSearch(searchTerm) {
    $.ajax({
      url: search_ajax.ajax_url,
      type: "POST",
      data: {
        action: "search_autocomplete",
        search_term: searchTerm,
        nonce: search_ajax.nonce,
      },
      success: function (response) {
        displayResults(response, searchTerm);
      },
      error: function () {
        $searchResults.hide();
      },
    });
  }

  // Display search results
  function displayResults(results, searchTerm) {
    if (results.length === 0) {
      $searchResults.hide().empty();
      return;
    }

    var html = '<div class="search-results-list">';

    results.forEach(function (result) {
      html += '<div class="search-result-item" data-url="' + result.url + '">';

      if (result.type === "product") {
        html += '<div class="result-image">';
        if (result.image) {
          html += '<img src="' + result.image + '" alt="' + result.title + '">';
        } else {
          html += '<div class="no-image">📦</div>';
        }
        html += "</div>";
        html += '<div class="result-content">';
        html +=
          '<div class="result-title">' +
          highlightSearchTerm(result.title, searchTerm) +
          "</div>";
        if (result.price) {
          html += '<div class="result-price">' + result.price + "</div>";
        }
        html += '<div class="result-type">Produkts</div>';
        html += "</div>";
      } else if (result.type === "post") {
        html += '<div class="result-content">';
        html +=
          '<div class="result-title">' +
          highlightSearchTerm(result.title, searchTerm) +
          "</div>";
        if (result.excerpt) {
          html += '<div class="result-excerpt">' + result.excerpt + "</div>";
        }
        html += '<div class="result-type">Raksts</div>';
        html += "</div>";
      } else {
        html += '<div class="result-content">';
        html +=
          '<div class="result-title">' +
          highlightSearchTerm(result.title, searchTerm) +
          "</div>";
        html += '<div class="result-type">Lapa</div>';
        html += "</div>";
      }

      html += "</div>";
    });

    html += "</div>";
    $searchResults.html(html).show();
  }

  // Highlight search term in results
  function highlightSearchTerm(text, searchTerm) {
    var regex = new RegExp("(" + searchTerm + ")", "gi");
    return text.replace(regex, "<mark>$1</mark>");
  }

  // Handle result item clicks
  $(document).on("click", ".search-result-item", function () {
    var url = $(this).data("url");
    if (url) {
      window.location.href = url;
    }
  });

  // Hide results when clicking outside
  $(document).on("click", function (e) {
    if (
      !$(e.target).closest(
        "#searchModal .search-input-wrapper, #searchModal .search-results"
      ).length
    ) {
      $searchResults.hide();
    }
  });

  // Handle keyboard navigation
  $searchField.on("keydown", function (e) {
    var $visibleResults = $searchResults.find(".search-result-item:visible");

    if (e.key === "ArrowDown") {
      e.preventDefault();
      var $current = $visibleResults.filter(".selected");
      var $next = $current.next(".search-result-item");
      if ($next.length === 0) {
        $next = $visibleResults.first();
      }
      $current.removeClass("selected");
      $next.addClass("selected");
    } else if (e.key === "ArrowUp") {
      e.preventDefault();
      var $current = $visibleResults.filter(".selected");
      var $prev = $current.prev(".search-result-item");
      if ($prev.length === 0) {
        $prev = $visibleResults.last();
      }
      $current.removeClass("selected");
      $prev.addClass("selected");
    } else if (e.key === "Enter") {
      e.preventDefault();
      var $selected = $visibleResults.filter(".selected");
      if ($selected.length > 0) {
        var url = $selected.data("url");
        if (url) {
          window.location.href = url;
        }
      } else {
        // Submit form if no result is selected
        $("#searchModal .search-form").submit();
      }
    } else if (e.key === "Escape") {
      $searchResults.hide();
    }
  });

  // Clear results when modal is hidden
  $("#searchModal").on("hidden.bs.modal", function () {
    $searchResults.hide().empty();
    clearTimeout(searchTimeout);
  });
});
