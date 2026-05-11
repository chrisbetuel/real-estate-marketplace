@extends('layouts.app')

@section('title', 'Recommended Jobs')

@section('content')
<div class="container" style="max-width: 980px; margin: 0 auto; padding: 28px 16px;">
    <h1 style="font-size: 22px; font-weight: 700; margin-bottom: 18px;">Recommended jobs</h1>

    @if(($jobs ?? null) && $jobs->total() > 0)
        <div class="row" style="display: grid; grid-template-columns: repeat(auto-fill, minmax(280px, 1fr)); gap: 16px;">
            @foreach($jobs as $job)
                <div style="border: 1px solid #e5e7eb; border-radius: 12px; background: #fff; padding: 14px;">
                    <div style="display:flex; align-items:flex-start; justify-content:space-between; gap: 10px;">
                        <a href="{{ route('jobs.show', $job) }}" style="text-decoration:none; color:#0f172a; font-weight:700;">
                            {{ $job->title }}
                        </a>
                        <span style="font-size: 12px; color:#16a34a; background:#ecfdf5; padding: 4px 10px; border-radius: 999px;">
                            Open
                        </span>
                    </div>

                    <div style="margin-top: 8px; color:#64748b; font-size: 13px;">
                        {{ \Illuminate\Support\Str::limit($job->description ?? '', 90) }}
                    </div>

                    <div style="margin-top: 10px; font-size: 12px; color:#475569; display:flex; gap: 10px; flex-wrap: wrap;">
                        <span><b>Category:</b> {{ $job->service_category ?? '—' }}</span>
                        @if(!empty($job->location))
                            <span><b>Location:</b> {{ $job->location }}</span>
                        @endif
                        <span><b>Budget:</b> ${{ $job->budget_min }} - ${{ $job->budget_max }}</span>
                    </div>

                    <div style="margin-top: 12px; color:#94a3b8; font-size: 12px;">
                        Posted by: {{ $job->client->name ?? 'Client' }}
                    </div>

                    <div style="margin-top: 14px;">
                        <a href="{{ route('jobs.show', $job) }}" style="display:inline-block; text-decoration:none; background:#2d6a4f; color:#fff; padding: 8px 14px; border-radius: 999px; font-size: 12px; font-weight: 600;">
                            View job
                        </a>
                    </div>
                </div>
            @endforeach
        </div>

        <div style="margin-top: 22px;">
            {{ $jobs->links() }}
        </div>
    @else
        <div style="border: 1px solid #e5e7eb; border-radius: 12px; padding: 24px; background:#fff;">
            <h3 style="margin:0 0 8px; font-size: 16px;">No recommended jobs</h3>
            <p style="margin:0; color:#64748b; font-size: 13px;">There are no open jobs to show right now.</p>
        </div>
    @endif
</div>
@endsection

