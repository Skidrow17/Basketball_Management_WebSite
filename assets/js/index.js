var number_of_pages = 0 ;
	var current_page = 0;
	var current_category = 0;
	
$(document).ready(function(){
	
	
    $("#men_a,#men_b,#adult,#woman,#girls,#young,#child").click(function(){
		var category = $(this).val();
		current_category = category;
        $('#hide').hide();
		n_o_g(category);
		
		myFunction(category);
		team_category.innerText = $(this).text();
		$('#apear').delay(1000).show();
		$('#next').show();
		$('#previous').show();

    });
	
	$("#back").click(function(){
        $('#apear').hide();
		$("#table tr").remove();
		$("#table td").remove();
		$('#hide').show();
    });
	
	
	 $("#previous").click(function(){ 
      
	  if(current_page!=0)
	  {
	  current_page=current_page-1;
	  $('#current').text(current_page);
	   
	  var post = "cid="+current_category+"&current_page="+current_page;
	 
	   $.ajax({ 
        type: "POST", 
        url: "php/jquery/getGames_By_Category.php",
        data: post,
        success: function(result){ 
          $("#table").html(result); 
        }
      });
	 
	  }
       
    });
	
	
	$("#next").click(function(){ 
      
	  //alert("bika");
	  if(current_page<number_of_pages-1)
	  {
	  current_page=current_page+1;
	   $('#current').text(current_page);
	   var post = "cid="+current_category+"&current_page="+current_page;
	 
	   $.ajax({ 
        type: "POST", 
        url: "php/jquery/getGames_By_Category.php",
        data: post,
        success: function(result){ 
          $("#table").html(result); 
        }
      });
	
    }
});




$("#max").click(function(){ 
      
	  if(number_of_pages!=0)
	  current_page=Math.ceil(number_of_pages-1);
	  $('#current').text(current_page);
	   var post = "cid="+current_category+"&current_page="+current_page;
	  
	   $.ajax({ 
        type: "POST", 
        url: "php/jquery/getGames_By_Category.php",
        data: post,
        success: function(result){ 
          $("#table").html(result); 
        }
      });
 });	

 
 
$("#min").click(function(){ 
      
	  current_page=parseInt(0);
	  $('#current').text(current_page);
	   var post = "cid="+current_category+"&current_page="+current_page;
	  
	   $.ajax({ 
        type: "POST", 
        url: "php/jquery/getGames_By_Category.php",
        data: post,
        success: function(result){ 
          $("#table").html(result); 
        }
      });
 });


});
	
function myFunction(category_id) {
	
	
	var post_id = 'cid='+ category_id+"&current_page=0";
	
	$.ajax({ 
        type: "POST", 
        url: "php/jquery/getGames_By_Category.php",
        data: post_id,
        success: function(result){ 
          $("#table").html(result); 
        }
      });

    
}


function n_o_g(category_id) {
	
	
	var post_id = 'cid='+ category_id;
	
	$.ajax({ 
        type: "POST", 
        url: "php/jquery/getN_O_Games_By_Category.php",
        data: post_id,
        success: function(result){ 
		number_of_pages = result;
		$('#current').text(0);
		if(number_of_pages!=0)
		$('#max').text(Math.ceil(number_of_pages)-1);
		else
		$('#max').text(0); 
        }
        //alert(result);
        
      });

    
}