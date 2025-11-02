@extends('admin.layout.app')

@section('main')
    <div class="container-fluid py-4">
        @include('front.message')

        <div class="row">
            <div class="col">
                <nav aria-label="breadcrumb" class="breadcrumb-box mb-4">
                    <ol class="breadcrumb mb-0">
                        <li class="breadcrumb-item">
                            <a href="#"><i class="fa fa-home me-1"></i> Home</a>
                        </li>
                        <li class="breadcrumb-item active"><i class="fa-solid fa-gear me-2"></i>Settings</li>
                    </ol>
                </nav>
            </div>
        </div>

        <!-- Settings Tabs -->
        <ul class="nav nav-tabs" id="settingsTabs" role="tablist">
            <li class="nav-item">
                <a class="nav-link active" id="general-tab" data-bs-toggle="tab" href="#general" role="tab">General</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" id="seo-tab" data-bs-toggle="tab" href="#seo" role="tab">SEO</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" id="payment-tab" data-bs-toggle="tab" href="#payment" role="tab">Payment</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" id="notifications-tab" data-bs-toggle="tab" href="#notifications"
                    role="tab">Notifications</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" id="security-tab" data-bs-toggle="tab" href="#security" role="tab">Security</a>
            </li>
        </ul>

        <!-- Tab Content -->
        <div class="tab-content border border-top-0 p-4 rounded-bottom shadow-sm bg-white">

            <!-- General Settings -->
            <div class="tab-pane fade show active" id="general" role="tabpanel">
                <form action="{{ route('admin.settings.update', 'general') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <div class="mb-3">
                        <label class="form-label">Site Title</label>
                        <input type="text" name="site_title" class="form-control"
                            value="{{ old('site_title', $settings['site_title'] ?? '') }}">
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Logo</label>
                        <input type="file" name="logo" class="form-control">
                        @if(!empty($settings['logo']))
                            <img src="{{ asset('storage/' . $settings['logo']) }}" alt="Logo" class="mt-2" height="40">
                        @endif
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Contact Email</label>
                        <input type="email" name="contact_email" class="form-control"
                            value="{{ old('contact_email', $settings['contact_email'] ?? '') }}">
                    </div>
                    <button type="submit" class="btn btn-primary">Save General</button>
                </form>
            </div>

            <!-- SEO Settings -->
            <div class="tab-pane fade" id="seo" role="tabpanel">
                <form action="{{ route('admin.settings.update', 'seo') }}" method="POST">
                    @csrf
                    <div class="mb-3">
                        <label class="form-label">Meta Title</label>
                        <input type="text" name="meta_title" class="form-control"
                            value="{{ old('meta_title', $settings['meta_title'] ?? '') }}">
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Meta Description</label>
                        <textarea name="meta_description" class="form-control"
                            rows="3">{{ old('meta_description', $settings['meta_description'] ?? '') }}</textarea>
                    </div>
                    <button type="submit" class="btn btn-primary">Save SEO</button>
                </form>
            </div>

            <!-- Payment Settings -->
            <div class="tab-pane fade" id="payment" role="tabpanel">
                <form action="{{ route('admin.settings.update', 'payment') }}" method="POST">
                    @csrf
                    <div class="mb-3">
                        <label class="form-label">Currency</label>
                        <input type="text" name="currency" class="form-control"
                            value="{{ old('currency', $settings['currency'] ?? 'INR') }}">
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Payment Gateway</label>
                        <select name="payment_gateway" class="form-select">
                            <option value="paypal" {{ ($settings['payment_gateway'] ?? '') == 'paypal' ? 'selected' : '' }}>
                                PayPal</option>
                            <option value="stripe" {{ ($settings['payment_gateway'] ?? '') == 'stripe' ? 'selected' : '' }}>
                                Stripe</option>
                            <option value="razorpay" {{ ($settings['payment_gateway'] ?? '') == 'razorpay' ? 'selected' : '' }}>Razorpay</option>
                        </select>
                    </div>
                    <button type="submit" class="btn btn-primary">Save Payment</button>
                </form>
            </div>

            <!-- Notification Settings -->
            <div class="tab-pane fade" id="notifications" role="tabpanel">
                <form action="{{ route('admin.settings.update', 'notifications') }}" method="POST">
                    @csrf
                    <div class="mb-3">
                        <label class="form-label">Admin Email for Notifications</label>
                        <input type="email" name="admin_email" class="form-control"
                            value="{{ old('admin_email', $settings['admin_email'] ?? '') }}">
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Enable Job Alerts</label>
                        <select name="job_alerts" class="form-select">
                            <option value="1" {{ ($settings['job_alerts'] ?? 0) ? 'selected' : '' }}>Enabled</option>
                            <option value="0" {{ !($settings['job_alerts'] ?? 0) ? 'selected' : '' }}>Disabled</option>
                        </select>
                    </div>
                    <button type="submit" class="btn btn-primary">Save Notifications</button>
                </form>
            </div>

            <!-- Security Settings -->
            <div class="tab-pane fade" id="security" role="tabpanel">
                <form action="{{ route('admin.settings.update', 'security') }}" method="POST">
                    @csrf
                    <div class="mb-3">
                        <label class="form-label">Enable Two-Factor Authentication</label>
                        <select name="two_factor" class="form-select">
                            <option value="1" {{ ($settings['two_factor'] ?? 0) ? 'selected' : '' }}>Enabled</option>
                            <option value="0" {{ !($settings['two_factor'] ?? 0) ? 'selected' : '' }}>Disabled</option>
                        </select>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Max Login Attempts</label>
                        <input type="number" name="max_login_attempts" class="form-control"
                            value="{{ old('max_login_attempts', $settings['max_login_attempts'] ?? 5) }}">
                    </div>
                    <button type="submit" class="btn btn-primary">Save Security</button>
                </form>
            </div>

        </div>
    </div>
@endsection
<style>
    .breadcrumb-box {
        background: #ffffff;
        border-radius: 16px;
        padding: 14px 22px;
        border: 1px solid #e5e7eb;
        /* subtle border */
        box-shadow: 0 3px 8px rgba(0, 0, 0, 0.05);
        transition: all 0.3s ease-in-out;
    }

    .breadcrumb {
        background: transparent;
        margin: 0;
        font-size: 15px;
        font-weight: 500;
    }

    .breadcrumb-item a {
        color: #2563eb;
        /* primary blue */
        text-decoration: none;
        display: inline-flex;
        align-items: center;
        padding: 6px 12px;
        border-radius: 12px;
        transition: all 0.3s ease;
    }

    .breadcrumb-item a:hover {
        background: rgba(37, 99, 235, 0.1);
        color: #1e40af;
    }

    .breadcrumb-item.active {
        color: #374151;
        /* dark gray */
        font-weight: 600;
    }

    .breadcrumb-item+.breadcrumb-item::before {
        content: "›";
        color: #9ca3af;
        font-weight: bold;
        margin: 0 6px;
    }

    .breadcrumb {
        background: transparent;
        margin: 0;
        font-size: 15px;
        font-weight: 500;
        display: flex;
        align-items: center;
        /* ensures vertical centering */
    }

    .breadcrumb-item {
        display: flex;
        align-items: center;
        /* centers text & icons */
    }

    .breadcrumb-item a {
        display: flex;
        align-items: center;
        gap: 6px;
        /* spacing between icon & text */
        color: #2563eb;
        text-decoration: none;
        padding: 6px 10px;
        border-radius: 8px;
        transition: all 0.3s ease;
    }
</style>