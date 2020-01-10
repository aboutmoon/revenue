@extends("layouts.app")

@section("title")
    Forecast Items Edit
@endsection

@section("content")
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">Forecast Items Edit</h3>

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
                            <label for="selectAccounts" class="col-sm-2 col-form-label">OEM</label>
                            <div class="col-sm-10">
                                <select class="select2" id="oem_id" name="oem_id"  style="width: 100%;">
                                    <option value="">All</option><option value="-1">IS NULL</option>
                                    @foreach($oemOptions as $option)
                                        <option value="{{ $option->id }}" {{ $option->id == $forecastItem->oem_id? 'selected': '' }}>{{ $option->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="selectAccounts" class="col-sm-2 col-form-label">ODM</label>
                            <div class="col-sm-10">
                                <select class="select2" id="odm_id" name="odm_id"  style="width: 100%;">
                                    <option value="">All</option><option value="-1">IS NULL</option>
                                    @foreach($odmOptions as $option)
                                        <option value="{{ $option->id }}" {{ $option->id == $forecastItem->odm_id? 'selected': '' }}>{{ $option->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="selectAccounts" class="col-sm-2 col-form-label">Carrier</label>
                            <div class="col-sm-10">
                                <select class="select2" id="carrier_id" name="carrier_id"  style="width: 100%;">
                                    <option value="">All</option><option value="-1">IS NULL</option>
                                    @foreach($carrierOptions as $option)
                                        <option value="{{ $option->id }}" {{ $option->id == $forecastItem->carrier_id? 'selected': '' }}>{{ $option->name }}</option>
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
                            <label for="selectTypes" class="col-sm-2 col-form-label">Type</label>
                            <div class="col-sm-10">
                                <select class="select2" id="selectTypes" name="type_id" style="width: 100%;">
                                    <option value="">All</option><option value="-1">IS NULL</option>
                                    @foreach($types as $type)
                                        <option value="{{ $type->id }}" {{ $type->id == $forecastItem->type_id? 'selected': '' }}>{{ $type->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="selectLicensees" class="col-sm-2 col-form-label">Licensee</label>
                            <div class="col-sm-10">
                                <select class="select2" id="selectLicensees" name="licensee_id" style="width: 100%;">
                                    <option value="">All</option><option value="-1">IS NULL</option>
                                    @foreach($licensees as $licensee)
                                        <option value="{{ $licensee->id }}" {{ $licensee->id == $forecastItem->licensee_id? 'selected': '' }}>{{ $licensee->name }}</option>
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
                                <input id="datepicker-date-from" class="datepicker" value="{{ $forecastItem->date_from }}">
                                <input type="hidden" id="dateFrom" name="date_from" value="{{ $forecastItem->date_from }}">
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="dateTo" class="col-sm-2 col-form-label">Date To</label>
                            <div class="col-sm-10">
                                <input id="datepicker-date-to" class="datepicker" value="{{ $forecastItem->date_to }}">
                                <input type="hidden"  id="dateTo" name="date_to" value="{{ $forecastItem->date_to }}">
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
            {{--$('#selectAccounts').val({{ $selectAccounts }});--}}
            $('#selectLocations').val({{ $selectLocations }});

            $('.select2').select2({
                theme: 'bootstrap4'
            });

            {{--var accounts = {!! $json_accounts !!};--}}

            {{--function quickSelect(object, id) {--}}
                {{--var selects = [];--}}
                {{--var origin = object.val();--}}
                {{--for(var i = 0; i < accounts.length; i++) {--}}
                    {{--if (accounts[i].parent_id == id) {--}}
                        {{--selects.push(accounts[i].id);--}}
                    {{--}--}}
                {{--}--}}
                {{--selects = selects.concat(origin);--}}
                {{--selects = selects.filter(function (item, index, selects) {--}}
                    {{--return selects.indexOf(item, 0) === index;--}}
                {{--});--}}

                {{--object.val(selects).change();--}}
            {{--}--}}

            {{--function quickUnselect(object, id) {--}}
                {{--var selects = [];--}}
                {{--var origin = object.val();--}}
                {{--for(var i = 0; i < accounts.length; i++) {--}}
                    {{--if (accounts[i].parent_id == id) {--}}
                        {{--selects.push(accounts[i].id);--}}
                    {{--}--}}
                {{--}--}}

                {{--origin = origin.filter(function (item, index, origin) {--}}
                    {{--return selects.indexOf(parseInt(item)) === -1;--}}
                {{--});--}}
                {{--object.val(origin).change();--}}
            {{--}--}}

            {{--$('#selectAccounts').on('select2:select', function (e) {--}}
                {{--var data = e.params.data;--}}
                {{--if (data.text == "ODM") {--}}
                    {{--quickSelect($(this), 2);--}}
                {{--}--}}
                {{--if (data.text == "OEM") {--}}
                    {{--quickSelect($(this), 3);--}}
                {{--}--}}
                {{--if (data.text == "Carrier") {--}}
                    {{--quickSelect($(this), 4);--}}
                {{--}--}}

            {{--});--}}

            {{--$('#selectAccounts').on('select2:unselect', function (e) {--}}
                {{--var data = e.params.data;--}}
                {{--if (data.text == "ODM") {--}}
                    {{--quickUnselect($(this), 2);--}}
                {{--}--}}
                {{--if (data.text == "OEM") {--}}
                    {{--quickUnselect($(this), 3);--}}
                {{--}--}}
                {{--if (data.text == "Carrier") {--}}
                    {{--quickUnselect($(this), 4);--}}
                {{--}--}}
            {{--});--}}



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

