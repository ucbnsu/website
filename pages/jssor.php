<script src="/js/jssor.js"></script>
<script src="/js/jssor.slider.min.js"></script>
<script>
    jQuery(document).ready(function ($) {
        var options = { 
        	$AutoPlay: true,
        	$FillMode: 5
        };
        var jssor_slider1 = new $JssorSlider$('slider1_container', options);

        //responsive code begin
        //you can remove responsive code if you don't want the slider scales
        //while window resizes
        function ScaleSlider() {
            var parentWidth = $('#slider1_container').parent().width();
            var thisWidth = parentWidth;
            if (thisWidth) {
                jssor_slider1.$ScaleWidth(thisWidth);
            }
            else
                window.setTimeout(ScaleSlider, 30);
        }
        //Scale slider after document ready
        ScaleSlider();
                                        
        //Scale slider while window load/resize/orientationchange.
        $(window).bind("load", ScaleSlider);
        $(window).bind("resize", ScaleSlider);
        $(window).bind("orientationchange", ScaleSlider);
        //responsive code end
    });
</script>
