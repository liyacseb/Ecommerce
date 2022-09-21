<html lang="en">
<head>
  <title>How to Image Upload and Crop in Laravel with Ajax</title>
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.1.1/css/bootstrap.min.css">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/cropper/2.3.4/cropper.min.css">
  <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.1.1/jquery.min.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/cropper/2.3.4/cropper.min.js"></script>
  <meta name="csrf-token" content="{{ csrf_token() }}">

</head>

<body>
<div class="container">
  <main class="page">
	<h2>Upload ,Crop and save.</h2>
    <div>
  <img id="image" src="https://fengyuanchen.github.io/cropper/images/picture.jpg">
</div>

<br /><br />
	<button class="crop">CROP</button>

<br /><br /><br />

<img class="preview" />
</main>
</div>


<script type="text/javascript">
$('#image').cropper({
  aspectRatio: 500 / 500,
  autoCropArea: 1,
  dragMode: 'move'
});

$('.crop').click(function(){
  var result = $('#image').cropper('getCroppedCanvas', {
    width: 500,
    height: 500,
    beforeDrawImage: function(canvas) {
      var context = canvas.getContext('2d');
      context.imageSmoothingEnabled = false;
      context.imageSmoothingQuality = 'high';
    },
  });
  var base64 = result.toDataURL('image/jpeg');
  $('.preview').attr('src', base64);
});

</script>


</body>
</html>