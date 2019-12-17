@extends("layouts.app")

@section("title")
    Forecast Devices
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
                        <a class="btn btn-info btn-sm" style="margin-left: 24px; margin-top: 20px;" href="{{ route('forecast-devices.create', array('model_id' => $modelId, 'model_vid' => $modelVid)) }}">
                            <i class="fas fa-pencil-alt"></i>Create
                        </a>
                    </div>
                    <table class="table table-hover">
                        <thead>
                        <tr>
                            <th>Project</th>
                            <th>ODM</th>
                            <th>OEM</th>
                            <th>Carrier</th>
                            <th>Location</th>
                            <th>Date From</th>
                            <th>Date To</th>
                            <th>Date</th>
                            <th>Quantity</th>
                        </tr>
                        </thead>
                        <tbody>
                            @foreach( $forecastDevices as $forecastDevice )
                                <tr>
                                    <td>{{ $forecastDevice->project->name }}</td>
                                    <td>{{ $forecastDevice->project->odm? $forecastDevice->project->odm->name: '' }}</td>
                                    <td>{{ $forecastDevice->project->oem? $forecastDevice->project->oem->name: '' }}</td>
                                    <td>{{ $forecastDevice->project->carrier? $forecastDevice->project->carrier->name: '' }}</td>
                                    <td>{{ $forecastDevice->location->name }}</td>
                                    <td>{{ $forecastDevice->date_from }}</td>
                                    <td>{{ $forecastDevice->date_to }}</td>
                                    <td>{{ $forecastDevice->date }}</td>
                                    <td>{{ $forecastDevice->quantity }}</td>
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
