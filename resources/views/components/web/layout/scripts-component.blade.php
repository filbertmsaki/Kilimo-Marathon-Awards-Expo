    <!-- Vendor JS -->

    <script src="{{ asset('plugins/jquery/jquery.min.js') }}"></script>
    <script src="{{ asset('js/toastr.min.js') }}"></script>
    <script src="{{ asset('assets/js/vendors.min.js') }}"></script>

    <script src="{{ asset('plugins/select2/js/select2.full.min.js') }}"></script>

    <!-- Corenav Master JavaScript -->
    <script src="{{ asset('assets/plugins/corenav-master/coreNavigation-1.1.3.js') }}"></script>
    <script src="{{ asset('assets/js/nav.js') }}"></script>
    <script src="{{ asset('assets/plugins/OwlCarousel2/dist/owl.carousel.js') }}"></script>
    <script src="{{ asset('assets/plugins/bootstrap-select/dist/js/bootstrap-select.js') }}"></script>
    <!-- EduAdmin front end -->
    <script src="{{ asset('assets/js/template.js') }}"></script>


    <script>
        function isJSON(something) {
            if (typeof something != 'string')
                something = JSON.stringify(something);
            try {
                JSON.parse(something);
                return true;
            } catch (e) {
                return false;
            }
        }

        $(document).ready(function() {

            $('.select2').select2({
                width: '100%'
            });
            $(document).ready(() => {
                $(document).on('keyup paste change input', '.entry', function() {
                    var value = $(this).val();
                    if (value == '1') {
                        $('#company_phoneDiv').hide();
                        $('#company_emailDiv').hide();
                        $('#company_name').attr('placeholder', 'Enter Service/ Business Name')
                        $('#company_phone').prop('required', false);
                    } else {
                        $('#company_phoneDiv').show();
                        $('#company_emailDiv').show();
                        $('#company_name').attr('placeholder', 'Enter Company Name')
                        $('#company_phone').prop('required', true);
                    }
                });
            });
        });
    </script>
    @yield('script')
    <script>
        @if (Session::has('message'))
            toastr.options = {
                "closeButton": true,
                "progressBar": true,
                "positionClass": "toast-top-right"
            }
            toastr.success("{{ session('message') }}");
        @endif

        @if (Session::has('error'))
            toastr.options = {
                "closeButton": true,
                "progressBar": true,
                "positionClass": "toast-top-right"
            }
            toastr.error("{{ session('error') }}");
        @endif

        @if (Session::has('info'))
            toastr.options = {
                "closeButton": true,
                "progressBar": true,
                "positionClass": "toast-top-right"
            }
            toastr.info("{{ session('info') }}");
        @endif

        @if (Session::has('warning'))
            toastr.options = {
                "closeButton": true,
                "progressBar": true,
                "positionClass": "toast-top-right"
            }
            toastr.warning("{{ session('warning') }}");
        @endif

        @if (Session::has('success'))
            toastr.options = {
                "closeButton": true,
                "progressBar": true,
                "positionClass": "toast-top-right"
            }
            toastr.success("{{ session('success') }}");
        @endif

        @if (Session::has('danger'))
            toastr.options = {
                "closeButton": true,
                "progressBar": true,
                "positionClass": "toast-top-right"
            }
            toastr.danger("{{ session('danger') }}");
        @endif
    </script>
