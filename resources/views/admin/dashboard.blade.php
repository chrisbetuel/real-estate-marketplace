{{-- resources/views/admin/dashboard.blade.php --}}
@extends('admin.layouts.app')

@section('title', 'Dashboard - Oweru Admin')
@section('page-title', 'Dashboard Overview')

@section('content')
<div class="row">
    <!-- Stats Cards -->
    <div class="col-md-3">
        <div class="stats-card">
            <div class="stats-icon">
                <i class="fas fa-users"></i>
            </div>
            <div class="stats-number">{{ $stats['total_users'] }}</div>
            <div class="stats-label">Total Users</div>
            <small class="text-success">+{{ $stats['new_users_today'] }} today</small>
        </div>
    </div>
    
    <div class="col-md-3">
        <div class="stats-card">
            <div class="stats-icon">
                <i class="fas fa-building"></i>
            </div>
            <div class="stats-number">{{ $stats['total_properties'] }}</div>
            <div class="stats-label">Properties</div>
        </div>
    </div>
    
    <div class="col-md-3">
        <div class="stats-card">
            <div class="stats-icon">
                <i class="fas fa-map-marker-alt"></i>
            </div>
            <div class="stats-number">{{ $stats['total_locations'] }}</div>
            <div class="stats-label">Locations</div>
        </div>
    </div>
    
    <div class="col-md-3">
        <div class="stats-card">
            <div class="stats-icon">
                <i class="fas fa-clock"></i>
            </div>
            <div class="stats-number">{{ $stats['pending_verifications'] }}</div>
            <div class="stats-label">Pending Verifications</div>
        </div>
    </div>
</div>

<!-- Charts Row -->
<div class="row mt-4">
    <div class="col-md-8">
        <div class="stats-card">
            <h5 class="mb-4">User Registrations ({{ date('Y') }})</h5>
            <canvas id="usersChart" height="300"></canvas>
        </div>
    </div>
    
    <div class="col-md-4">
        <div class="stats-card">
            <h5 class="mb-4">Properties by Type</h5>
            <canvas id="propertiesChart" height="300"></canvas>
        </div>
    </div>
</div>

<!-- Recent Users -->
<div class="row mt-4">
    <div class="col-md-6">
        <div class="stats-card">
            <h5 class="mb-4">Recent Users</h5>
            <div class="table-responsive">
                <table class="table table-custom">
                    <thead>
                        <tr>
                            <th>Name</th>
                            <th>Email</th>
                            <th>Joined</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($stats['recent_users'] as $user)
                        <tr>
                            <td>
                                <img src="{{ $user->profile_image ?? 'https://via.placeholder.com/30x30/0F172A/F8F8F9?text=U' }}" 
                                     alt="" style="width: 30px; height: 30px; border-radius: 50%; margin-right: 10px;">
                                {{ $user->name }}
                            </td>
                            <td>{{ $user->email }}</td>
                            <td>{{ $user->created_at->diffForHumans() }}</td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
    
    <div class="col-md-6">
        <div class="stats-card">
            <h5 class="mb-4">Recent Properties</h5>
            <div class="table-responsive">
                <table class="table table-custom">
                    <thead>
                        <tr>
                            <th>Title</th>
                            <th>Owner</th>
                            <th>Price</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($stats['recent_properties'] as $property)
                        <tr>
                            <td>{{ Str::limit($property->title, 20) }}</td>
                            <td>{{ $property->user->name ?? 'N/A' }}</td>
                            <td>${{ number_format($property->price) }}</td>
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
<script>
document.addEventListener('DOMContentLoaded', function() {
    // Users Chart
    const usersCtx = document.getElementById('usersChart').getContext('2d');
    const usersData = @json($usersByMonth);
    
    const months = ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec'];
    const userCounts = Array(12).fill(0);
    
    usersData.forEach(item => {
        userCounts[item.month - 1] = item.count;
    });
    
    new Chart(usersCtx, {
        type: 'line',
        data: {
            labels: months,
            datasets: [{
                label: 'Users Registered',
                data: userCounts,
                borderColor: '#C9A53B',
                backgroundColor: 'rgba(201,165,59,0.1)',
                tension: 0.4,
                fill: true
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            plugins: {
                legend: {
                    display: false
                }
            }
        }
    });
    
    // Properties Chart
    const propsCtx = document.getElementById('propertiesChart').getContext('2d');
    const propsData = @json($propertiesByType);
    
    new Chart(propsCtx, {
        type: 'doughnut',
        data: {
            labels: propsData.map(item => item.property_type),
            datasets: [{
                data: propsData.map(item => item.count),
                backgroundColor: ['#C9A53B', '#0F172A', '#6c757d', '#28a745'],
                borderWidth: 0
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            plugins: {
                legend: {
                    position: 'bottom'
                }
            }
        }
    });
});
</script>
@endpush