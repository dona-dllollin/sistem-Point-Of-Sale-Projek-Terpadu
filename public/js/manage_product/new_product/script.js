

function stopScan(){
  Quagga.stop();
}

function startScan() {
  Quagga.init({
    inputStream : {
      name : "Live",
      type : "LiveStream",
      target: document.querySelector('#area-scan')
    },
    decoder : {
      readers : ["ean_reader", "upc_reader", "code_128_reader", "code_39_reader"],
      multiple: false
    },
    locate: false
  }, function(err) {
      if (err) {
          console.log(err);
          return
      }
      console.log("Initialization finished. Ready to start");
      Quagga.start();
  });

  Quagga.onDetected(function(data){
    $('#area-scan').prop('hidden', true);
    $('.barcode-result').prop('hidden', false);
    $('#btn-scan-action').prop('hidden', false);
    $('.barcode-result-text').html(data.codeResult.code);
    stopScan();
  });
}

$(document).on('click', '.btn-scan', function(){
  $('#area-scan').prop('hidden', false);
  $('.barcode-result').prop('hidden', true);
  $('#btn-scan-action').prop('hidden', true);
  $('.barcode-result-text').html('');
  startScan();
});

$(document).on('click', '.btn-continue', function(){
  $('input[name=kode_barang]').val($('.barcode-result-text').text());
  $('.close-btn').click();
});

$(document).on('click', '.btn-repeat', function(){
  $('#area-scan').prop('hidden', false);
  $('.barcode-result').prop('hidden', true);
  $('#btn-scan-action').prop('hidden', true);
  $('.barcode-result-text').html('');
  startScan();
});

$('#scanModal').on('hidden.bs.modal', function (e) {
  stopScan();
})

// $('input[name=excel_file]').change(function(){
//     var filename = $(this).val().replace(/C:\\fakepath\\/i, '');
//     $('.excel-name').html(filename);
//     $('.btn-upload').prop('hidden', false);
// });

// $(document).on('click', '.excel-file', function(e){
//   e.preventDefault();
//   $('input[name=excel_file]').click();
// });

