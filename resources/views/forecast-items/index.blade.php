@extends("layouts.app")

@section("title")
    Forecast Items
@endsection

@section("content")
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title"></h3>

                    <div class="card-tools">
                        <div class="input-group input-group-sm" style="width: 150px;">
                        </div>
                    </div>
                </div>
                <!-- /.card-header -->
                <div class="card-body table-responsive p-0">
                    <div>
                        <a class="btn btn-info btn-sm" style="margin-left: 24px; margin-top: 20px;" href="{{ route('forecast-items.create', array('model_id' => $modelId, 'model_vid' => $modelVid)) }}">
                            <i class="fas fa-pencil-alt"></i>Create
                        </a>
                    </div>
                    <table class="table table-hover">
                        <thead>
                        <tr>
                            <th>Operation</th>
                            <th>Locations</th>
                            <th>OEM</th>
                            <th>ODM</th>
                            <th>Carrier</th>
                            <th>Licensee</th>
                            <th>Type</th>
                            <th>Items</th>
                            <th>Coverage</th>
                            <th>From</th>
                            <th>To</th>
                            <th>Monthly Growth</th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach( $forecastItems as $forecastItem)
                            <tr>
                                <td>
                                    <div class="btn-group">
                                        <a class="btn btn-info btn-sm" href="{{ route('forecast-items.edit', array('forecast_item' => $forecastItem->id)) }}">
                                            <i class="fas fa-pencil-alt"></i>Edit
                                        </a>
                                        <a class="btn btn-danger btn-sm btn-delete-model" data-url="{{ route('forecast-items.destroy', array('forecast_item' => $forecastItem->id)) }}">
                                            <i class="fas fa-trash">
                                            </i>
                                            Delete
                                        </a>
                                    </div>
                                </td>
                                <td>
                                    @foreach( $forecastItem->locations as $location)
                                        <span class="badge badge-success">{{ $location->name }}</span>
                                    @endforeach
                                </td>
                                <td>
                                    <span class="badge badge-success">{{ $forecastItem->oem? $forecastItem->oem->name: '' }}</span>
                                </td>
                                <td>
                                    <span class="badge badge-success">{{ $forecastItem->odm? $forecastItem->odm->name: '' }}</span>
                                </td>
                                <td>
                                    <span class="badge badge-success">{{ $forecastItem->carrier? $forecastItem->carrier->name: '' }}</span>
                                </td>
                                <td>
                                    <span class="badge badge-success">{{ $forecastItem->licensee? $forecastItem->licensee->name: '' }}</span>
                                </td>
                                <td>
                                    <span class="badge badge-success">{{ $forecastItem->type? $forecastItem->type->name: '' }}</span>
                                </td>
                                <td>
                                    @foreach( $forecastItem->items as $item)
                                        <span class="badge badge-success">{{ $item->name }}</span>
                                    @endforeach
                                </td>
                                <td>{{ $forecastItem->coverage }}</td>
                                <td>{{ $forecastItem->date_from }}</td>
                                <td>{{ $forecastItem->date_to }}</td>
                                <td>{{ $forecastItem->monthly_growth }}</td>
                            </tr>
                        @endforeach
                        </tbody>
                    </table>
                </div>
                <!-- /.card-body -->
            </div>
            <!-- /.card -->
            <div class="card">
                <div class="card-body table-responsive p-0">

                </div>
            </div>
        </div>
    </div>
    <div class="modal fade" id="deleteModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">

                <div class="modal-body">
                    <h1>Confirm to Delete.</h1>
                    <form action="" method="post">
                        @csrf
                        @method('DELETE')
                        <button type="button" class="btn btn-default btn-close" data-dismiss="modal">Cancel</button>
                        <input type="submit" value="Confirm">
                    </form>
                </div>
            </div><!-- /.modal-content -->
        </div><!-- /.modal -->
    </div>
@endsection

@section('script')
    <script>
        $(function(){
            $('.btn-delete-model').click(function(){
                $('#deleteModal .modal-body form').attr('action', $(this).attr('data-url'));
                $('#deleteModal').modal('show');
            });
            $('#deleteModal').on('show.bs.modal', function () {

            })
        })
    </script>
@endsection
