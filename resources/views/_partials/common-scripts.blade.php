<script src="{{asset('js/jQuery-3.7.1.js')}}"></script>
<script src="{{asset('js/toastr/toastr.min.js')}}"></script>
<script>
    toastr.options.positionClass =  "toast-bottom-right";
</script>
@if(session()->has('toast.error'))
    <script>
        toastr.error("{{session('toast.error')}}")
    </script>
@endif
@if(session()->has('toast.success'))
    <script>
        toastr.success("{{session('toast.success')}}")
    </script>
@endif
