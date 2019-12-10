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
                <form action="{{ route('forecast-criterias.store') }}" method="post">
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
                                    <option value="-2">OEM</option>
                                    <option value="-3">ODM</option>
                                    <option value="-4">Carrier</option>
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
                                <select class="select2" id="selectItems" name="item_id" style="width: 100%;">
                                    @foreach($items as $item)
                                        <option value="{{ $item->id }}">{{ $item->parent->name . '::' . $item->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="dateFrom" class="col-sm-2 col-form-label">Parameters</label>
                            <div class="col-sm-10">
                                <table id="parameters-table">
                                    <thead>
                                    <tr>
                                        <th style="display: none">Forecast Criteria ID</th>
                                        <th style="display: none">Criteria ID</th>
                                        <th>Parameter</th>
                                        <th>Value</th>
                                        <th>Monthly Growth</th>
                                        <th>Date From</th>
                                        <th>Date To</th>
                                    </tr>
                                    </thead>
                                    <tbody>

                                    </tbody>
                                </table>
                            </div>
                        </div>

                    </div>
                    <!-- /.card-body -->

                    <div class="card-footer">
                        <input type="hidden" name="model_id" value="{{ $model->id }}">
                        <input type="hidden" name="model_vid" value="{{ $model->vid }}">
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


            $('.select2').select2({
                theme: 'bootstrap4'
            })

            $(document).on('focus', '.datepicker', function(){
                $(this).datepicker({
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

                $(this).on('changeDate', function(){
                    var d = $(this).datepicker('getDate');
                    var y = d.getFullYear();
                    var m = d.getMonth() + 1;
                    var day = 1;
                    $(this).next().val(y + '-' + m + '-' + day);
                });
            })

            var criterias =  {!! $criterias !!};

            $('#selectItems').on('select2:select', function (e) {
                var parameters;
                var item_id = $(this).val();
                for (var i = 0; i < criterias.length; i++) {
                    if (criterias[i].item_id == item_id) {
                        parameters += `
                    <tr>
                        <td style="display: none">
                            <input type="text" name="parameters[${i}][forecast_criteria_id]" value="">
                        </td>
                        <td style="display: none">
                            <input type="text" name="parameters[${i}][criteria_id]" value="${ criterias[i].id }">
                        </td>
                        <td>
                            <input type="text" value="${ criterias[i].name }">
                        </td>
                        <td>
                            <input type="text" name="parameters[${i}][value]">
                        </td>
                        <td>
                            <input type="text" name="parameters[${i}][monthly_growth]">
                        </td>
                        <td>
                            <input type="text" class="datepicker">
                            <input type="hidden" id="dateFrom" name="parameters[${i}][date_from]">
                        </td>
                        <td>
                            <input type="text" class="datepicker">
                            <input type="hidden" id="dateFrom" name="parameters[${i}][date_to]">
                        </td>
                    </tr>
                    `;
                    }
                    $('#parameters-table tbody').html(parameters);
                }
            }).trigger('select2:select');

            var accounts = {!! $json_accounts !!};

            function quickSelect(object, id) {
                var selects = [];
                var origin = object.val();
                for(var i = 0; i < accounts.length; i++) {
                    if (accounts[i].parent_id == id) {
                        selects.push(accounts[i].id);
                    }
                }
                selects = selects.concat(origin);
                selects = selects.filter(function (item, index, selects) {
                    return selects.indexOf(item, 0) === index;
                });

                object.val(selects).change();
            }

            function quickUnselect(object, id) {
                var selects = [];
                var origin = object.val();
                for(var i = 0; i < accounts.length; i++) {
                    if (accounts[i].parent_id == id) {
                        selects.push(accounts[i].id);
                    }
                }

                origin = origin.filter(function (item, index, origin) {
                    return selects.indexOf(parseInt(item)) === -1;
                });
                object.val(origin).change();
            }

            $('#selectAccounts').on('select2:select', function (e) {
                var data = e.params.data;
                if (data.text == "ODM") {
                    quickSelect($(this), 2);
                }
                if (data.text == "OEM") {
                    quickSelect($(this), 3);
                }
                if (data.text == "Carrier") {
                    quickSelect($(this), 4);
                }

            });

            $('#selectAccounts').on('select2:unselect', function (e) {
                var data = e.params.data;
                if (data.text == "ODM") {
                    quickUnselect($(this), 2);
                }
                if (data.text == "OEM") {
                    quickUnselect($(this), 3);
                }
                if (data.text == "Carrier") {
                    quickUnselect($(this), 4);
                }
            });
        })
    </script>
@endsection

