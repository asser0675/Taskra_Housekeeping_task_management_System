@extends('admin.layouts.app')
@section('page-title', 'Settings')
@section('page-subtitle', 'Persist hotel-wide preferences directly in the database.')

@section('content')
    <form method="POST" action="{{ route('admin.settings.update') }}" class="card settings-form">
        @csrf
        @method('PUT')

        <div class="form-grid">
            <label class="form-group">
                <span>Hotel Name</span>
                <input type="text" name="hotel_name" class="form-input" value="{{ old('hotel_name', $settings->hotel_name) }}">
            </label>

            <label class="form-group">
                <span>Currency</span>
                <select name="currency" class="form-input">
                    @foreach (['PHP' => 'Philippine Peso', 'USD' => 'US Dollar', 'EUR' => 'Euro'] as $value => $label)
                        <option value="{{ $value }}" @selected(old('currency', $settings->currency) === $value)>{{ $label }}</option>
                    @endforeach
                </select>
            </label>

            <label class="form-group">
                <span>Time Zone</span>
                <select name="timezone" class="form-input">
                    @foreach (['Asia/Manila', 'UTC'] as $timezone)
                        <option value="{{ $timezone }}" @selected(old('timezone', $settings->timezone) === $timezone)>{{ $timezone }}</option>
                    @endforeach
                </select>
            </label>

            <label class="form-group">
                <span>Language</span>
                <select name="language" class="form-input">
                    @foreach (['en' => 'English', 'fil' => 'Filipino'] as $value => $label)
                        <option value="{{ $value }}" @selected(old('language', $settings->language) === $value)>{{ $label }}</option>
                    @endforeach
                </select>
            </label>
        </div>

        <div class="settings-toggles">
            <label class="toggle-row">
                <span>Task Notifications</span>
                <input type="checkbox" name="task_notifications" value="1" @checked(old('task_notifications', $settings->task_notifications))>
            </label>
            <label class="toggle-row">
                <span>Issue Alerts</span>
                <input type="checkbox" name="issue_alerts" value="1" @checked(old('issue_alerts', $settings->issue_alerts))>
            </label>
            <label class="toggle-row">
                <span>Email Notifications</span>
                <input type="checkbox" name="email_notifications" value="1" @checked(old('email_notifications', $settings->email_notifications))>
            </label>
        </div>

        <button type="submit" class="btn-primary">Save Settings</button>
    </form>
@endsection