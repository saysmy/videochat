define('index', function(require) {
    $(document.body).ready(function() {

      $(".mainBig > dl:nth-child(3)").css({"margin-right":"0"});

      $('#sliderPanel span').click(function() {
          doSlide($(this).index());
      })

      function doSlide(index) {
          var toIcon = $('#sliderPanel span[index='+index+']');
          if (toIcon.hasClass('on')) {
              return false;
          };
          var current = $('#sliderPanel span.on');
          current.removeClass('on');
          toIcon.addClass('on');
          $('#sliderItem .sliderItem' + current.attr('index')).fadeOut(200, function() {
              $('#sliderItem .sliderItem' + index).fadeIn(200);
          })         
      }

      var curr_index = 0;
      setInterval(function() {
          curr_index ++;
          if (curr_index >= 3) {curr_index = 0};
          doSlide(curr_index);
      }, 10000)
    })
})