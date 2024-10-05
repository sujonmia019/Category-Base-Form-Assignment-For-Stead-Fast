@extends('layouts.app')
@section('title',$title)
@push('styles')

@endpush

@section('content')
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header py-2">
                    <h5 class="card-title mb-0">{{ $title }}</h5>
                </div>
                <div class="card-body">
                    <table class="table w-100 table-sm table-bordered table-hover table-striped" id="report-datatable">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>Form Name</th>
                                <th>Category</th>
                                <th>User ID</th>
                                <th>Submission Date</th>
                                <th>Values</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($submissions as $submission)
                                <tr>
                                    <td>{{ $loop->iteration }}</td>
                                    <td>{{ $submission->form->name }}</td>
                                    <td>{{ $submission->form->category->name }}</td>
                                    <td>{{ $submission->user_id ?? 'N/A' }}</td>
                                    <td>{{ $submission->created_at->format('Y-m-d H:i') }}</td>
                                    <td>
                                        <ul>
                                            @foreach($submission->values as $value)
                                                <li><strong>{{ $value->field->label }}:</strong> {{ $value->value }}</li>
                                            @endforeach
                                        </ul>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('scripts')

@endpush
