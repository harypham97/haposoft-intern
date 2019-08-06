@extends('admin.layouts.default')
@section('title', 'Staffs')
@section('content')
    <div class="container-fluid">
        <button class="btn btn-primary mt-3 mb-3">Add new staff</button>
        <table class="table table-bordered table-hover">
            <thead>
            <tr>
                <th>ID</th>
                <th>Name</th>
                <th>Email</th>
                <th>Action</th>
            </tr>
            </thead>
            <tbody>
            @foreach($data as $user)
                <tr>
                    <th>{{$user->id}}</th>
                    <td>{{$user->name}}</td>
                    <td>{{$user->email}}</td>
                    <td class="d-flex">
                        <button class="btn btn-outline-primary btnInfoModal" id="{{$user->id}}" title="View && Edit">
                            <i class="fa fa-fw fa-search"></i>
                        </button>
                        {{--<button class="btn btn-outline-warning ml-3 mr-3 btnInfoModal" id="editInfoStaff" title="Edit">--}}
                        {{--<i class="fa fa-fw fa-edit"></i>--}}
                        {{--</button>--}}
                        <form method="POST" action="{{ route('staffs.destroy', [$user->id]) }}">
                            {{ csrf_field() }}
                            {{ method_field('DELETE') }}
                            <button class="btn btn-outline-danger" type="submit" title="Delete"
                                    onclick="return confirm('Are you sure you want to delete the record {{ $user->id }} ?')">
                                <i class="fa fa-fw fa-trash"></i>
                            </button>
                        </form>
                    </td>
                </tr>
            @endforeach
            </tbody>
        </table>
        {{ $data->links('pagination::bootstrap-4') }}
    </div>


    <!-- Modal -->
    <div class="modal fade" id="infoStaffModal" tabindex="-1" role="dialog" aria-labelledby="infoStaffLabel"
         aria-hidden="true">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="infoStaffLabel">Staff 's information</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form>
                        <input class="d-none" id="idStaff">
                        <div class="d-flex flex-row row">
                            <div class="col-6">
                                <div class="form-group row">
                                    <label for="name" class="col-sm-2 col-form-label">Name:</label>
                                    <div class="col-sm-10">
                                        <input type="text" readonly class="form-control-plaintext inputInfoModal"
                                               id="nameStaff">
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label for="dept" class="col-sm-2 col-form-label">Dept:</label>
                                    <div class="col-sm-10">
                                        <input type="text" readonly class="form-control-plaintext inputInfoModal"
                                               id="deptStaff">
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label for="phone" class="col-sm-2 col-form-label">Phone:</label>
                                    <div class="col-sm-10">
                                        <input type="text" readonly class="form-control-plaintext inputInfoModal"
                                               id="phoneStaff">
                                    </div>
                                </div>
                            </div>
                            <div class="col-6 d-flex">
                                <label id="avatar" class="">Avatar:</label>
                                <img class="img-staff ml-lg-3" src="{{asset('public/storage/images/ahihi.jpg')}}"
                                     alt="avatar-staff">
                                <input type="file" name="avatar" class="">

                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="email" class="col-sm-1 col-form-label">Email:</label>
                            <div class="col-sm-11">
                                <input type="text" readonly class="form-control-plaintext inputInfoModal"
                                       id="emailStaff">
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="dob" class="col-sm-1 col-form-label">Dob:</label>
                            <div class="col-sm-11">
                                <input type="text" readonly class="form-control-plaintext inputInfoModal" id="dobStaff">
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="city" class="col-sm-1 col-form-label">City:</label>
                            <div class="col-sm-11">
                                <input type="text" readonly class="form-control-plaintext inputInfoModal"
                                       id="cityStaff">
                            </div>
                        </div>
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    <button type="button" class="btn btn-info" id="editInfoStaff">Edit >></button>
                    <button type="button" class="btn btn-primary d-none" id="saveInfoStaff">Save</button>
                </div>
            </div>
        </div>
    </div>
@endsection
