jQuery(document).ready(function(){
  jQuery('#presentation').fathom();

  if(jQuery('#presentation').hasClass('vertical_center')){
    jQuery('.slide').each(function(){
      // center slide content.
      var slideHeight = jQuery(this).height();
      var slideHeaderHeight = jQuery(this).find('h1:first').height();
      var slideContentHeight = jQuery(this).find('.slidecontent:first').height();
      jQuery(this).find('.slidecontent').css({marginTop: (slideHeight - slideHeaderHeight - slideContentHeight) / 2});
    });
  }

});
