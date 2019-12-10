@extends("layouts.app")

@section("title")
    Create Model
@endsection

@section("content")
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">Create Model</h3>

                    <div class="card-tools">

                    </div>
                </div>
                <form action="{{ route('data-models.store') }}" method="post">
                    <!-- /.card-header -->
                    <div class="card-body">
                        <div class="form-group row">
                            <label for="inputModel" class="col-sm-2 col-form-label">Model</label>
                            <div class="col-sm-10">
                                <input class="form-control" id="inputModel" type="text" name="name" value="">
                            </div>
                        </div>
                    </div>
                    <!-- /.card-body -->

                    <div class="card-footer">
                        @csrf
                        <input type="submit" class="btn btn-info float-right" value="Save">
                    </div>
                </form>
            </div>
            <!-- /.card -->
        </div>
    </div>
@endsection

@section('script')

@endsection
