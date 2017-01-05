(function() {

  var streaming = false,
      video        = document.querySelector('#video'),
      canvas       = document.querySelector('#canvas'),
      startbutton  = document.querySelector('#startbutton'),
      name  = document.querySelector('#name'),
      width = 320,
      height = 0;

  function getCheckedBoxes(chkboxName) {
      var checkboxes = document.getElementsByName(chkboxName);
      var checkboxesChecked = [];
      for (var i=0; i<checkboxes.length; i++) {
         if (checkboxes[i].checked) {
            checkboxesChecked.push(checkboxes[i].value);
         }
      }
      return checkboxesChecked.length > 0 ? JSON.stringify(checkboxesChecked) : null;
  }

  navigator.getMedia = ( navigator.getUserMedia ||
                         navigator.webkitGetUserMedia ||
                         navigator.mozGetUserMedia ||
                         navigator.mediaDevices.getUserMedia ||
                         navigator.msGetUserMedia);

  navigator.getMedia(
    {
      video: true,
      audio: false
    },
    function(stream) {
      if (navigator.mozGetUserMedia) {
        video.mozSrcObject = stream;
      } else {
        var vendorURL = window.URL || window.webkitURL;
        video.src = vendorURL.createObjectURL(stream);
      }
      video.play();
    },
    function(err) {
      console.log("An error occured! " + err);
    }
  );

  video.addEventListener('canplay', function(ev){
    if (!streaming) {
      height = video.videoHeight / (video.videoWidth/width);
      video.setAttribute('width', width);
      video.setAttribute('height', height);
      canvas.setAttribute('width', width);
      canvas.setAttribute('height', height);
      streaming = true;
    }
  }, false);

  function takepicture() {
    canvas.width = width;
    canvas.height = height;
    canvas.getContext('2d').drawImage(video, 0, 0, width, height);
    ajaxRequest("treatment.php", {'b64Img':canvas.toDataURL(), 'pseudo':name.innerHTML, 'addImage': getCheckedBoxes('image')});
  }

  startbutton.addEventListener('click', function(ev){
    if (getCheckedBoxes('image'))
      takepicture();
    else 
      alert("You need to select at least one image !");
    ev.preventDefault();
  }, false);

})();

