// Responsive Menu
jQuery( document ).ready( function( $ ) {

for (var i = 0; i < 100; i++) {
  create(i);
}

function create(i) {
  var size = Math.random() * 30;
  $('<div class="confetti-'+i+'"></div>').css({
    "width" : size+"px",
    "height" : size+"px",
    "top" : -Math.random()*20+"%",
    "left" : Math.random()*100+"%",
    "opacity" : Math.random()+0.5,
    "transform" : "rotate("+((Math.random()*90)-45)+"deg)"
  }).appendTo('.home');

  drop(i);
}

function drop(x) {
  $('.confetti-'+x).animate({
    top: "100%",
    left: "+="+Math.random()*15+"%"
  }, Math.random()*3000 + 3000, function() {
    reset(x);
  });
}

function reset(x) {
  $('.confetti-'+x).animate({
    "top" : -Math.random()*20+"%",
    "left" : "-="+Math.random()*15+"%"
  }, 0, function() {
    drop(x);
  });
}

});
