@extends('layouts.app')

@section('title', 'Contact Us - BuildConnect')

@section('content')
<div class="container" style="padding-top: 40px; padding-bottom: 60px;">
    <div class="row justify-content-center">
        <div class="col-lg-8">
            <div class="card">
                <div class="card-header">Contact BuildConnect</div>
                <div class="card-body">
                    <p class="mb-4" style="color: #475569;">
                        Have questions or want to talk with our team? Send us a message and we’ll get back to you.
                    </p>

                    <div class="row g-4">
                        <div class="col-md-6">
                            <div class="p-3" style="background: #F1F5F9; border-radius: 14px; border: 1px solid #E2E8F0;">
                                <div class="d-flex align-items-center gap-2 mb-2">
                                    <i class="fas fa-envelope" style="color: #C9A53B;"></i>
                                    <strong>Email</strong>
                                </div>
                                <a href="mailto:hello@buildconnect.com">hello@buildconnect.com</a>
                                <div class="text-muted" style="font-size: 0.85rem;">We typically respond within 1-2 business days.</div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="p-3" style="background: #F1F5F9; border-radius: 14px; border: 1px solid #E2E8F0;">
                                <div class="d-flex align-items-center gap-2 mb-2">
                                    <i class="fas fa-phone" style="color: #C9A53B;"></i>
                                    <strong>Phone</strong>
                                </div>
                                <a href="tel:+255123456789">+255 123 456 789</a>
                                <div class="text-muted" style="font-size: 0.85rem;">Mon-Fri, 9:00 AM – 5:00 PM.</div>
                            </div>
                        </div>
                    </div>

                    <hr class="my-4" />

                    <form method="POST" action="">
                        @csrf

                        <div class="row g-3">
                            <div class="col-md-6">
                                <label class="form-label">Name</label>
                                <input type="text" name="name" class="form-control" required />
                            </div>
                            <div class="col-md-6">
                                <label class="form-label">Email</label>
                                <input type="email" name="email" class="form-control" required />
                            </div>
                            <div class="col-12">
                                <label class="form-label">Message</label>
                                <textarea name="message" rows="5" class="form-control" required></textarea>
                            </div>
                            <div class="col-12">
                                <button type="submit" class="btn" style="background: #C9A53B; color: #0F172A; border-radius: 10px; font-weight: 600;">Send Message</button>
                                <div class="text-muted" style="font-size: 0.85rem; margin-top: 10px;">
                                    This page is currently static; connect it to a controller/route when you’re ready.
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

