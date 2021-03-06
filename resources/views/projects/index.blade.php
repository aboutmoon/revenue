@extends("layouts.app")

@section("title")
    Projects List
@endsection

@section("content")
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">Projects</h3>

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
                            <th>ID</th>
                            <th>Name</th>
                            <th>OME</th>
                            <th>ODM</th>
                            <th>Carrier</th>
                            <th>Type</th>
                            <th>Model</th>
                            <th>Brand</th>
                            <th>Licensee</th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach ($projects as $project)
                            <tr>
                                <th>{{ $project->id }}</th>
                                <th>{{ $project->name }}</th>
                                <th>{{ isset($project->oem)? $project->oem->name: '' }}</th>
                                <th>{{ isset($project->odm)? $project->odm->name: '' }}</th>
                                <th>{{ isset($project->carrier)? $project->carrier->name: '' }}</th>
                                <th>{{ $project->type }}</th>
                                <th>{{ $project->model_name }}</th>
                                <th>{{ $project->brand }}</th>
                                <th>{{ $project->licensee }}</th>
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
