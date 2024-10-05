@extends('layouts.app')
@section('title',$title)
@push('styles')
<style>
    .pagination{
        padding: 0;
        margin: 0;
    }
</style>
@endpush

@section('content')
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header py-2">
                    <h5 class="card-title mb-0">{{ $title }}</h5>
                </div>
                <div class="card-body">
                    <form action="{{ route('user.reports.index') }}" method="GET">
                        <div class="row mb-3">
                            <div class="col-md-3">
                                <select name="form" id="form" class="form-control form-control-sm rounded-0">
                                    <option value="">Select Form</option>
                                    @forelse ($forms as $key=>$value)
                                        <option value="{{ $key }}" {{ request()->get('form') == $key ? 'selected' : '' }}>{{ $value }}</option>
                                    @empty

                                    @endforelse
                                </select>
                            </div>
                            <div class="col-md-3">
                                <select name="category" id="category" class="form-control form-control-sm rounded-0">
                                    <option value="">Select Category</option>
                                    @forelse ($categories as $key=>$value)
                                        <option value="{{ $key }}" {{ request()->get('category') == $key ? 'selected' : '' }}>{{ $value }}</option>
                                    @empty

                                    @endforelse
                                </select>
                            </div>
                            <div class="col-md-3">
                                <button type="submit" class="btn btn-sm btn-primary rounded-0">Filter</button>
                                <a href="{{ route('app.reports.index') }}" class="btn btn-sm btn-danger rounded-0">Reset</a>
                            </div>
                        </div>
                    </form>
                    <div class="table-responsive">
                        <table class="table w-100 table-sm table-bordered table-hover table-striped" id="report-datatable">
                            <thead>
                                <tr>
                                    <th>SL</th>
                                    <th>Form Name</th>
                                    <th>Category</th>
                                    <th>Submit Date</th>
                                    <th>Form Values</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($submissionDatas as $submission)
                                    <tr>
                                        <td>{{ $submissionDatas->firstItem() + $key }}</td>
                                        <td>{{ $submission->form->title }}</td>
                                        <td>{{ $submission->form->category->name }}</td>
                                        <td>{{ dateFormat($submission->created_at) }}</td>
                                        <td>
                                            <ul class="m-0 p-0" style="list-style: none;">
                                                @foreach($submission->values as $value)
                                                    <li><strong>{{ $value->field->label }}:</strong> {{ $value->value }}</li>
                                                @endforeach
                                            </ul>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="6" class="text-center"><strong class="text-danger">Record Not Found!</strong></td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>

                        <div class="d-flex justify-content-end">
                            {{ $submissionDatas->links() }}
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('scripts')
    <script>

    </script>
@endpush
