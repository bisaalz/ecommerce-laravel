@if(session()->has('success'))
    <p class="alert alert-success">{{ session('success') }}</p>
@endif
@if(session()->has('error'))
    <p class="alert alert-danger">{{ session('error') }}</p>
@endif
<script>
    setTimeout(function(){
        $('.alert').slideUp();
    }, 3000);
</script>
