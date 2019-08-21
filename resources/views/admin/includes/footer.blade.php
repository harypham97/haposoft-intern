<footer class="main-footer text-center">
    Copyright &copy; 2019 --- Haposoft's Training --- All rights reserved.
</footer>
<script src="{{asset('public/admin/js/jquery.min.js')}}"></script>
<script src="{{asset('public/admin/js/bootstrap.bundle.min.js')}}"></script>
<script src="{{asset('public/admin/js/admin-staff.js')}}"></script>
<script src="{{asset('public/admin/js/admin-project-user.js')}}"></script>
<script src="{{asset('public/admin/js/admin-task.js')}}"></script>


<!-- Menu Toggle Script -->
<script>
    $("#menu-toggle").click(function (e) {
        e.preventDefault();
        $("#wrapper").toggleClass("toggled");
    });
</script>
