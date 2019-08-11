<div class="bg-light border-right" id="sidebar-wrapper">
    <div class="list-group list-group-flush">
        <a href="{{route('index')}}" class="list-group-item list-group-item-action bg-light">Dashboard</a>
        <a href="#manageUser" class="list-group-item list-group-item-action bg-light"
           data-toggle="collapse" aria-expanded="false">
            Manage Users
            <i class="fa fa-angle-down pull-right"></i>
        </a>
            <ul class="collapse list-unstyled list-group list-group-flush dropdown-content" id="manageUser">
                <a href="{{route('staffs.index')}}" class="py-2 pl-5 text-decoration-none">Staffs</a>
                <a href="#" class="py-2 pl-5 text-decoration-none">Customers</a>
            </ul>
        <a href="#manageProject" class="list-group-item list-group-item-action bg-light"
           data-toggle="collapse" aria-expanded="false">
            Manage Projects
            <i class="fa fa-angle-down pull-right"></i>
        </a>
            <ul class="collapse list-unstyled list-group list-group-flush dropdown-content " id="manageProject">
                <a href="{{route('projects.index')}}" class="py-2 pl-5 text-decoration-none">Projects</a>
                <a href="{{route('project_user.index')}}" class="py-2 pl-5 text-decoration-none">Project-User</a>
                <a href="#" class="py-2 pl-5 text-decoration-none">Assign</a>
            </ul>
        <a href="#" class="list-group-item list-group-item-action bg-light">Report</a>
        <a href="#" class="list-group-item list-group-item-action bg-light">OverView</a>
    </div>
</div>
