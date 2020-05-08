$(document).ready(function (){

    if (username != "Guest")
    {
        if(usertype == "user")
        {
        
            $("#profile").on("click", function() {
                $(".signout").toggle();
            });

        }
        else if(usertype == "admin")
        {
            $("#profile").on("click", function() {
                $(".signout").toggle()
                $(".myprofile").hide();
            });
        }

    }
    
    //====Functions related to search bar===//
    //This ajax call populates the suggestion box with names containing the searchQuery
    $("#search-bar").on("keyup",function(){
        if($(this).val() == "")
            $(".clear").css("visibility","hidden");
        else
            $(".clear").css("visibility","visible");
        $(".sugg-box").show();
        var searchQuery = $(this).val();
        $.ajax({
            url: "searchResults.php",
            data: { searchQuery: searchQuery,
                    usertype: usertype},
            success: function(data){
                items = data.split(",")
                $(".sugg-box").empty();
                for(i = 0; i < items.length; i++)
                {
                    var li = document.createElement("li");
                    $(li).attr("id",i+1);
                    $(li).attr("class","search-item");
                    $(li).attr("onclick","search('"+items[i]+"')");
                    $(li).text(items[i]);
                    $(".sugg-box").append(li);
                }
            }
        });
    });
    $(".clear").on("click",function(){
        window.location = window.location.href;
    });

    $('.search').click(function(event){
        searchQuery = $('#search-bar').val();
        search(searchQuery)
        
    });
    //========================================================================//
});
//The function takes searchQueries and passes it to showProducts to display only specific products
function search(searchQuery)
{
    window.location = "../menu.php?searchQuery="+searchQuery;
    //showProducts("s",null,null,searchQuery,categories);
}