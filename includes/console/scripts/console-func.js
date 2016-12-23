var data = {};
$(function() {
	
$('.menu2 > ul').mousewheel(function(event, delta) {
	event.preventDefault();
	this.scrollLeft -= (delta * 50);
});

   $('.menu2 > ul').mousedown(function(e) {
        var start = e.pageX;
        var startPos = $(this).scrollLeft();
        var el = $(this);

        $('.menu2 > ul').mousemove(function(e) {
            var offset = start - e.pageX;
            el.scrollLeft(startPos + offset);
            return false;
        });

        $('.menu2 > ul').one('mouseup', function(e) {
            $('.menu2 > ul').unbind('mousemove');
			return false;
        });
    });
	var lastX;
	$('.menu2 > ul').on('touchstart', function(event) {
			lastX = event.originalEvent.changedTouches[0].clientX;
	})
	
	$('.menu2 > ul').on('touchmove', function(event) {
			event.preventDefault();
	var currentX = event.originalEvent.touches[0].clientX;
	if(currentX > lastX){
         	this.scrollLeft = (this.scrollLeft + currentX / 10);
	}else{
		this.scrollLeft = (this.scrollLeft - currentX / 9.9);
	}
});

$("#loading").empty();

$('#icon').on('click', '.iconupload', function(e){
e.preventDefault();

var formData = new FormData($(this).parents('#icon')[0]);
$("#upload").empty();
$('#loading').show();
$.ajax({
url: "console/iconupload", // Url to which the request is send
type: "POST",             // Type of request to be send, called as method
data: formData, // Data sent to server, a set of key/value pairs (i.e. form fields and values)
            xhr: function() {
                var myXhr = $.ajaxSettings.xhr();
                return myXhr;
            },
contentType: false,       // The content type used when sending data to the server.
cache: false,             // To unable request pages to be cached
processData:false,        // To send DOMDocument or non processed data file it is set to false
success: function(data)   // A function to be called if request succeeds
{
event.preventDefault();
$('#loading').hide();
$("#upload").html(data);
}
});
return false;
});

$("#loading2").empty();

$('#logo').on('click', '.logoupload', function(e){
e.preventDefault();

var formData = new FormData($(this).parents('#logo')[0]);
$("#upload2").empty();
$('#loading2').show();
$.ajax({
url: "console/logoupload", // Url to which the request is send
type: "POST",             // Type of request to be send, called as method
data: formData, // Data sent to server, a set of key/value pairs (i.e. form fields and values)
            xhr: function() {
                var myXhr = $.ajaxSettings.xhr();
                return myXhr;
            },
contentType: false,       // The content type used when sending data to the server.
cache: false,             // To unable request pages to be cached
processData:false,        // To send DOMDocument or non processed data file it is set to false
success: function(data)   // A function to be called if request succeeds
{
event.preventDefault();
$('#loading2').hide();
$("#upload2").html(data);
}
});
return false;
});
	
$('body').on('click', 'input[type="submit"]', function() {
      resetErrors();
	  var myinstances = [];
	  $("input, button, select, textarea").not("#searchbar, #twitterexample").prop('disabled', true);
	  $('body').append('<div class="message"><div class="successmessage" style="background-color:#f0f0f0">Please wait...</div></div>');

//this is the foreach loop
for(var i in CKEDITOR.instances) {

   /* this  returns each instance as object try it with alert(CKEDITOR.instances[i]) */
    CKEDITOR.instances[i]; 
   
    /* this returns the names of the textareas/id of the instances. */
    CKEDITOR.instances[i].name;

    /* returns the initial value of the textarea */
    CKEDITOR.instances[i].value;  
 
   /* this updates the value of the textarea from the CK instances.. */
   CKEDITOR.instances[i].updateElement();

   /* this retrieve the data of each instances and store it into an associative array with
       the names of the textareas as keys... */
   myinstances[CKEDITOR.instances[i].name] = CKEDITOR.instances[i].getData(); 
	CKEDITOR.instances[i].setReadOnly(true);
}
      var url = $(this).closest("form").attr('id');
	  var form_id = $("#" + $(this).closest("form").attr('id'));
	  var div_id = $("#" + $(this).parents("div").eq(1).attr("id"));
      $.each($('form input, form select'), function(i, v) {
          if (v.type !== 'submit') {
              data[v.name] = v.value;
          }
	  }); $.each($('textarea'), function(i, v) {
          if (v.type !== 'submit') {
              data[v.name] = v.value;
          }
      }); //end each
      $.ajax({
		  beforeSend:function(resp){
        /* Before serialize */
        for ( instance in CKEDITOR.instances ) {
            CKEDITOR.instances[instance].updateElement();
        }
        return true; 
    },
          dataType: 'json',
          type: 'POST',
          url: 'console/'+url,
          data: data,
          success: function(resp) {
              if (resp.resp === true) {
                  	//successful validation
					$(".successmessage").remove();
					$('body').append('<div class="message"><div class="successmessage">'+resp.message+'</div></div>')
					$('.successmessage').delay(5000).fadeOut('fast');
					$("input, button, select, textarea").prop('disabled', false);
			  } else if (resp.resprefresh === true) {
                  	//successful validation
					$(".successmessage").remove();
					$('body').append('<div class="message"><div class="successmessage">'+resp.message+'</div></div>')
					$('.successmessage').delay(5000).fadeOut('fast');
					window.setTimeout(function(){
					window.location.href = resp.url;
					}, 5000);
			  } else if (resp.formrefresh === true) {
				  $(".successmessage").remove();
				  form_id.submit().location.reload();
			  } else if (resp.divsubmit === true) {
				  $(".successmessage").remove();
				  div_id.html(resp.message);
				  $("input, button, select, textarea").prop('disabled', false);
			  } else if (resp.searchposts === true) {
                  	//successful validation
					//var title = $(data).filter('title').text();
					var url = "/console/posts/search?" + form_id.serialize().replace("dbsearchbar", "query");
					//History.pushState(null, title, url);
					window.location.replace(url);
					event.preventDefault();
			  } else if (resp.searchusers === true) {
                  	//successful validation
					//var title = $(data).filter('title').text();
					var url = "/console/users/search?" + form_id.serialize().replace("dbsearchbar", "query");
					//History.pushState(null, title, url);
					window.location.replace(url);
					event.preventDefault();
			  } else if (resp.searchbans === true) {
                  	//successful validation
					//var title = $(data).filter('title').text();
					var url = "/console/ban/search?" + form_id.serialize().replace("dbsearchbar", "query");
					//History.pushState(null, title, url);
					window.location.replace(url);
					event.preventDefault();
			  } else {
                  $.each(resp, function(i, v) {
	        console.log(i + " => " + v); // view in console for error messages
                      var msg = '<div class="break"></div><label class="error" for="'+i+'">'+v+'</label>';
                      $('input[name="' + i + '"], select[name="' + i + '"], textarea[name="' + i + '"]').addClass('inputTxtError').after(msg);
                  });
                  var keys = Object.keys(resp);
				  			  				  	  	  for(var i in CKEDITOR.instances) {
	CKEDITOR.instances[i].setReadOnly(false);
}
	  $("input, button, select, textarea").not("#twitterexample").prop('disabled', false);
	  $(".successmessage").remove();
                  $('input[name="'+keys[0]+'"]').focus();
              }
          },
          error: function(xhr, status, error) {
			  var err = eval("(" + xhr.responseText + ")");
              console.log(err.Message);
          }
      });
      return false;
  });
});
function resetErrors() {
    $('form input, form select, textarea').removeClass('inputTxtError');
    $('label.error').remove();
}
