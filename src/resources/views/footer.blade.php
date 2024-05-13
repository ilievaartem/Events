<footer class="footer px-4">
        <div><a href="https://coreui.io">CoreUI </a><a href="https://coreui.io/product/free-bootstrap-admin-template/">Bootstrap Admin Template</a> &copy; 2024 creativeLabs.</div>
        <div class="ms-auto">Powered by&nbsp;<a href="https://coreui.io/docs/">CoreUI UI Components</a></div>
      </footer>
{{--      <script src="../node_modules/@coreui/coreui/dist/js/coreui.bundle.min.js"></script>--}}
{{--    <script src="../node_modules/simplebar/dist/simplebar.min.js"></script>--}}
    <script>
      const header = document.querySelector('header.header');

      document.addEventListener('scroll', () => {
        if (header) {
          header.classList.toggle('shadow-sm', document.documentElement.scrollTop > 0);
        }
      });

    </script>
    <!-- Plugins and scripts required by this view-->
    {{-- <script src="../node_modules/chart.js/dist/chart.umd.js"></script> --}}
    {{-- <script src="../node_modules/@coreui/chartjs/dist/js/coreui-chartjs.js"></script> --}}
{{--    <script src="../node_modules/@coreui/utils/dist/umd/index.js"></script>--}}
    {{-- <script src="js/main.js"></script> --}}
