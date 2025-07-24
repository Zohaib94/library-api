<?php
$this->registerCss(
  <<< EOT_CSS
 .column
 {
 border:1px solid black;
 }
 #layout
 {
 position:relative;
 margin:0pt auto;
 width:1400px;
 }

 #colSx
 {
 width:200px;
 float:left;
 }

  #colCenter
 {
 width:1000px;
 float:left;
 }
 #colDx
 {
 width:200px;
 float:left;
 }

EOT_CSS
);
?>

<?php
$this->registerJs(
  <<< EOT_JS

 function resizeLayout()
 {
 var windowWidth = $(window).width();

 if(windowWidth > 1400)
 {
 $('#colSx').css('display', 'block');
 $('#colCenter').css('display', 'block');

  $('#colDx').css('display', 'block');
 $('#layout').css('width', 1400);
 }
 else if((windowWidth>1200)&&(windowWidth<=1400))
 {
 $('#colSx').css('display', 'block');
 $('#colCenter').css('display', 'block');
 $('#colDx').css('display', 'none');
 $('#layout').css('width', 1200);
 }
 else if(windowWidth<1200)
 {
 $('#colSx').css('display', 'none');
 $('#colCenter').css('display', 'block');
 $('#colDx').css('display', 'none');
 $('#layout').css('width', 1000);
 }

 }

 $(window).resize(function() {
 resizeLayout();
 });

 $(function() {
 resizeLayout();
 });

EOT_JS
);
?>

<div id="layout">
  <div id="colSx" class="column">
    Content of SX Column
  </div>
  <div id="colCenter" class="column">
    Content of Central Column
  </div>
  <div id="colDx" class="column">
    Content of DX Column
  </div>
</div>