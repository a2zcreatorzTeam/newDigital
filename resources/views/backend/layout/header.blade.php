<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>State Life Digital | Policy Management</title>

    <link rel="shortcut icon" type="image/x-icon" href="{{ asset('frontend\images\favicon.jpg') }}">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-sRIl4kxILFvY47J16cr9ZwB07vP4J8+LH7qKQnuqkuIAvNWLzeN8tE5YBujZqJLB" crossorigin="anonymous">


    <style>
        /* CSS Variables - SaaS Blue Theme */
        :root {
            --primary: #1e40af;
            --primary-hover: #1e3a8a;
            --secondary: #3b82f6;
            --secondary-hover: #2563eb;
            --sidebar-bg: #0f2b4d;
            --sidebar-hover: #173d6e;
            --bg-main: #f4f7f9;
            --surface: #ffffff;
            --text-dark: #1e293b;
            --text-muted: #64748b;
            --border: #e2e8f0;
            --success: #10b981;
            --success-bg: #d1fae5;
            --danger: #ef4444;
            --danger-bg: #fee2e2;
            --warning: #f59e0b;
            --radius-md: 8px;
            --radius-lg: 12px;
            --shadow-sm: 0 1px 2px rgba(0, 0, 0, 0.05);
            --shadow-md: 0 4px 6px -1px rgba(0, 0, 0, 0.1);
            --shadow-lg: 0 10px 15px -3px rgba(0, 0, 0, 0.1);
            --transition: all 0.3s ease;
        }

        a {
            color: #ffff !important;
            text-decoration: none;
        }

        * {
            box-sizing: border-box;
            margin: 0;
            padding: 0;
            font-family: 'Inter', sans-serif;
        }

        body {
            background-color: var(--bg-main);
            color: var(--text-dark);
            min-height: 100vh;
            display: flex;
            overflow-x: hidden;
        }

        /* Utilities */
        .hidden {
            display: none !important;
        }

        .text-primary {
            color: var(--primary);
        }

        .text-secondary {
            color: var(--secondary);
        }

        .text-muted {
            color: var(--text-muted);
            font-size: 0.875rem;
        }

        .font-semibold {
            font-weight: 600;
        }

        .font-bold {
            font-weight: 700;
        }

        .flex {
            display: flex;
        }

        .items-center {
            align-items: center;
        }

        .justify-between {
            justify-content: space-between;
        }

        .gap-2 {
            gap: 0.5rem;
        }

        .gap-4 {
            gap: 1rem;
        }

        .mb-4 {
            margin-bottom: 1rem;
        }

        .mt-4 {
            margin-top: 1rem;
        }

        /* Buttons */
        .btn {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            gap: 0.5rem;
            padding: 0.6rem 1.2rem;
            border-radius: var(--radius-md);
            border: none;
            font-size: 0.875rem;
            font-weight: 500;
            cursor: pointer;
            transition: var(--transition);
        }

        .btn-primary {
            background: var(--primary);
            color: white;
        }

        .btn-primary:hover {
            background: var(--primary-hover);
        }

        .btn-secondary {
            background: var(--secondary);
            color: white;
        }

        .btn-secondary:hover {
            background: var(--secondary-hover);
        }

        .btn-outline {
            background: transparent;
            border: 1px solid var(--border);
            color: var(--text-dark);
        }

        .btn-outline:hover {
            background: var(--bg-main);
        }

        .btn-danger {
            background: var(--danger-bg);
            color: var(--danger);
        }

        .btn-danger:hover {
            background: var(--danger);
            color: white;
        }

        .btn-icon {
            padding: 0.4rem 0.6rem;
            font-size: 0.875rem;
        }

        /* Forms */
        .form-group {
            margin-bottom: 1rem;
        }

        .form-label {
            display: block;
            font-size: 0.875rem;
            font-weight: 500;
            margin-bottom: 0.4rem;
        }

        .form-control {
            width: 100%;
            padding: 0.6rem 0.8rem;
            border: 1px solid var(--border);
            border-radius: var(--radius-md);
            font-size: 0.875rem;
            transition: var(--transition);
        }

        .form-control:focus {
            outline: none;
            border-color: var(--secondary);
            box-shadow: 0 0 0 3px rgba(59, 130, 246, 0.15);
        }

        /* Cards */
        .card {
            background: var(--surface);
            border-radius: var(--radius-lg);
            padding: 1.5rem;
            box-shadow: var(--shadow-sm);
            border: 1px solid var(--border);
        }

        /* --- AUTH VIEW --- */
        #auth-view {
            width: 100vw;
            height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            background: linear-gradient(135deg, #0f2b4d 0%, #1e40af 100%);
            position: fixed;
            top: 0;
            left: 0;
            z-index: 1000;
        }

        .auth-card {
            width: 100%;
            max-width: 400px;
            background: white;
            padding: 2.5rem;
            border-radius: var(--radius-lg);
            box-shadow: var(--shadow-lg);
        }

        .auth-logo {
            text-align: center;
            margin-bottom: 2rem;
        }

        .auth-logo img {
            height: 60px;
            object-fit: contain;
        }

        .auth-toggle {
            text-align: center;
            margin-top: 1.5rem;
            font-size: 0.875rem;
        }

        .auth-toggle a {
            color: var(--secondary);
            text-decoration: none;
            font-weight: 500;
        }

        /* --- APP LAYOUT --- */
        #app-view {
            display: flex;
            width: 100%;
            min-height: 100vh;
        }

        /* Sidebar */
        .sidebar {
            width: 260px;
            background: var(--sidebar-bg);
            color: white;
            display: flex;
            flex-direction: column;
            position: fixed;
            height: 100vh;
            z-index: 100;
            transition: var(--transition);
        }

        .sidebar-header {
            padding: 1.5rem;
            display: flex;
            align-items: center;
            gap: 12px;
            border-bottom: 1px solid rgba(255, 255, 255, 0.1);
        }

        .sidebar-header img {
            height: 35px;
            border-radius: 4px;
            background: white;
            padding: 2px;
        }

        .sidebar-header h2 {
            font-size: 1.1rem;
            font-weight: 600;
            letter-spacing: 0.5px;
        }

        .sidebar-nav {
            padding: 1.5rem 1rem;
            flex-grow: 1;
        }

        .nav-item {
            display: flex;
            align-items: center;
            gap: 12px;
            padding: 0.8rem 1rem;
            color: #cbd5e1;
            text-decoration: none;
            border-radius: var(--radius-md);
            margin-bottom: 0.5rem;
            transition: var(--transition);
            cursor: pointer;
            font-size: 0.95rem;
        }

        .nav-item:hover,
        .nav-item.active {
            background: var(--sidebar-hover);
            color: white;
        }

        .sidebar-footer {
            padding: 1.5rem;
            border-top: 1px solid rgba(255, 255, 255, 0.1);
            display: flex;
            align-items: center;
            justify-content: space-between;
        }

        .user-profile {
            display: flex;
            align-items: center;
            gap: 10px;
        }

        .avatar {
            width: 36px;
            height: 36px;
            border-radius: 50%;
            background: var(--secondary);
            display: flex;
            align-items: center;
            justify-content: center;
            font-weight: bold;
        }

        /* Main Content */
        .main-content {
            flex-grow: 1;
            margin-left: 260px;
            padding: 2rem;
            display: flex;
            flex-direction: column;
        }

        .top-header {
            display: flex;
            justify-content: flex-end;
            margin-bottom: 2rem;
        }

        .top-header img {
            height: 45px;
            object-fit: contain;
        }

        /* Dashboard Grid Layouts */
        .kpi-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(220px, 1fr));
            gap: 1.5rem;
            margin-bottom: 1.5rem;
        }

        .kpi-card {
            display: flex;
            align-items: center;
            gap: 1rem;
        }

        .kpi-icon {
            width: 48px;
            height: 48px;
            border-radius: 12px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 1.5rem;
            background: #e0e7ff;
            color: var(--primary);
        }

        .kpi-value {
            font-size: 1.5rem;
            font-weight: 700;
            margin-top: 0.2rem;
        }

        .charts-grid {
            display: grid;
            grid-template-columns: 2fr 1fr;
            gap: 1.5rem;
            margin-bottom: 1.5rem;
        }

        .chart-container {
            position: relative;
            height: 300px;
            width: 100%;
        }

        .widgets-grid {
            display: grid;
            grid-template-columns: 1fr 1fr 1fr;
            gap: 1.5rem;
            margin-bottom: 1.5rem;
        }

        .feed-item {
            padding: 0.8rem 0;
            border-bottom: 1px solid var(--border);
            font-size: 0.875rem;
            display: flex;
            align-items: center;
            gap: 10px;
        }

        .feed-item:last-child {
            border-bottom: none;
            padding-bottom: 0;
        }

        .feed-time {
            color: var(--text-muted);
            font-size: 0.75rem;
            margin-left: auto;
        }

        /* Tables */
        .table-responsive {
            overflow-x: auto;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 1rem;
        }

        th {
            text-align: left;
            padding: 1rem;
            font-size: 0.75rem;
            text-transform: uppercase;
            color: var(--text-muted);
            background: #f8fafc;
            border-bottom: 1px solid var(--border);
        }

        td {
            padding: 1rem;
            border-bottom: 1px solid var(--border);
            font-size: 0.875rem;
            vertical-align: middle;
        }

        tr:last-child td {
            border-bottom: none;
        }

        tbody tr:hover {
            background: #f8fafc;
        }

        .badge {
            padding: 0.3rem 0.6rem;
            border-radius: 20px;
            font-size: 0.75rem;
            font-weight: 500;
        }

        .badge-active {
            background: var(--success-bg);
            color: var(--success);
        }

        .badge-inactive {
            background: var(--danger-bg);
            color: var(--danger);
        }

        /* Manager Split Layout */
        .manager-grid {
            display: grid;
            grid-template-columns: 350px 1fr;
            gap: 1.5rem;
            align-items: start;
        }

        /* Responsive */
        @media (max-width: 1024px) {
            .charts-grid {
                grid-template-columns: 1fr;
            }

            .widgets-grid {
                grid-template-columns: repeat(auto-fit, minmax(300px, 1fr));
            }

            .manager-grid {
                grid-template-columns: 1fr;
            }
        }

        @media (max-width: 768px) {
            .sidebar {
                width: 100%;
                height: auto;
                position: relative;
            }

            .main-content {
                margin-left: 0;
                padding: 1rem;
            }

            #app-view {
                flex-direction: column;
            }

            .sidebar-footer {
                display: none;
            }

            /* Move logout to top or hide on small mobile for brevity */
        }
    </style>
</head>

<body>