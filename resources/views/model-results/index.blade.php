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
                    <div id="output"></div>
                    {{--<table class="table table-hover " id="model-result" style="display: none">--}}
                        {{--<thead>--}}
                        {{--<tr>--}}
                            {{--<th>Market</th>--}}
                            {{--<th>Country</th>--}}
                            {{--<th>OEM</th>--}}
                            {{--<th>ODM</th>--}}
                            {{--<th>Carrier</th>--}}
                            {{--<th>Type</th>--}}
                            {{--<th>Date</th>--}}
                            {{--<th>Item</th>--}}
                            {{--<th>Value</th>--}}
                        {{--</tr>--}}
                        {{--</thead>--}}
                        {{--<tbody>--}}
                        {{--@foreach ($modelResults as $modelResult)--}}
                            {{--<tr>--}}
                                {{--<td>{{ $modelResult->location->parent->name }}</td>--}}
                                {{--<td>{{ $modelResult->location->name }}</td>--}}
                                {{--<td>{{ $modelResult->project->oem? $modelResult->project->oem->name: '' }}</td>--}}
                                {{--<td>{{ $modelResult->project->odm? $modelResult->project->odm->name: '' }}</td>--}}
                                {{--<td>{{ $modelResult->project->carrier? $modelResult->project->carrier->name: '' }}</td>--}}
                                {{--<td>{{ $modelResult->project->type? $modelResult->project->type: '' }}</td>--}}
                                {{--<td>{{ $modelResult->date }}</td>--}}
                                {{--<td>{{ $modelResult->item->name }}</td>--}}
                                {{--<td>{{ $modelResult->result }}</td>--}}
                            {{--</tr>--}}
                        {{--@endforeach--}}
                        {{--</tbody>--}}
                    {{--</table>--}}
                </div>
                <!-- /.card-body -->
            </div>
            <!-- /.card -->
        </div>
    </div>
@endsection


@section('style')
    <link rel="stylesheet" href="{{ asset('/bower_components/pivottable/dist/pivot.min.css') }}">
@endsection

@section('script')
    <script src="{{ asset('/bower_components/pivottable/dist/pivot.min.js') }}"></script>

    <script>
        $(function () {

            var data =  {!! $modelResults !!};
            var dateFormat = $.pivotUtilities.derivers.dateFormat;
            var sortAs = $.pivotUtilities.sortAs;
            $("#output").pivotUI(
                data,
                {
                    aggregatorName: "Sum",
                    rendererName: "Table",
                    rows: ['Item'],
                    cols: ['Year', 'Quarter', 'Month'],
                    // cols: ['Date'],
                    vals: ['Value'],
                    derivedAttributes: {
                        "Month": dateFormat("Date", "%n"),
                        "Quarter": function ($input) {
                            var quarters = ['q1', 'q2', 'q3', 'q4'];
                            var m = (new Date($input.Date)).getMonth();
                            return quarters[Math.floor(m/3)]
                        },
                        "Year": dateFormat("Date", "%y")
                    },

                    sorters: {
                        "Month": sortAs(["Jan", "Feb", "Mar", "Apr", "May", "Jun", "Jul", "Aug", "Sep", "Oct", "Nov", "Dec"]),
                        "Item": sortAs(["Shipment", "Install base", "Activated Device", "MAU", "Ads DAU", "Search Revenue sharing", "Ads Revenue sharing","FOTA Fee", "FOTA Royalty Fee", "NRE", "Maintenance", "Payment Revenue sharing V1", "Payments Revenue Sharing (Store V2)", "Payments Revenue Sharing (IAP V2)", "3rd Party License"])
                    }
                }
            );
        })

    </script>
@endsection
