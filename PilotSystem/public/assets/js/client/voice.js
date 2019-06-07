window.onload = function(){
   setTimeout(loadAfterTime, 100)
};

$( "#outputVolume" ).slider({
  min: -6, max: 6
});

$( "#outputVolume" ).on( "slide", function( event, ui ) {
  changeSpeakerVolume(ui.value)
} );

function loadAfterTime() { 
$('#uniform-inputDevice').attr('class', 'wideSelector');
$('#uniform-outputDevice').attr('class', 'wideSelector');
}