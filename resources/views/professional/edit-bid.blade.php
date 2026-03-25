@extends('layouts.app')

@section('title', 'Edit Bid - ' . ($bid->job ? $bid->job->title : 'Unknown Job'))

@section('content')
<div class="container py-4">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card shadow-sm">
                <div class="card-header bg-white">
                    <h4 class="mb-0">Edit Your Bid</h4>
                    @if($bid->job)
                        <p class="text-muted mb-0">Update your bid for "{{ $bid->job->title }}"</p>
                    @endif
                </div>
                <div class="card-body">
                    @if($bid->job)
                        <form action="{{ route('professional.update-bid', $bid->id) }}" method="POST">
                            @csrf
                            @method('PUT')
                            
                            <div class="mb-3">
                                <label class="form-label">Bid Amount ($)</label>
                                <input type="number" name="bid_amount" class="form-control @error('bid_amount') is-invalid @enderror" 
                                       value="{{ old('bid_amount', $bid->amount) }}" required min="1" step="0.01">
                                @error('bid_amount')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            
                            <div class="mb-3">
                                <label class="form-label">Estimated Timeline (days)</label>
                                <input type="number" name="timeline" class="form-control @error('timeline') is-invalid @enderror" 
                                       value="{{ old('timeline', $bid->estimated_days) }}" required min="1">
                                @error('timeline')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            
                            <div class="mb-3">
                                <label class="form-label">Your Proposal</label>
                                <textarea name="proposal" class="form-control @error('proposal') is-invalid @enderror" 
                                          rows="6" required>{{ old('proposal', $bid->proposal) }}</textarea>
                                @error('proposal')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            
                            <div class="d-flex justify-content-between">
                                <a href="{{ route('professional.bids') }}" class="btn btn-secondary">
                                    <i class="fas fa-arrow-left me-2"></i>Cancel
                                </a>
                                <button type="submit" class="btn btn-primary">
                                    <i class="fas fa-save me-2"></i>Update Bid
                                </button>
                            </div>
                        </form>
                    @else
                        <div class="alert alert-danger">
                            The job associated with this bid could not be found.
                        </div>
                        <a href="{{ route('professional.bids') }}" class="btn btn-secondary">Back to Bids</a>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

