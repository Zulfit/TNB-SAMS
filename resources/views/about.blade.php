@extends('layouts.layout')

@section('content')
    <main id="main" class="main">

        <div class="pagetitle">
            <h1>About</h1>
            <nav>
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Dashboard</a></li>
                    <li class="breadcrumb-item active">About</li>
                </ol>
            </nav>
        </div>

        <section class="section about">
            <div class="container-fluid">
                <div class="card shadow-sm border-0">
                    <div class="card-body p-4">
                        <h2 class="card-title">TNB Substation Asset Monitoring System</h2>
                        <p class="mb-3">
                            For my Final Year Project, I’m developing a web-based Substation Asset Monitoring System for 
                            <strong>Tenaga Nasional Berhad (TNB)</strong> using <strong>Laravel, PHP, JavaScript, HTML,</strong> 
                            and <strong>CSS</strong>. The system supports TNB’s pilot project in Klang Valley, where sensors 
                            installed in substations send temperature and partial discharge data to the server every 5 minutes.
                        </p>
                        <p class="mb-3">
                            My system visualizes this real-time data to help managers monitor asset conditions more effectively. 
                            It includes built-in alert notifications for abnormal readings and a task assignment feature that 
                            allows managers to delegate maintenance work directly.
                        </p>
                        <p class="mb-0">
                            The goal is to enhance operational efficiency and improve overall asset performance, ensuring 
                            that TNB’s assets in the Klang Valley operate reliably and safely.
                        </p>
                    </div>
                </div>
            </div>
        </section>

    </main>
@endsection
