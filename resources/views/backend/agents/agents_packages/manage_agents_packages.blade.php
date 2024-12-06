@extends('layouts/contentNavbarLayout')

@section('title', $page_title)

@section('page-script')
    <script src="{{ asset('assets/js/pages-account-settings-account.js') }}"></script>
@endsection

@section('content')
    <h4 class="fw-bold py-3 mb-4">
        <span class="text-muted fw-light">Agents /</span> {{ $page_title }}
    </h4>

    <div class="row">
        <div class="col-md-12">
            {!! Helper::getDismissableErrorAlert($errors) !!}
            <form action="{{ $action }}" id="manage_form" method="POST" enctype="multipart/form-data">
                @csrf
                @if (!empty($data['id']))
                    @method('PUT')
                @endif
                <div class="card mb-4">
                    <h5 class="card-header">Package Information</h5>
                    <!-- Account -->
                    <div class="card-body">
                        <div class="row">
                            <div class="mb-3 col-md-6">
                                <label for="start_date" class="col-form-label">Start Date <span class="text-danger">*</span></label>
                                <div class="hithere">
                                    <input class="form-control required" type="date" name="start_date" value="{{ $data['start_date']??old('start_date') }}" id="start_date"/>
                                </div>
                            </div>
                            <div class="mb-3 col-md-6">
                                <label for="end_date" class="col-form-label">End Date <span class="text-danger">*</span></label>
                                <div class="hithere">
                                    <input class="form-control required" type="date" name="end_date" value="{{ $data['end_date']??old('end_date') }}" id="end_date"/>
                                </div>
                            </div>
                            <div class="mb-3 col-md-6">
                                <label for="days" class="form-label">Days </label>
                                <input class="form-control required" type="text" id="days" name="days"
                                    value="{{ $data['days'] ?? old('days') }}" readonly/>
                            </div>
                            <div class="mb-3 col-md-6">
                                <label class="form-label" for="availability">Availability </label>
                                <select id="availability" class="select2 form-select required" name="availability">
                                    <option value="">Select</option>
                                    @foreach (config('constant.agents.package_availability') as $aV)
                                    <option value="{{ $aV }}" {{ isset($data['availability']) && $data['availability'] == $aV ? 'selected' : '' }}>{{ $aV }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="mb-3 col-md-6">
                                <label for="name" class="form-label">Package Name </label>
                                <input class="form-control required" type="text" name="name" id="name"
                                    value="{{ $data['name'] ?? old('name') }}" />
                            </div>
                            <div class="mb-3 col-md-6">
                                <label for="rate" class="form-label">Rate </label>
                                <input class="form-control required" type="number" id="rate" name="rate"
                                value="{{ $data['rate'] ?? old('rate') }}" />
                            </div>
                            <div class="mb-3 col-md-6">
                                <label for="description" class="form-label">Description </label>
                                <textarea class="form-control" name="description" id="description" rows="3">{{ $data['description'] ?? old('description') }}</textarea>
                            </div>
                            <div class="mb-3 col-md-6">
                                <label for="discount" class="form-label">Includes </label>
                                <select name="include[]" id="include" class="form-select" multiple>
                                    <option value="Lunch">Lunch</option>
                                    <option value="Dinner">Dinner</option>
                                    <option value="Hotel Stay">Hotel Stay</option>
                                    <option value="Train Tickets">Train Tickets</option>
                                </select>
                            </div>
                            <div class="mb-3 col-md-6">
                                <label class="form-label" for="agent_id">Agent </label>
                                @php
                                    if(Helper::isRole('agent')){
                                        $agents_list = Arr::only($agents_list, auth()->user()->id);
                                    }
                                @endphp
                                <select id="agent_id" class="select2 form-select required" name="agent_id" {{ !empty($data['id']) || Helper::isRole('agent') ? 'disabled' : '' }}>
                                    <option value="">Select Agent</option>
                                    @foreach ($agents_list as $sV => $sL)
                                    <option value="{{ $sV }}" {{ isset($data['agent_id']) && $data['agent_id'] == $sV || Helper::isRole('agent') ? 'selected' : '' }}>{{ $sL }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="mb-3 col-md-6">
                                <label class="form-label" for="master_package_id">City </label>
                                <select id="master_package_id" class="select2 form-select required" name="master_package_id">
                                    <option value="">Select</option>
                                    @foreach ($master_packages_list as $pV => $pL)
                                    <option value="{{ $pV }}" {{ isset($data['master_package_id']) && $data['master_package_id'] == $pV ? 'selected' : '' }}>{{ $pL }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="mb-3 col-md-6">
                                <label class="form-label" for="status">Package Status </label>
                                <select id="status" class="select2 form-select required" name="status">
                                    <option value="">Select</option>
                                    @foreach (config('constant.status') as $sV => $sL)
                                    <option value="{{ $sV }}" {{ isset($data['status']) && $data['status'] == $sV ? 'selected' : '' }}>{{ $sL }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                    </div>
                </div>
                {!! Helper::getFormSubmitButton() !!}
                {!! Helper::getFormCancelButton(route('agents_packages.index')) !!}
                
            </form>
        </div>
    </div>
    <script>
        // Initiating datepicker of flatpickr
        $('.flatpickr').flatpickr();
    </script>
    <script>
        $("#manage_form").validate({
            errorPlacement: function(error, element) {
                if (element.attr("name") == "phone") {
                        var a = element.parent("div.input-group-merge")
                        error.insertAfter(a);
                    } else {
                    error.insertAfter(
                    element); // For other fields, place the error message after the input element
                }
            },
            submitHandler: function(form) {
                // Form submission logic goes here if needed
                form.submit();
            }
        });

    </script>
    <script>
        $(document).ready(function(){
            $(document).on('change', '#start_date, #end_date', function(){
                const start_date = $('#start_date').val();
                const end_date = $('#end_date').val();
                if(start_date != '' && end_date != ''){
                    $('#days').val(calculateDaysBetweenDates() + ' days');
                }
            });

            function calculateDaysBetweenDates(){
                const startDate = new Date($('#start_date').val());
                const endDate = new Date($('#end_date').val());
                const differenceInTime = Math.abs(endDate - startDate);
                return differenceInTime/1000/60/60/24 + 1;
            }
        });
    </script>
    @endsection
