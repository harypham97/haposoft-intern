<footer class="main-footer">
    <strong>Copyright &copy; 2014-2019 <a href="#">AdminLTE</a>.</strong> All rights reserved.
</footer>
<script src="{{asset('public/admin/js/jquery.min.js')}}"></script>
<script src="{{asset('public/admin/js/bootstrap.bundle.min.js')}}"></script>
<script src="{{asset('public/admin/js/admin-staff.js')}}"></script>

<!-- Menu Toggle Script -->
<script>
    $("#menu-toggle").click(function(e) {
        e.preventDefault();
        $("#wrapper").toggleClass("toggled");
    });
</script>