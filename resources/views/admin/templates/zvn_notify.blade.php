@if (session('zvn_notify'))
    <script>
        toastr.success('{{ session('zvn_notify') }}');
    </script>
@endif