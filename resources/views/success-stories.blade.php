@extends('layouts.app')

@section('title', 'Success Stories - BuildConnect')

@section('content')
<div class="container" style="padding-top: 40px; padding-bottom: 80px;">
    <div class="row justify-content-center">
        <div class="col-lg-10">
            <div class="card">
                <div class="card-header">Success Stories</div>
                <div class="card-body">
                    <p class="mb-4" style="color:#475569;">Real results from real projects. Here are a few examples of how BuildConnect helped teams move faster, collaborate better, and deliver on time.</p>

                    <div class="row g-4">
                        <div class="col-md-4">
                            <div class="p-4 h-100" style="border:1px solid #E2E8F0; border-radius: 16px; background:#F8FAFC;">
                                <div class="d-flex align-items-center gap-3 mb-3">
                                    <img src="https://randomuser.me/api/portraits/men/41.jpg" alt="Michael" style="width:44px;height:44px;border-radius:50%;border:2px solid #C9A53B;">
                                    <div>
                                        <div style="font-weight:700;">Michael A.</div>
                                        <div style="font-size:0.85rem;color:#64748B;">COO, Shelter Afrique</div>
                                    </div>
                                </div>
                                <p style="color:#475569;font-size:0.95rem;">“Oweru connected us with vetted professionals quickly and helped us keep milestones on schedule.”</p>
                                <div class="mt-3" style="color:#C9A53B; font-weight:600; font-size:0.9rem;">Milestone delivery • Faster hiring</div>
                            </div>
                        </div>

                        <div class="col-md-4">
                            <div class="p-4 h-100" style="border:1px solid #E2E8F0; border-radius: 16px; background:#F8FAFC;">
                                <div class="d-flex align-items-center gap-3 mb-3">
                                    <img src="https://randomuser.me/api/portraits/women/22.jpg" alt="Grace" style="width:44px;height:44px;border-radius:50%;border:2px solid #C9A53B;">
                                    <div>
                                        <div style="font-weight:700;">Grace M.</div>
                                        <div style="font-size:0.85rem;color:#64748B;">Senior Architect, Nairobi</div>
                                    </div>
                                </div>
                                <p style="color:#475569;font-size:0.95rem;">“The escrow system gave both sides confidence, and the platform made coordination effortless.”</p>
                                <div class="mt-3" style="color:#C9A53B; font-weight:600; font-size:0.9rem;">Secure escrow • Smooth collaboration</div>
                            </div>
                        </div>

                        <div class="col-md-4">
                            <div class="p-4 h-100" style="border:1px solid #E2E8F0; border-radius: 16px; background:#F8FAFC;">
                                <div class="d-flex align-items-center gap-3 mb-3">
                                    <img src="https://randomuser.me/api/portraits/men/75.jpg" alt="Kwame" style="width:44px;height:44px;border-radius:50%;border:2px solid #C9A53B;">
                                    <div>
                                        <div style="font-weight:700;">Kwame A.</div>
                                        <div style="font-size:0.85rem;color:#64748B;">Project Director, Goldstar</div>
                                    </div>
                                </div>
                                <p style="color:#475569;font-size:0.95rem;">“The vetting process was rigorous—every hire was top-tier, and communication was clear from day one.”</p>
                                <div class="mt-3" style="color:#C9A53B; font-weight:600; font-size:0.9rem;">Vetted talent • Strong communication</div>
                            </div>
                        </div>
                    </div>

                    <div class="mt-5" style="border:1px solid #E2E8F0; border-radius: 16px; background:#0F172A; color:#fff; padding: 28px 22px;">
                        <h3 style="margin:0 0 10px 0; font-weight:800;">Ready to build with confidence?</h3>
                        <p style="margin:0 0 18px 0; color: rgba(255,255,255,0.7);">Connect with vetted professionals and move from planning to execution securely.</p>
                        <div style="display:flex; gap:12px; flex-wrap: wrap;">
                            <a href="{{ route('register') }}" class="btn" style="background:#C9A53B; color:#0F172A; border:none; border-radius: 10px; padding: 10px 20px; font-weight:700;">Get Started Free</a>
                            <a href="{{ url('/contact') }}" class="btn" style="background: transparent; color:#C9A53B; border:1px solid rgba(201,165,59,0.6); border-radius: 10px; padding: 10px 20px; font-weight:700;">Talk to Sales</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

