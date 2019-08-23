@extends('client.layouts.default')
@section('title', trans('view.titles.staff_report_edit'))
@section('name_feature', trans('view.titles.staff_report_edit'))
@section('content')
    <div class="container-fluid">
        <div class="container mt-3">
            <form method="POST" action="{{ route('client.staffs.update_report',$report_tasks->id) }}">
                {{ csrf_field() }}
                {{ method_field('PUT')}}
                <div class="form-row">
                    <label>Tasks chose:</label>
                </div>
                <div class="form-control col-12 d-flex flex-wrap h-auto mb-3" id="loopCheckBoxTask">
                    @foreach($report_tasks->tasks as $task)
                        <div class="col-3"><input type="checkbox" value="{{ $task->id }}" name="checkBoxTaskId[]" checked
                                                  disabled="disabled">{{ $task->name }}</div>
                    @endforeach
                </div>
                <div class="form-row">
                    <div class="form-group col-md-6">
                        <label for="inputName">Name:</label>
                        <input type="text" class="form-control @error('name') is-invalid @enderror" id="inputName"
                               placeholder="Report's name" name="name" value="{{ $report_tasks->name }}">
                        @error('name')
                        <span class="invalid-feedback"><strong>{{ $message }}</strong></span>
                        @enderror
                    </div>
                    <div class="form-group col-md-2">
                        <label for="inputName">Date:</label>
                        <input type="date" class="form-control @error('date') is-invalid @enderror" id="date" name="date" value="{{ $report_tasks->tasks{0}->pivot->date }}">
                        @error('date')
                        <span class="invalid-feedback"><strong>{{ $message }}</strong></span>
                        @enderror
                    </div>
                    <div class="form-group col-md-4">
                        <label>Time:</label>
                        <div class="d-flex">
                            <div class="d-lex flex-column">
                                <input type="time" class="form-control @error('time_start') is-invalid @enderror" id="time_start" name="time_start"
                                       value="{{ $report_tasks->tasks{0}->pivot->time_start }}">
                                @error('time_start')
                                <span class="invalid-feedback"><strong>{{ $message }}</strong></span>
                                @enderror
                            </div>
                            <span class="d-block">&nbsp;~&nbsp;</span>
                            <div class="d-lex flex-column">
                                <input type="time" class="form-control @error('time_end') is-invalid @enderror" id="time_end" name="time_end"
                                       value="{{ $report_tasks->tasks{0}->pivot->time_end }}">
                                @error('time_end')
                                <span class="invalid-feedback"><strong>{{ $message }}</strong></span>
                                @enderror
                            </div>
                        </div>
                    </div>
                </div>
                <div class="form-row">
                    <div class="form-group col-md-12">
                        <label for="descTask">Description:</label>
                        <textarea class="form-control @error('description') is-invalid @enderror" id="description" rows="3"
                                  name="description">{{ $report_tasks->description }}</textarea>
                        @error('description')
                        <span class="invalid-feedback"><strong>{{ $message }}</strong></span>
                        @enderror
                    </div>
                </div>
                <button type="submit" class="btn btn-info">Save changes</button>
            </form>
            <br>
        </div>
    </div>
@endsection
