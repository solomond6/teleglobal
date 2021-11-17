<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>Tele Global Task</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.0/dist/css/bootstrap.min.css">
</head>

<body>
    <div class="container mt-5">

        <div class="card" style="width: 100%;">
          <div class="card-header">
            <h2>Tasks</h2>
            <button type="button" class="btn btn-primary float-right" data-toggle="modal" data-target="#exampleModal">
                New Task
            </button>
          </div>
          <div class="card-body">
            @if(session('success'))
              <div class="alert alert-success">
                {{ session('success') }}
              </div>
            @endif
            @if(session('error'))
              <div class="alert alert-danger">
                {{ session('error') }}
              </div>
            @endif
            <table class="table table-bordered mb-5">
                <thead>
                    <tr class="table-success">
                        <th scope="col">#</th>
                        <th scope="col">Name</th>
                        <th scope="col">Description</th>
                        <th scope="col">User</th>
                        <th scope="col">Status</th>
                        <th scope="col"></th>
                        <th scope="col"></th>
                    </tr>
                </thead>
                <tbody>

                    @foreach($tasks as $data)
                    <tr>
                        <th scope="row">{{ $data->id }}</th>
                        <td>{{ $data->name }}</td>
                        <td>{{ $data->description }}</td>
                        <td>{{ $data->users->name }}</td>
                        <td>{{ $data->status }}</td>
                        <td>
                          <button type="button" class="btn btn-warning btn-sm updateStatus" id="updateStatus" data-toggle="modal" data-target="#exampleUpdate" data-taskid="{{$data->id}}">
                              Update Status
                          </button>
                        </td>
                        <td>
                          <a href="/delete/{{ $data->id}}" class="btn btn-danger btn-sm">Delete</a>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
          </div>
          <div class="card-footer">
            {{-- Pagination --}}
            <div class="d-flex justify-content-center">
                {!! $tasks->links() !!}
            </div>
          </div>
        </div>
    </div>


    <!-- Modal -->
    <div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
      <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
        <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title" id="exampleModalLabel">New Task</h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
              <span aria-hidden="true">&times;</span>
            </button>
          </div>
          {!! Form::open(['url'=>'/create', 'class'=>'form', 'enctype'=>'multipart/form-data']) !!}
          <div class="modal-body">
              <div class="form-group has-feedback">
                {!! Form::label('Task Name') !!}
                {!! Form::text('name', null, ['class'=>'form-control', 'required'=> 'required']) !!}
              </div>
              <div class="form-group has-feedback">
                {!! Form::label('Task Description') !!}
                {!! Form::textarea('description', null, ['class'=>'form-control', 'required'=> 'required']) !!}
              </div>
              <div class="form-group has-feedback">
                {!! Form::label('Assigned To') !!}
                {!! Form::select('user_id', $users, '0', ['class'=>'form-control', 'required'=> 'required', 'placeholder'=>'Select A User']) !!}
              </div>
          </div>
          <div class="modal-footer">
            {!! Form::submit('Submit', ['class'=>'btn btn-primary btn-block btn-flat']) !!}
          </div>
          {!! Form::close() !!}
        </div>
      </div>
    </div>
    <!-- End of Modal -->

    <!-- update model -->
    <div class="modal fade" id="exampleUpdate" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
      <div class="modal-dialog modal-dialog-centered modal-sm" role="document">
        <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title" id="exampleModalLabel">Update Task Status</h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
              <span aria-hidden="true">&times;</span>
            </button>
          </div>
          {!! Form::open(['url'=>'/update', 'class'=>'form', 'enctype'=>'multipart/form-data']) !!}
          <div class="modal-body">
              
              <div class="form-group has-feedback">
                {!! Form::label('Status') !!}
                {!! Form::hidden('id', null, ['class'=>'form-control', 'id'=>'taskId', 'required'=> 'required']) !!}
                {!! Form::select('status', ['in_progres' => 'in_progres','pending' => 'pending', 'done'=>'done'], '0', ['class'=>'form-control', 'required'=> 'required', 'placeholder'=>'Select A Status']) !!}
              </div>
          </div>
          <div class="modal-footer">
            {!! Form::submit('Submit', ['class'=>'btn btn-primary btn-block btn-flat']) !!}
          </div>
          {!! Form::close() !!}
        </div>
      </div>
    </div>
</body>


<!-- intialise all js script -->
<script src="https://code.jquery.com/jquery-3.6.0.min.js" integrity="sha256-/xUj+3OJU5yExlq6GSYGSHk7tPXikynS7ogEvDej/m4=" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.0/dist/js/bootstrap.min.js"></script>

<!-- js to pick the task id for update -->
<script>
  $(document).on("click", '.updateStatus', function(){
    var taskId = $(this).data("taskid");
    console.log(taskId);
    $('#taskId').val(taskId);

  });

</script>
</html>