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
                        <a class="btn btn-info btn-sm" style="margin-left: 24px; margin-top: 20px;" href="{{ route('forecast-criterias.create', array('model_id' => $modelId, 'model_vid' => $modelVid)) }}">
                            <i class="fas fa-pencil-alt"></i>Create
                        </a>
                    </div>
                    <table class="table table-hover">
                        <thead>
                        <tr>
                            <th>Operation</th>
                            <th>Locations</th>
                            <th>Accounts</th>
                            <th>Item</th>
                            <th>Parameters</th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach( $forecastCriterias as $forecastCriteria)
                            <tr>
                                <td>
                                    <div class="btn-group">
                                        <a class="btn btn-info btn-sm" href="{{ route('forecast-criterias.edit', array('forecast_criteria' => $forecastCriteria->id)) }}">
                                            <i class="fas fa-pencil-alt"></i>Edit
                                        </a>
                                        <a class="btn btn-danger btn-sm btn-delete-model" data-url="{{ route('forecast-criterias.destroy', array('forecast_criteria' => $forecastCriteria->id)) }}">
                                            <i class="fas fa-trash">
                                            </i>
                                            Delete
                                        </a>
                                    </div>
                                </td>
                                <td>
                                    @foreach( $forecastCriteria->locations as $location)
                                        <span class="badge badge-success">{{ $location->name }}</span>
                                    @endforeach
                                </td>
                                <td>
                                    @foreach( $forecastCriteria->accounts as $account)
                                        <span class="badge badge-success">{{ $account->name }}</span>
                                    @endforeach
                                </td>
                                <td>
                                    {{ $forecastCriteria->item->name }}
                                </td>

                                <td>
                                    @if( count($forecastCriteria->parameters) )
                                        <table>
                                            <thead>
                                                <tr>
                                                    <th>Parameter</th>
                                                    <th>Value</th>
                                                    <th>Monthly Growth</th>
                                                    <th>Date From</th>
                                                    <th>Date To</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                @foreach( $forecastCriteria->parameters as $parameter)
                                                    <tr>
                                                        <td>{{ $parameter->criteria->name }}</td>
                                                        <td>{{ $parameter->value }}</td>
                                                        <td>{{ $parameter->monthly_growth }}</td>
                                                        <td>{{ $parameter->date_from }}</td>
                                                        <td>{{ $parameter->date_to }}</td>
                                                    </tr>
                                                @endforeach
                                            </tbody>
                                        </table>
                                    @endif
                                </td>
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
$(function(){
    $('.btn-delete-model').click(function(){
        $('#deleteModal .modal-body form').attr('action', $(this).attr('data-url'));
        $('#deleteModal').modal('show');
    });
    $('#deleteModal').on('show.bs.modal', function () {

    })
})
@endsection
