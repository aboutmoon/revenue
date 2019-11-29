@extends("layouts.app")

@section("title")
    Model List
@endsection

@section("content")
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">Model List</h3>

                    <div class="card-tools">
                        <div class="input-group input-group-sm" style="width: 150px;">
                            <input type="text" name="table_search" class="form-control float-right" placeholder="Search">

                            <div class="input-group-append">
                                <button type="submit" class="btn btn-default"><i class="fas fa-search"></i></button>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- /.card-header -->
                <div class="card-body table-responsive p-0">
                    <table class="table table-hover">
                        <thead>
                        <tr>
                            <th>Operations</th>
                            <th>Model</th>
                            <th>Author</th>
                        </tr>
                        </thead>
                        <tbody>
                            @foreach ($models as $model)
                                <tr>
                                    <th>
                                        <div class="btn-group">
                                            <button type="button" class="btn btn-info">Edit</button>
                                            <button type="button" class="btn btn-info">Delete</button>
                                            <button type="button" class="btn btn-info">Copy</button>
                                        </div>
                                    </th>
                                    <th>{{ $model->name }}</th>
                                    <th>{{ $model->user->email }}</th>
                                    <th>
                                        <div class="btn-group">
                                            <a class="btn btn-info btn-sm"  href="#">Device Forecast</a>
                                            <a class="btn btn-dark btn-sm"  href="{{ route('forecast-items.index', array('model_id' => $model->id, 'model_vid' => $model->vid)) }}">Item Forecast</a>
                                            <a class="btn btn-primary btn-sm"  href="{{ route('forecast-criterias.index', array('model_id' => $model->id, 'model_vid' => $model->vid)) }}">Criteria Forecast</a>
                                            <a class="btn btn-warning btn-sm"  href="#">Result</a>
                                        </div>
                                    </th>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
                <!-- /.card-body -->
            </div>
            <!-- /.card -->
        </div>
    </div>
@endsection
