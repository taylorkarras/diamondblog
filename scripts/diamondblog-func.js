$('#menu > ul').mousewheel(function(event, delta) {
	event.preventDefault();
	this.scrollLeft -= (delta * 50);
});

   $('#menu > ul').mousedown(function(e) {
        var start = e.pageX;
        var startPos = $(this).scrollLeft();
        var el = $(this);

        $('#menu > ul').mousemove(function(e) {
            var offset = start - e.pageX;
            el.scrollLeft(startPos + offset);
            return false;
        });

        $('#menu > ul').one('mouseup', function(e) {
            $('#menu > ul').unbind('mousemove');
			return false;
        });
    });
	var lastX;
	$('#menu > ul').on('touchstart', function(event) {
			lastX = event.originalEvent.changedTouches[0].clientX;
	})
	
	$('#menu > ul').on('touchmove', function(event) {
			event.preventDefault();
	var currentX = event.originalEvent.touches[0].clientX;
	if(currentX > lastX){
         	this.scrollLeft = (this.scrollLeft + currentX / 10);
	}else{
		this.scrollLeft = (this.scrollLeft - currentX / 9.9);
	}
});

var data = {};
$(function() {
$('body').on('click', 'input[type="submit"]', function() {
      resetErrors();
	  var myinstances = [];
	  $("input, button, select").not("#searchbar").prop('disabled', true);

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
	  var div_id = $( "#blog" );
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
          url: url,
          data: data,
          success: function(resp) {
              if (resp.resp === true) {
                  	//successful validation
					form_id.html(resp.message);
			  } else if (resp.formrefresh === true) {
				  form_id.submit();
				  window.location.reload();
			  } else if (resp.divsubmit === true) {
				  div_id.html(resp.message);
			  } else if (resp.search === true) {
                  	//successful validation
					//var title = $(data).filter('title').text();
					var url = "/search?" + form_id.serialize().replace("dbsearchbar", "query");
					//History.pushState(null, title, url);
					window.location.href = url;
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
	  $("input, button, select").prop('disabled', false);
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

$(function() {
    // Stick the #nav to the top of the window
    var nav = $('#searchbar');
    var navHomeY = nav.offset().top;
    var isFixed = false;
    var $w = $(window);
    $w.scroll(function() {
        var scrollTop = $w.scrollTop();
        var shouldBeFixed = scrollTop > navHomeY;
        if (shouldBeFixed && !isFixed) {
            nav.css({
                position: 'fixed',
                top: 0,
            });
            isFixed = true;
        }
        else if (!shouldBeFixed && isFixed)
        {
            nav.css({
                position: 'static'
            });
            isFixed = false;
        }
    });
});

$(function() {
    // Stick the #nav to the top of the window
    var nav = $('.searchhint');
    var navHomeY = nav.offset().top;
    var isFixed = false;
    var $w = $(window);
    $w.scroll(function() {
        var scrollTop = $w.scrollTop();
        var shouldBeFixed = scrollTop > navHomeY;
        if (shouldBeFixed && !isFixed) {
            nav.css({
                top: $('#searchbar').outerHeight(true),
            });
            isFixed = true;
        }
        else if (!shouldBeFixed)
        {
            nav.css({
				top: $('#searchbar').offset().top + $('#searchbar').outerHeight(true) - $(window).scrollTop()
            });
            isFixed = false;
        }
    });
});
