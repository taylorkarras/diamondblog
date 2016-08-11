window.onload = function() {
	
var height = $('body').height();
$('#dirbrowse').css("height", height + "px");

$(window).resize(function() {
var height = $('body').height();
$('#dirbrowse').css("height", height + "px");
});

	$(".directory").click(function() {
$(".directory").removeClass("diractive");
$(this).addClass("diractive");
	});
	
$(".addfolder").click(function() {
    $("#addfolder").show();
	event.stopPropagation();
});

$(".upload").click(function() {
    $("#upload").show();
	event.stopPropagation();
});

$(".modal-content").click(function() {
	event.stopPropagation();
});

$(document).click(function() {
        $("#upload, #addfolder").hide();
});

$(".close").click(function() {
        $("#upload, #addfolder").hide();
});


$('.modal-content').on('click', '#submit-btn', function(e){
		resetErrors();
        e.preventDefault();
        var formData = new FormData($(this).parents('#uploadform')[0]);
		
        $.ajax({
            url: '/includes/console/scripts/ddcfinder/includes/upload.php?dir='+localStorage.getItem('ftpdirectory'),
            type: 'POST',
            xhr: function() {
                var xhr = $.ajaxSettings.xhr();
				xhr.upload.addEventListener("progress", function(evt){
      if (evt.lengthComputable) {
        var percentComplete = evt.loaded / evt.total * 100;
        //Do something with download progress
		var progress = 25;

var wrapper_elt = document.querySelector('.progress-wrap');
var progress_elt = document.querySelector('.progress-bar');

//resize
var width = wrapper_elt.getBoundingClientRect().width;

var update = function(progress) {
  var percent = progress / 100;
  var total = percent * width;
  
  progress_elt.style.left = Math.floor(total)+'px';
};

var make_loop = function(val, duration) {
  var current = 0;
  var tsinc = duration / val;
  var loop = function() {
    if( current <= val ) {
      update(current++);
      window.setTimeout(loop, tsinc);
    }
  }
  loop();
};
update(percentComplete);
//console.log(percentComplete);
      }
    }, false);
                return xhr;
            },
            data: formData,
			dataType: "JSON",
            processData: false,
            contentType: false,
          success: function(resp) {
              if (resp.uploadsuccess === true) {
                  	//successful validation
					$("#addfolder").hide();
					window.location.reload();
					} else {
                  $.each(resp, function(i, v) {
	        console.log(i + " => " + v); // view in console for error messages
                      var msg = '<div class="break"></div><label class="error" for="'+i+'">'+v+'</label>';
                      $('input[name="' + i + '"], select[name="' + i + '"], textarea[name="' + i + '"]').addClass('inputTxtError').after(msg);
                  });
                  var keys = Object.keys(resp);
                  $('input[name="'+keys[0]+'"]').focus();
              }
          },
			error: function(xhr, status, error) {
			  var err = eval("(" + xhr.responseText + ")");
              console.log(err.Message);
			  console.log(xhr);
          }
             });
            });

$('.modal-content').on('click', '#foldersubmit', function(e){
		resetErrors();
        e.preventDefault();
        var data = new FormData($(this).parents('#folderform')[0]);
      $.ajax({
          dataType: 'json',
          type: 'POST',
          processData: false,
          contentType: false,
          url: 'includes/newfolder.php',
          data: data,
          success: function(resp) {
              if (resp.newfolder === true) {
                  	//successful validation
					
			  } else {
                  $.each(resp, function(i, v) {
	        console.log(i + " => " + v); // view in console for error messages
                      var msg = '<div class="break"></div><label class="error" for="'+i+'">'+v+'</label>';
                      $('input[name="' + i + '"], select[name="' + i + '"], textarea[name="' + i + '"]').addClass('inputTxtError').after(msg);
                  });
                  var keys = Object.keys(resp);
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
  
};
  
function resetErrors() {
    $('form input, form select, textarea').removeClass('inputTxtError');
    $('label.error').remove();
}

function beforeSubmit(){
   //check whether client browser fully supports all File API
   if (window.File && window.FileReader && window.FileList && window.Blob)
    {
       var fsize = $('#uploadimage')[0].files[0].size; //get file size
           var ftype = $('#uploadimage')[0].files[0].type; // get file type
        //allow file types 
      switch(ftype)
           {
            case 'image/png': 
            case 'image/gif': 
            case 'image/jpeg': 
            case 'image/pjpeg':
            break;
            default:
             $("#output").html("<b>"+ftype+"</b> Unsupported file type!");
         return false
           }
    
       //Allowed file size is less than 5 MB (1048576 = 1 mb)
       if(fsize>5242880) 
       {
         alert("<b>"+fsize +"</b> Too big file! <br />File is too big, it should be less than 5 MB.");
         return false
       }
        }
        else
    {
       //Error for older unsupported browsers that doesn't support HTML5 File API
       alert("Please upgrade your browser, because your current browser lacks some new features we need!");
           return false
    }
}

function afterSuccess(){
$("#upload").hide();

}

	function getfiles(directory)
{
//	console.log('hi');
   $.ajax({

     type: "GET",
     url: 'https://'+window.location.hostname+'/includes/console/scripts/ddcfinder/includes/getfiles.php',
     data: "dir=" + directory, // appears as $_GET['id'] @ your backend side
     success: function(data) {
           // data is ur summary
//		  console.log(window.location.hostname+'includes/console/scripts/ddcfinder/includes/getfiles.php');
          $('#fileslist').html(data);
		  localStorage.setItem('ftpdirectory', directory);

   }
   
})
}

function getUrlParam( paramName ) {
            var reParam = new RegExp( '(?:[\?&]|&)' + paramName + '=([^&]+)', 'i' );
            var match = window.location.search.match( reParam );

            return ( match && match.length > 1 ) ? match[1] : null;
        }

function returnFileUrl(fileURL) {

            var funcNum = getUrlParam( 'CKEditorFuncNum' );
            window.parent.CKEDITOR.tools.callFunction( funcNum, fileURL );
			window.parent.$('.featherlight-close').click();
            window.close();
        }

