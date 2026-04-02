var elem = document.querySelector('.hubs');
var flkty = new Flickity( elem, {
  // options
  cellAlign: 'center',
  wrapAround: true,
  autoPlay: 5000,
  initialIndex: 2,
  freeScroll: true,
  contain: true
});

// element argument can be a selector string
//   for an individual element
var flkty = new Flickity( '.hubs', {
  // options
});
