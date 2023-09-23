<div id="result"></div>

<div id="reader" width="500px" height="600px"></div>

<div id="scan" class="btn btn-warning"><h1>Skannaa</h1></div>

<script src="https://unpkg.com/html5-qrcode"></script>
<script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>

<script>

const html5QrCode = new Html5Qrcode("reader");
const qrCodeSuccessCallback = (decodedText, decodedResult) => {
  html5QrCode.stop().then((ignore) => {
  }).catch((err) => {
  });
  $('#scan').show();
  $.ajax({
        type: "POST",
        url: "check",
        data: {code: decodedText},
    }).done(function(response) {
        $('#result').html(response);
    });
};

$('#scan').click(function() {
  html5QrCode.start({ facingMode: "environment" }, config, qrCodeSuccessCallback);
  $('#scan').hide();
});

const config = { fps: 10, qrbox: { width: 250, height: 250 } };

</script>

