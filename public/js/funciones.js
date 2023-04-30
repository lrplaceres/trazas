$(document).ready(function () {
  const tooltipTriggerList = document.querySelectorAll(
    '[data-bs-toggle="tooltip"]'
  );
  const tooltipList = [...tooltipTriggerList].map(
    (tooltipTriggerEl) => new bootstrap.Tooltip(tooltipTriggerEl)
  );

  const offcanvasElementList = document.querySelectorAll(".offcanvas");
  const offcanvasList = [...offcanvasElementList].map(
    (offcanvasEl) => new bootstrap.Offcanvas(offcanvasEl)
  );

  $(".traza-mes-year-user").click(function () {
    link = $(this).attr("href");
    $.get(link, function (data, status) {
      $("#offcanvas-body").html(data);
    });
  });

  $(".traza-mes-year-by-user").click(function (e) {
    e.preventDefault();
    link = $(this).attr("href");
    $.get(link, function (data, status) {
      $("#traza-mes-year-by-user").html(data);
    });
  });
});
