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
                <form action="{{ route('forecast-items.update', array('forecast_item' => $forecastItem->id)) }}" method="post">
                    <!-- /.card-header -->
                    <div class="card-body">

                        <div class="form-group row">
                            <label for="inputModel" class="col-sm-2 col-form-label">Model</label>
                            <div class="col-sm-10">
                                <input class="form-control" id="inputModel" type="text" disabled="" value="{{ $model->name }}">
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="selectAccounts" class="col-sm-2 col-form-label">Accounts</label>
                            <div class="col-sm-10">
                                <select class="select2" id="selectAccounts" name="accounts[]" multiple="multiple" style="width: 100%;">
                                    @foreach($accounts as $account)
                                        <option value="{{ $account->id }}">{{ $account->parent->name . '::' . $account->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="selectLocations" class="col-sm-2 col-form-label">Locations</label>
                            <div class="col-sm-10">
                                <select class="select2" id="selectLocations" name="locations[]" multiple="multiple" style="width: 100%;">
                                    @foreach($locations as $location)
                                        <option value="{{ $location->id }}">{{ $location->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="selectItems" class="col-sm-2 col-form-label">Items</label>
                            <div class="col-sm-10">
                                <select class="select2" id="selectItems" name="items[]" multiple="multiple" style="width: 100%;">
                                    @foreach($items as $item)
                                        <option value="{{ $item->id }}">{{ $item->parent->name . '::' . $item->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="dateFrom" class="col-sm-2 col-form-label">Date From</label>
                            <div class="col-sm-10">
                                <input id="datepicker-date-from" class="datepicker" value="{{ $forecastItem->date_to }}">
                                <input type="hidden" id="dateFrom" name="date_from" value="{{ $forecastItem->date_to }}">
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="dateTo" class="col-sm-2 col-form-label">Date To</label>
                            <div class="col-sm-10">
                                <input id="datepicker-date-to" class="datepicker" value="{{ $forecastItem->date_from }}">
                                <input type="hidden"  id="dateTo" name="date_to" value="{{ $forecastItem->date_from }}">
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="coverage" class="col-sm-2 col-form-label">Coverage</label>
                            <div class="col-sm-10">
                                <input type="text" id="coverage" name="coverage" value="{{ $forecastItem->coverage }}">
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="monthly_growth" class="col-sm-2 col-form-label">Monthly Growth</label>
                            <div class="col-sm-10">
                                <input type="text" id="monthly_growth" name="monthly_growth" value="{{ $forecastItem->monthly_growth }}">
                            </div>
                        </div>

                    </div>
                    <!-- /.card-body -->

                    <div class="card-footer">
                        <input type="hidden" name="model_id" value="{{ $model->id }}">
                        <input type="hidden" name="model_vid" value="{{ $model->vid }}">
                        @method('PUT')
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
    <script>
        $(function(){

            $('#selectItems').val({{ $selectItems }});
            $('#selectAccounts').val({{ $selectAccounts }});
            $('#selectLocations').val({{ $selectLocations }});

            $('.select2').select2({
                theme: 'bootstrap4'
            });

            $('.datepicker').datepicker({
                autoclose: true,
                minViewMode: 1,
                format: {
                    toDisplay: function (date, format, language) {
                        var qs = ['Q1', 'Q2', 'Q3', 'Q4'];
                        var d = new Date(date);
                        var y = d.getFullYear();
                        var q = qs[Math.floor(d.getMonth()/3)]
                        var m = d.toDateString().split(" ")[1];
                        return y + '/' + q + '/' + m;
                    },
                    toValue: function (date, format, language) {
                        var d = new Date(date);
                        var y = d.getFullYear();
                        var m = d.getMonth() + 1;
                        var day = d.getDay();
                        return y + '-' + m + '-' + day;
                    }
                }
            });

            $('#datepicker-date-to').datepicker('setDate', new Date($('#dateTo').val()));
            $('#datepicker-date-from').datepicker('setDate', new Date($('#dateFrom').val()));
            $('.datepicker').datepicker('changeDate');
            $('#datepicker-date-to').on('changeDate', function(){
                var d = $(this).datepicker('getDate');
                var y = d.getFullYear();
                var m = d.getMonth() + 1;
                var day = 1;
                $('#dateTo').val(y + '-' + m + '-' + day);
            });

            $('#datepicker-date-from').on('changeDate', function(){
                var d = $(this).datepicker('getDate');
                var y = d.getFullYear();
                var m = d.getMonth() + 1;
                var day = 1;
                $('#dateFrom').val(y + '-' + m + '-' + day);
            });

        })
    </script>
@endsection

