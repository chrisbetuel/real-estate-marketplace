@extends('layouts.app')

@section('title', 'Job Alerts - BuildConnect')

@section('content')
<div class="container" style="max-width: 980px; padding: 32px 24px;">
    <h1 style="font-size: 24px; font-weight: 700; color: #1E2A3A; margin-bottom: 24px;">Job Alerts</h1>

    @if(session('success'))
        <div class="alert alert-success" style="background: #ECFDF5; border: none; padding: 12px 14px; border-radius: 12px; margin-bottom: 16px;">
            {{ session('success') }}
        </div>
    @endif

    <div style="background: #FFFFFF; border: 1px solid #E2E8F0; border-radius: 16px; padding: 20px; margin-bottom: 20px;">
        <form method="POST" action="{{ route('client.job-alerts.store') }}">
            @csrf

            <div style="display: grid; grid-template-columns: 1fr auto; gap: 12px; align-items: end;">
                <div>
                    <label style="display:block; font-size: 12px; font-weight: 600; color: #64748B; margin-bottom: 8px;">Keyword / Skill</label>
                    <input
                        type="text"
                        name="keyword"
                        value="{{ old('keyword') }}"
                        placeholder="e.g. Structural Engineer, Plumbing, Electrical"
                        style="width:100%; border: 1px solid #E2E8F0; border-radius: 12px; padding: 12px 14px; outline: none;"
                    >
                    @error('keyword')
                        <div style="color: #DC2626; font-size: 12px; margin-top: 6px;">{{ $message }}</div>
                    @enderror
                </div>

                <button type="submit" class="btn-primary" style="height: 44px; padding: 0 18px; border-radius: 12px; border: none; background: #F5A623; color:#1E2A3A; font-weight: 700; cursor: pointer;">
                    Save Alert
                </button>
            </div>

            <div style="margin-top: 14px; display:flex; gap: 10px; align-items:center;">
                <input id="enabled" type="checkbox" name="enabled" value="1" checked>
                <label for="enabled" style="font-size: 13px; color:#334155;">Enable this alert</label>
            </div>
        </form>
    </div>

    <div style="background: #FFFFFF; border: 1px solid #E2E8F0; border-radius: 16px; overflow:hidden;">
        <div style="padding: 16px 20px; border-bottom: 1px solid #F1F5F9;">
            <h2 style="font-size: 16px; font-weight: 700; color:#1E2A3A; margin:0;">Your Alerts</h2>
        </div>

        @if($jobAlerts->count() === 0)
            <div style="padding: 40px 20px; text-align:center; color:#94A3B8;">
                <div style="font-size: 16px; font-weight: 600; margin-bottom: 6px;">No alerts yet</div>
                <div style="font-size: 13px;">Add a keyword/skill above to start receiving job matches.</div>
            </div>
        @else
            <table style="width:100%; border-collapse: collapse;">
                <thead>
                    <tr>
                        <th style="text-align:left; padding: 14px 16px; background:#F8FAFC; font-size: 12px; font-weight: 700; color:#64748B; border-bottom: 1px solid #E2E8F0;">Keyword</th>
                        <th style="text-align:left; padding: 14px 16px; background:#F8FAFC; font-size: 12px; font-weight: 700; color:#64748B; border-bottom: 1px solid #E2E8F0;">Status</th>
                        <th style="padding: 14px 16px; background:#F8FAFC; border-bottom: 1px solid #E2E8F0;"></th>
                    </tr>
                </thead>
                <tbody>
                @foreach($jobAlerts as $alert)
                    <tr>
                        <td style="padding: 14px 16px; border-bottom: 1px solid #F1F5F9; color:#1E2A3A; font-weight: 600;">
                            {{ $alert->keyword ?: '(Any keyword)' }}
                        </td>
                        <td style="padding: 14px 16px; border-bottom: 1px solid #F1F5F9;">
                            @if($alert->enabled)
                                <span style="display:inline-block; padding: 4px 10px; border-radius: 999px; background: rgba(16,185,129,0.1); color:#059669; font-weight: 700; font-size: 12px;">Enabled</span>
                            @else
                                <span style="display:inline-block; padding: 4px 10px; border-radius: 999px; background: rgba(239,68,68,0.1); color:#DC2626; font-weight: 700; font-size: 12px;">Disabled</span>
                            @endif
                        </td>
                        <td style="padding: 14px 16px; border-bottom: 1px solid #F1F5F9; text-align:right;">
                            <form method="POST" action="{{ route('client.job-alerts.destroy', $alert) }}" onsubmit="return confirm('Remove this job alert?')">
                                @csrf
                                @method('DELETE')
                                <button type="submit" style="border: none; background: transparent; color:#DC2626; font-weight: 800; cursor:pointer;">Remove</button>
                            </form>
                        </td>
                    </tr>
                @endforeach
                </tbody>
            </table>
        @endif
    </div>
</div>
@endsection

