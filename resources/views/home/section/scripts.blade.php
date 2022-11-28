<!--===============================================================================================-->
<script src="{{ asset('assets/home/vendor/jquery/jquery-3.2.1.min.js') }}"></script>
<!--===============================================================================================-->
<script src="{{ asset('assets/home/vendor/animsition/js/animsition.min.js') }}"></script>
<!--===============================================================================================-->
<script src="{{ asset('assets/home/vendor/bootstrap/js/popper.js') }}"></script>
<script src="{{ asset('assets/home/vendor/bootstrap/js/bootstrap.min.js') }}"></script>
<!--===============================================================================================-->
<script src="{{ asset('assets/home/vendor/select2/select2.min.js') }}"></script>
<script>
    $(".js-select2").each(function(){
        $(this).select2({
            minimumResultsForSearch: 20,
            dropdownParent: $(this).next('.dropDownSelect2')
        });
    })
</script>
<!--===============================================================================================-->
<script src="{{ asset('assets/home/vendor/daterangepicker/moment.min.js') }}"></script>
<script src="{{ asset('assets/home/vendor/daterangepicker/daterangepicker.js') }}"></script>
<!--===============================================================================================-->
<script src="{{ asset('assets/home/vendor/slick/slick.min.js') }}"></script>
<script src="{{ asset('assets/home/js/slick-custom.js') }}"></script>
<!--===============================================================================================-->
<script src="{{ asset('assets/home/vendor/parallax100/parallax100.js') }}"></script>
<script>
    $('.parallax100').parallax100();
</script>
<!--===============================================================================================-->
<script src="{{ asset('assets/home/vendor/MagnificPopup/jquery.magnific-popup.min.js') }}"></script>
<script>
    $('.gallery-lb').each(function() { // the containers for all your galleries
        $(this).magnificPopup({
            delegate: 'a', // the selector for gallery item
            type: 'image',
            gallery: {
                enabled:true
            },
            mainClass: 'mfp-fade'
        });
    });
</script>
<!--===============================================================================================-->
<script src="{{ asset('assets/home/vendor/isotope/isotope.pkgd.min.js') }}"></script>
<!--===============================================================================================-->
<script src="{{ asset('assets/home/vendor/sweetalert/sweetalert.min.js') }}"></script>
<script>
    $('.js-addwish-b2').on('click', function(e){
        e.preventDefault();
    });

    $('.js-addwish-b2').each(function(){
        var nameProduct = $(this).parent().parent().find('.js-name-b2').html();
        $(this).on('click', function(){
            swal(nameProduct, "is added to wishlist !", "success");

            $(this).addClass('js-addedwish-b2');
            $(this).off('click');
        });
    });

    $('.js-addwish-detail').each(function(){
        var nameProduct = $(this).parent().parent().parent().find('.js-name-detail').html();

        $(this).on('click', function(){
            swal(nameProduct, "is added to wishlist !", "success");

            $(this).addClass('js-addedwish-detail');
            $(this).off('click');
        });
    });

    /*---------------------------------------------*/
    function addToCart(elem, id=null){
        var product_id = $(elem).data('product_id');

        var quantity = $(elem).data('quantity');
        if(id != null){
            quantity = $('#quantity').val();
        }

        quantity = parseInt(quantity);

        $.ajax({
            url: "/cart/add",
            type: "post",
            data: {
                product_id: product_id,
                quantity: quantity,
                _token: "{{ csrf_token() }}"
            },
            success: function(response){
                if(typeof(response) != "object"){
                    response =  $.parseJSON(response);
                }

                if(response.status == true){
                    swal("Cart Update!", response.msg, "success").then(function(){
                        document.location.href = document.location.href;
                    });
                } else {
                    swal("Cart Update!", response.msg, "error").then(function(){
                        document.location.href = document.location.href;
                    });

                }

            }
        });
    }

    function removeFromCart(cart_index, quantity=1){

        $.ajax({
            url: "/cart/remove",
            type: "get",
            data: {
                cart_index: cart_index,
                quantity: quantity,
            },
            success: function(response){
                if(typeof(response) != "object"){
                    response =  $.parseJSON(response);
                }

                if(response.status == true){
                    swal("Cart Update!", response.msg, "success").then(function(){
                        document.location.href = document.location.href;
                    });
                } else {
                    swal("Cart Update!", response.msg, "error").then(function(){
                        document.location.href = document.location.href;
                    });

                }

            }
        });
    }

</script>
<!--===============================================================================================-->
<script src="{{ asset('assets/home/vendor/perfect-scrollbar/perfect-scrollbar.min.js') }}"></script>
<script>
    $('.js-pscroll').each(function(){
        $(this).css('position','relative');
        $(this).css('overflow','hidden');
        var ps = new PerfectScrollbar(this, {
            wheelSpeed: 1,
            scrollingThreshold: 1000,
            wheelPropagation: false,
        });

        $(window).on('resize', function(){
            ps.update();
        })
    });


</script>
<!--===============================================================================================-->
<script src="{{ asset('assets/home/js/main.js') }}"></script>
{{ TawkTo::widgetCode() }}
</body>
<!-- Go to www.addthis.com/dashboard to customize your tools --> <script type="text/javascript" src="//s7.addthis.com/js/300/addthis_widget.js#pubid=ra-5c36bbc79e7f042d"></script>
</html>
