$(document).ready(function(){
    // Attach click event to each box
    $(".box").click(function(){
      // Hide all sections
      $(".section").hide();
      
      // Get the ID of the clicked box
      var boxID = $(this).attr("id");
      
      // Show the corresponding section
      $("#section" + boxID.slice(-1)).show();
    });
  });