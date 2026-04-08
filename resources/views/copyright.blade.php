<!DOCTYPE html>
@extends('layouts.app')

@section('title', 'Copyright Policy - BuildConnect')

@section('content')
<div class="container py-5">
    <div class="row justify-content-center">
        <div class="col-lg-8">
            <div class="card border-0 shadow">
                <div class="card-body p-5">
                    <h1 class="mb-4">Copyright Policy</h1>
                    <div class="mb-4">
                        <h3 class="h5 fw-bold mb-3">1. Ownership</h3>
                        <p>All content on BuildConnect, including text, graphics, logos, and software, is owned by BuildConnect or its licensors and protected by copyright laws.</p>
                    </div>
                    <div class="mb-4">
                        <h3 class="h5 fw-bold mb-3">2. User Content</h3>
                        <p>Users retain ownership of content they upload, but grant BuildConnect a license to use it for platform operations.</p>
                    </div>
                    <div class="mb-4">
                        <h3 class="h5 fw-bold mb-3">3. Fair Use</h3>
                        <p>Limited use for criticism, comment, news reporting, teaching, or research is permitted under fair use doctrine.</p>
                    </div>
                    <div class="mb-4">
                        <h3 class="h5 fw-bold mb-3">4. DMCA Takedown</h3>
                        <p>To report copyright infringement, email legal@buildconnect.com with details of the allegedly infringing material.</p>
                    </div>
                    <p class="text-muted mt-4">Last updated: {{ date('F Y') }}</p>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection>

