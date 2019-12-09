@extends("layouts.app")

@section("title")
    Result
@endsection

@section("content")
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">Result</h3>

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
                            <th>Market</th>
                            <th>Region</th>
                            <th>SubRegion</th>
                            <th>Country</th>
                            <th>OEM</th>
                            <th>ODM</th>
                            <th>Carrier</th>
                            <th>Date</th>
                            <th>Item</th>
                            <th>Value</th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach ($modelResults as $modelResult)
                            <tr>
                                <th>{{ $modelResult->location->parent->parent->parent->name }}</th>
                                <th>{{ $modelResult->location->parent->parent->name }}</th>
                                <th>{{ $modelResult->location->parent->name }}</th>
                                <th>{{ $modelResult->location->name }}</th>
                                <th>{{ $modelResult->project->oem? $modelResult->project->oem->name: '' }}</th>
                                <th>{{ $modelResult->project->odm? $modelResult->project->odm->name: '' }}</th>
                                <th>{{ $modelResult->project->carrier? $modelResult->project->carrier->name: '' }}</th>
                                <th>{{ $modelResult->date }}</th>
                                <th>{{ $modelResult->item->name }}</th>
                                <th>{{ $modelResult->result }}</th>
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
