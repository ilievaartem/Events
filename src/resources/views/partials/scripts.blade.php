<script src="{{config('app.url').'/'}}js/app.js"></script>
{{--<script src="vendors/@coreui/coreui/js/coreui.bundle.min.js"></script>--}}
{{--<script src="vendors/simplebar/js/simplebar.min.js"></script>--}}
<script>
    const header = document.querySelector('header.header');

    document.addEventListener('scroll', () => {
        if (header) {
            header.classList.toggle('shadow-sm', document.documentElement.scrollTop > 0);
        }
    });
</script>
<!-- Plugins and scripts required by this view-->
{{--<script src="vendors/chart.js/js/chart.umd.js"></script>--}}
{{--<script src="vendors/@coreui/chartjs/js/coreui-chartjs.js"></script>--}}
{{--<script src="vendors/@coreui/utils/js/index.js"></script>--}}
{{--<script src="js/main.js"></script>--}}
<script>
</script>
