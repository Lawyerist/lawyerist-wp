// DoubleClick Tags
var googletag = googletag || {};
googletag.cmd = googletag.cmd || [];
(function() {
  var gads = document.createElement('script');
  gads.async = true;
  gads.type = 'text/javascript';
  var useSSL = 'https:' == document.location.protocol;
  gads.src = (useSSL ? 'https:' : 'http:') +
    '//www.googletagservices.com/tag/js/gpt.js';
  var node = document.getElementsByTagName('script')[0];
  node.parentNode.insertBefore(gads, node);
})();

googletag.cmd.push(function() {
  var ap1 = googletag.defineSlot('/12659965/lawyerist_ap1_leaderboard', [728, 90], 'div-gpt-ad-1429843825352-0').setTargeting("test", "refresh").addService(googletag.pubads());
  var ap2 = googletag.defineSlot('/12659965/lawyerist_ap2_sidebar1', [300, 250], 'div-gpt-ad-1429843825352-1').setTargeting("test", "refresh").addService(googletag.pubads());
  var ap3 = googletag.defineSlot('/12659965/lawyerist_ap3_sidebar2', [300, 250], 'div-gpt-ad-1429843825352-2').setTargeting("test", "refresh").addService(googletag.pubads());

  googletag.pubads().enableSingleRequest();

  googletag.enableServices();

  googletag.display( 'div-gpt-ad-1429843825352-0', 'div-gpt-ad-1429843825352-1', 'div-gpt-ad-1429843825352-2' );

  // Set timer to refresh slot every 30 seconds
  setInterval( function() { googletag.pubads().refresh( [ ap1, ap2, ap3 ] ); }, 60000 );

});
// End DoubleClick Tags
