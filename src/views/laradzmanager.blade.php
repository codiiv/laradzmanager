<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="A layout example that shows off a responsive photo gallery.">
    <title>A simple Laravel media manager - Using Dropzone.js</title>

    <link rel="stylesheet" href="https://unpkg.com/purecss@1.0.0/build/pure-min.css" integrity="sha384-" crossorigin="anonymous">

    <!--[if lte IE 8]>
        <link rel="stylesheet" href="https://unpkg.com/purecss@1.0.0/build/grids-responsive-old-ie-min.css">
    <![endif]-->
    <!--[if gt IE 8]><!-->
        <link rel="stylesheet" href="https://unpkg.com/purecss@1.0.0/build/grids-responsive-min.css">
    <!--<![endif]-->


        <!--[if lte IE 8]>
            <link rel="stylesheet" href="css/layouts/gallery-old-ie.css">
        <![endif]-->
        <!--[if gt IE 8]><!-->
        <link rel="stylesheet" href="/dzmedia/assets/css/dropzone.css">
        <link rel="stylesheet" href="/dzmedia/assets/css/layouts/gallery.css">
        <link rel="stylesheet" href="/dzmedia/assets/css/dzmanager.css">
        <!--<![endif]-->
</head>
<body>

<div>
    <div class="main-content">
      <div class="left-menu cell pure-u-1 pure-u-md-1-5">
        <ul>
          <li>Manage</li>
          <li>Add New</li>
        </ul>
      </div><div class="right-content cell pure-u-1 pure-u-md-4-5">
        <form method="POST" action="/dzmanager/dropzone/store" accept-charset="UTF-8" enctype="multipart/form-data" class="dropzone dz-clickable" id="image-upload">

          <?php echo csrf_field(); ?>
        </form>
        <div class="start-action">
          <div class="btn btn-primary start">Start</div>
        </div>
      </div>
    </div>

</div>
<script src="/dzmedia/assets/js/jquery.min.js"></script>
<script src="/dzmedia/assets/js/dropzone.min.js"></script>
<script>
var maxFileNum = 5;
var LaraDropzone = new Dropzone("#image-upload", {
  url               : "/dzmanager/dropzone/store",
  maxFilesize         :       150,
  // acceptedFiles: ".jpeg,.jpg,.png,.gif,.zip, .tar",
  acceptedFiles: "{{ config('laradzmanager.file_types') }}",
  autoProcessQueue: false,
  parallelUploads : 20,
  maxFiles: {{ config('laradzmanager.maximum_files') }},
  maxfilesreached: function(){
    $('.ifrmmessages').removeClass('hidden');
    $('.ifrmmessages .alert-content').html("<?php echo 'Maximum reacher'; ?>");
  },
  // previewTemplate: document.getElementById('preview-template').innerHTML,
  init: function() {
    this.on("addedfile", function(file) {
      var count= LaraDropzone.files.length;
      var preview = $(file.previewTemplate);
      // preview.append('<a class="dz-btn dz-custom-download" href="javascript:void()"><span class="glyphicon glyphicon-download-alt" title=""></span></a><a class="dz-btn dz-custom-delete" href=""><span class="glyphicon glyphicon-remove" title=""></span></a>');
      preview.append('<input type="text" name="" class="imageurlpreview" value="" />');
      if (this.files.length > 5) {
       this.removeFile(this.files[0]);
      }

      if(count < 1){
        $('.mainupload').prop("disabled", true);
      }else{
        $('.mainupload').prop("disabled", false);
      }
      preview.addClass('cell pure-u-1-2 pure-u-md-1-3 pure-u-lg-1-5');
      var innerHtml = preview.html();
      preview.html('<div class="preview-inner"></div>');
      preview.find('.preview-inner').html(innerHtml);
    });
  },
  success: function(file,response) {
    var dis  = file;
    var preview = $(file.previewTemplate);
    // alert(preview.html());
    preview.prop("id", response.id);
    $('.dropzone.dz-started .dz-message').css({"display":"block"});
    $('#'+response.id+' .imageurlpreview').prop("value", response.media);
    $('.mainupload').prop("disabled", true);
    $('.btn-primary.start').find('i').removeClass('fa fa-spin fa-spinner').addClass('glyphicon glyphicon-upload');
  },
  error: function(file, response){
    alert(JSON.stringify(response));
  }
});
$('.btn-primary.start').on("click", function(event){
  event.preventDefault();
  $(this).find('i').removeClass('glyphicon glyphicon-upload').addClass('fa fa-spin fa-spinner');
  $('.ifrmmessages').addClass("hidden");
  LaraDropzone.processQueue();
});
</script>
</body>
</html>
