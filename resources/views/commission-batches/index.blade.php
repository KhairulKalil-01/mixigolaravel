@extends('layouts.app')

@section('styles')
    @include('partials.datatables.css')
@endsection

@section('content')
    <div class="themebody-wrap">
        <div class="theme-body common-dash" data-simplebar>
            <div class="custom-container">
                <div class="row">
                    <div class="col-12 col-md-12">
                        <div class="card">
                            <div class="card-header">
                                <h4>Commission Batches</h4>
                            </div>
                            <div class="card-body">
                                <div class="mb-3">
                                    <button id="createBtn" class="btn btn-primary">
                                        Create Commission Batch for {{ now()->format('F Y') }}
                                    </button>
                                </div>
                                <hr>

                                <div class="salary-history">
                                    @forelse ($batches as $batch)
                                        <div class="card mb-3 @if ($batch->is_current) border-success @endif">
                                            <div class="card-body">
                                                <div class="d-flex justify-content-between">
                                                    <div>
                                                        <h5 class="mb-1">
                                                            Commission Batch: {{ $batch->month }} / {{ $batch->year }}
                                                        </h5>
                                                        <p class="mb-1">
                                                            Created At: {{ $batch->created_at->format('d M Y') }}
                                                        </p>
                                                        <p class="mb-1">
                                                            Status: {{ $batch->status_label }}
                                                        </p>
                                                    </div>
                                                    <div class="align-self-center">
                                                        <a href="{{ route('commission-batches.show', $batch) }}" class="btn btn-info">
                                                            View Details
                                                        </a>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    @empty
                                        <p class="text-muted">No commission batch available.</p>
                                    @endforelse
                                </div>

                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection


@section('scripts')
    @include('partials.datatables.js')
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script>
        $('#createBtn').click(function() {
            $.ajax({
                url: "{{ route('commission-batches.store') }}",
                type: "POST",
                data: {
                    _token: "{{ csrf_token() }}"
                },
                success: function(response) {
                    alert(response.message);
                    location.reload();
                },
                error: function(xhr) {
                    alert(xhr.responseJSON.message);
                }
            });
        });
    </script>
@endsection
