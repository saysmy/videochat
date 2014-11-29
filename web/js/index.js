define('index', ['cookie', 'layer'], function(require) {
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
          $('#sliderItem .sliderItem' + current.attr('index')).parent().fadeOut(200, function() {
              $('#sliderItem .sliderItem' + index).parent().fadeIn(200);
          })         
      }

      var curr_index = 0;
      setInterval(function() {
          curr_index ++;
          if (curr_index >= 3) {curr_index = 0};
          doSlide(curr_index);
      }, 10000);


      var last_come_time = $.cookies.get('last_come_time');
      $.ajax({
          url : '/activity/home' + (last_come_time ? '/last_come_time/' + last_come_time : ''), 
          dataType : 'json',
          success : function(resp) {
              if (resp.data.pic) {
                  $.layer({
                      type: 1,
                      shadeClose: true,
                      title: false,
                      border: [0],
                      area: [resp.data.picWidth + 'px', resp.data.picHeight + 'px'],
                      page : {
                          html : '<a href="' + resp.data.url + '"><img src="' + resp.data.pic + '"/></a>'
                      }
                  });
              }
              $.cookies.set('last_come_time', resp.data.current_time, {expires : 86400 * 365});
          }
      })

    })
})