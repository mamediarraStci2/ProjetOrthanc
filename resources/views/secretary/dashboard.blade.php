@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">{{ __('Secretary Dashboard') }}</div>

                <div class="card-body">
                    @if (session('status'))
                        <div class="alert alert-success" role="alert">
                            {{ session('status') }}
                        </div>
                    @endif

                    <div class="row">
                        <!-- Quick Actions Section -->
                        <div class="col-md-4 mb-4">
                            <div class="card">
                                <div class="card-header">Quick Actions</div>
                                <div class="card-body">
                                    <div class="list-group">
                                        <a href="#" class="list-group-item list-group-item-action">
                                            <i class="fas fa-calendar-plus"></i> New Appointment
                                        </a>
                                        <a href="#" class="list-group-item list-group-item-action">
                                            <i class="fas fa-folder-plus"></i> New Patient File
                                        </a>
                                        <a href="#" class="list-group-item list-group-item-action">
                                            <i class="fas fa-search"></i> Search Patient
                                        </a>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Today's Appointments Section -->
                        <div class="col-md-8 mb-4">
                            <div class="card">
                                <div class="card-header">Today's Appointments</div>
                                <div class="card-body">
                                    <div class="table-responsive">
                                        <table class="table">
                                            <thead>
                                                <tr>
                                                    <th>Time</th>
                                                    <th>Patient</th>
                                                    <th>Doctor</th>
                                                    <th>Status</th>
                                                    <th>Actions</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <!-- Appointments will be loaded here -->
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Recent Patient Files Section -->
                        <div class="col-md-12">
                            <div class="card">
                                <div class="card-header">Recent Patient Files</div>
                                <div class="card-body">
                                    <div class="table-responsive">
                                        <table class="table">
                                            <thead>
                                                <tr>
                                                    <th>Patient ID</th>
                                                    <th>Name</th>
                                                    <th>Last Visit</th>
                                                    <th>Status</th>
                                                    <th>Actions</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <!-- Recent patient files will be loaded here -->
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
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
<script>
    // Add any JavaScript needed for the dashboard
</script>
@endsection 