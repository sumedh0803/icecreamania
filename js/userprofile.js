$(document).ready(function() {
  
    $.ajax({
        type:"POST",
        url:"edituserprofile.php",
        data: { userid : userid },
        success: function (data){
            alert(data);
        },
        error: function (data){
            alert(data.message);
        }
    });
});