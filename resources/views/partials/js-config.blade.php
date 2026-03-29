<script>
    window.APP = {
        BASE_URL: "{{ url('/') }}",
        LOGIN_URL: "{{ route('login') }}",
        LOGOUT_URL: "{{ route('logout') }}",
    };
</script>