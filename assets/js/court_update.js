$(document).ready(function() {
  $("#court").change(function() {
    var category = $(this).val();
    var post_id = "cid=" + category;

    $.ajax({
      type: "POST",
      url: "php/jquery/get_court_by_court_id.php",
      data: post_id,
      success: function(result) {
		autologout(result);
        $("#txtHint").html(result);
        $("#hide").show();
      }
    });
  });

  $("#delete_court").click(function() {
    var category = $("#court").val();
    var post_id = "court_id=" + category;
    if (confirm("Είσται σίγουρος;")) {
      $.ajax({
        type: "POST",
        url: "php/delete/delete_court.php",
        data: post_id,
        success: function(result) {
		  autologout(result);
		  location.reload();
        }
      });
    }
  });

  $("#hide").hide();
});
