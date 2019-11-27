@extends("layouts.app")

@section("title")
    Forecast Items
@endsection

@section("content")
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">Forecast Items</h3>

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
                            <th>Operation</th>
                            <th>Locations</th>
                            <th>Accounts</th>
                            <th>Items</th>
                            <th>Coverage</th>
                            <th>From</th>
                            <th>To</th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach( $forecastItems as $forecastItem)
                            <tr>
                                <th>
                                    <div class="btn-group">
                                        <button type="button" class="btn btn-info">Edit</button>
                                        <button type="button" class="btn btn-info">Delete</button>
                                    </div>
                                </th>
                                <th>{{ $forecastItem->locations }}</th>
                                <th>{{ $forecastItem->accounts }}</th>
                                <th>{{ $forecastItem->items }}</th>
                                <th>{{ $forecastItem->coverage }}</th>
                                <th>{{ $forecastItem->date_from }}</th>
                                <th>{{ $forecastItem->date_to }}</th>
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
