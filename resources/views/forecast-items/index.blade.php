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
                                        <a class="btn btn-info btn-sm" href="{{ route('forecast-items.edit', array('forecast_item' => $forecastItem->id,'model_id' => $modelId, 'model_vid' => $modelVid)) }}">
                                            <i class="fas fa-pencil-alt"></i>Edit
                                        </a>
                                        <a class="btn btn-danger btn-sm" data-toggle="modal" data-target="#deleteModal" href="javascript:void(0)">
                                            <i class="fas fa-trash">
                                            </i>
                                            Delete
                                        </a>
                                    </div>
                                </th>
                                <th>
                                    @foreach( $forecastItem->locations as $location)
                                        <span class="badge badge-success">{{ $location->name }}</span>
                                    @endforeach
                                </th>
                                <th>
                                    @foreach( $forecastItem->accounts as $account)
                                        <span class="badge badge-success">{{ $account->name }}</span>
                                    @endforeach
                                </th>
                                <th>
                                    @foreach( $forecastItem->items as $item)
                                        <span class="badge badge-success">{{ $item->name }}</span>
                                    @endforeach
                                </th>
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
    <div class="modal fade" id="deleteModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                    <h4 class="modal-title" id="myModalLabel">模态框（Modal）标题</h4>
                </div>
                <div class="modal-body">
                    <form action="{{ route('') }}"></form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal">关闭</button>
                    <button type="button" class="btn btn-primary">Confirm</button>
                </div>
            </div><!-- /.modal-content -->
        </div><!-- /.modal -->
    </div>
@endsection
