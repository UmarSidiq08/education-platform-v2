@extends('layouts.admin')

@section('content')
    <!-- Inline CSS untuk memastikan styles terpanggil -->
    <style>
        /* Reset dan base styles */
        * {
            box-sizing: border-box;
        }

        /* Enhanced Responsive Design untuk Admin Mentor Page */

        /* ===== MOBILE FIRST APPROACH ===== */

        /* Base styles (Mobile) */
        .admin-mentor-page {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background-color: #f8f9fa;
            min-height: 100vh;
        }

        .admin-mentor-page .container-fluid {
            padding: 1rem;
            max-width: 100%;
        }

        /* Header responsif */
        .admin-mentor-page .page-header {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            border-radius: 12px;
            padding: 1.5rem;
            margin-bottom: 1.5rem;
            color: white;
            box-shadow: 0 4px 20px rgba(102, 126, 234, 0.2);
        }

        .admin-mentor-page .page-header h2 {
            font-size: 1.25rem;
            font-weight: 700;
            margin-bottom: 0.5rem;
            display: flex;
            align-items: center;
            flex-wrap: wrap;
            text-align: center;
            justify-content: center;
        }

        .admin-mentor-page .page-header h2 i {
            margin-right: 0.75rem;
            font-size: 1.25rem;
        }

        .admin-mentor-page .page-header p {
            font-size: 0.9rem;
            opacity: 0.9;
            margin: 0;
            text-align: center;
        }

        .admin-mentor-page .stats-badge {
            background: rgba(255, 255, 255, 0.2);
            border-radius: 20px;
            padding: 0.5rem 1rem;
            backdrop-filter: blur(10px);
            border: 1px solid rgba(255, 255, 255, 0.1);
            text-align: center;
            margin-top: 1rem;
            font-size: 0.85rem;
        }

        /* Alert styles - Mobile optimized */
        .admin-mentor-page .alert {
            border: none;
            border-radius: 10px;
            padding: 1rem;
            margin-bottom: 1.5rem;
            box-shadow: 0 2px 8px rgba(0, 0, 0, 0.08);
        }

        .admin-mentor-page .alert .d-flex {
            flex-direction: column;
            text-align: center;
            gap: 0.5rem;
        }

        .admin-mentor-page .alert-icon {
            width: 35px;
            height: 35px;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            margin: 0 auto 0.5rem;
        }

        /* Main card - Mobile first */
        .admin-mentor-page .main-card {
            background: white;
            border-radius: 12px;
            box-shadow: 0 4px 20px rgba(0, 0, 0, 0.08);
            overflow: hidden;
            transition: all 0.3s ease;
        }

        /* Card header - Mobile */
        .admin-mentor-page .card-header-custom {
            background: white;
            padding: 1.5rem 1rem;
            border-bottom: 1px solid #e9ecef;
        }

        .admin-mentor-page .card-title-wrapper {
            display: flex;
            align-items: center;
            justify-content: center;
            flex-direction: column;
            text-align: center;
            gap: 1rem;
        }

        .admin-mentor-page .icon-wrapper {
            width: 45px;
            height: 45px;
            background: linear-gradient(135deg, #007bff 0%, #0056b3 100%);
            border-radius: 10px;
            display: flex;
            align-items: center;
            justify-content: center;
            color: white;
            font-size: 1.1rem;
            margin: 0;
        }

        .admin-mentor-page .card-title-custom {
            font-size: 1.3rem;
            font-weight: 700;
            color: #212529;
            margin: 0;
        }

        .admin-mentor-page .card-subtitle {
            font-size: 0.85rem;
            color: #6c757d;
            margin-top: 0.25rem;
        }

        /* Controls section - Mobile */
        .admin-mentor-page .controls-section {
            display: flex;
            flex-direction: column;
            gap: 1rem;
            align-items: stretch;
            margin-top: 1.5rem;
        }

        .admin-mentor-page .search-wrapper {
            position: relative;
            width: 100%;
        }

        .admin-mentor-page .search-input {
            width: 100%;
            padding: 0.75rem 1rem 0.75rem 2.5rem;
            border: 2px solid #e9ecef;
            border-radius: 10px;
            font-size: 1rem;
            transition: all 0.3s ease;
            background-color: #f8f9fa;
        }

        .admin-mentor-page .search-input:focus {
            outline: none;
            border-color: #007bff;
            background-color: white;
            box-shadow: 0 0 0 0.15rem rgba(0, 123, 255, 0.1);
        }

        .admin-mentor-page .search-icon {
            position: absolute;
            left: 0.75rem;
            top: 50%;
            transform: translateY(-50%);
            color: #6c757d;
            font-size: 0.9rem;
        }

        .admin-mentor-page .clear-search {
            position: absolute;
            right: 0.5rem;
            top: 50%;
            transform: translateY(-50%);
            background: none;
            border: none;
            color: #6c757d;
            font-size: 0.9rem;
            cursor: pointer;
            padding: 0.5rem;
            border-radius: 50%;
        }

        .admin-mentor-page .clear-search:hover {
            background: rgba(220, 53, 69, 0.1);
            color: #dc3545;
        }

        /* Table responsif - Mobile */
        .admin-mentor-page .table-container {
            overflow-x: auto;
            -webkit-overflow-scrolling: touch;
        }

        .admin-mentor-page .custom-table {
            width: 100%;
            margin: 0;
            background: white;
            font-size: 0.85rem;
        }

        .admin-mentor-page .custom-table thead {
            background: linear-gradient(135deg, #f8f9fa 0%, #e9ecef 100%);
        }

        .admin-mentor-page .custom-table th {
            padding: 1rem;
            font-weight: 700;
            color: #495057;
            font-size: 0.75rem;
            text-transform: uppercase;
            letter-spacing: 0.3px;
            border-bottom: 2px solid #007bff;
            border-top: none;
            white-space: nowrap;
            text-align: left;
        }

        .admin-mentor-page .custom-table td {
            padding: 1rem;
            vertical-align: middle;
            border-top: 1px solid #e9ecef;
            transition: all 0.2s ease;
        }

        /* User card - Mobile */
        .admin-mentor-page .user-card {
            display: flex;
            align-items: center;
            flex-direction: column;
            text-align: center;
            gap: 0.75rem;
        }

        .admin-mentor-page .avatar {
            width: 45px;
            height: 45px;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            font-weight: 700;
            font-size: 1rem;
            color: white;
            margin: 0;
            box-shadow: 0 2px 8px rgba(0, 0, 0, 0.1);
            flex-shrink: 0;
        }

        .admin-mentor-page .user-info h6 {
            font-size: 0.9rem;
            font-weight: 700;
            color: #212529;
            margin-bottom: 0.5rem;
            line-height: 1.2;
        }

        .admin-mentor-page .user-meta {
            display: flex;
            align-items: center;
            gap: 0.5rem;
            margin-top: 0.5rem;
            flex-wrap: wrap;
            justify-content: center;
        }

        .admin-mentor-page .badge-custom {
            background: #e3f2fd;
            color: #1976d2;
            padding: 0.2rem 0.5rem;
            border-radius: 15px;
            font-size: 0.65rem;
            font-weight: 600;
            display: flex;
            align-items: center;
            gap: 0.25rem;
            white-space: nowrap;
        }

        /* Contact card - Mobile */
        .admin-mentor-page .contact-card {
            min-height: auto;
            display: flex;
            flex-direction: column;
            justify-content: center;
            text-align: center;
            gap: 0.5rem;
        }

        .admin-mentor-page .email-link {
            display: flex;
            align-items: center;
            justify-content: center;
            color: #007bff;
            text-decoration: none;
            font-weight: 600;
            margin-bottom: 0.5rem;
            transition: all 0.2s ease;
            font-size: 0.8rem;
            flex-wrap: wrap;
            gap: 0.5rem;
        }

        .admin-mentor-page .email-link:hover {
            color: #0056b3;
            text-decoration: underline;
        }

        .admin-mentor-page .email-link i {
            color: #6c757d;
            flex-shrink: 0;
        }

        .admin-mentor-page .date-info {
            display: flex;
            align-items: center;
            justify-content: center;
            color: #6c757d;
            font-size: 0.75rem;
            flex-wrap: wrap;
            gap: 0.5rem;
        }

        .admin-mentor-page .date-info i {
            flex-shrink: 0;
        }

        /* Action buttons - Mobile */
        .admin-mentor-page .action-buttons {
            display: flex;
            gap: 0.5rem;
            justify-content: center;
            align-items: center;
            flex-direction: column;
        }

        .admin-mentor-page .btn-custom {
            padding: 0.5rem 1rem;
            border-radius: 8px;
            font-weight: 600;
            font-size: 0.8rem;
            border: 2px solid transparent;
            transition: all 0.2s ease;
            cursor: pointer;
            display: flex;
            align-items: center;
            gap: 0.5rem;
            min-width: 100px;
            justify-content: center;
            white-space: nowrap;
        }

        .admin-mentor-page .btn-approve {
            background: linear-gradient(135deg, #28a745 0%, #20c997 100%);
            color: white;
        }

        .admin-mentor-page .btn-approve:hover {
            transform: translateY(-1px);
            box-shadow: 0 4px 12px rgba(40, 167, 69, 0.3);
        }

        .admin-mentor-page .btn-reject {
            background: linear-gradient(135deg, #dc3545 0%, #c82333 100%);
            color: white;
        }

        .admin-mentor-page .btn-reject:hover {
            transform: translateY(-1px);
            box-shadow: 0 4px 12px rgba(220, 53, 69, 0.3);
        }

        .admin-mentor-page .btn-view {
            background: linear-gradient(135deg, #6f42c1 0%, #5a32a3 100%);
            color: white;
        }

        .admin-mentor-page .btn-view:hover {
            transform: translateY(-1px);
            box-shadow: 0 4px 12px rgba(111, 66, 193, 0.3);
        }

        /* Card footer - Mobile */
        .admin-mentor-page .card-footer-custom {
            background: #f8f9fa;
            padding: 1rem;
            border-top: 1px solid #e9ecef;
            display: flex;
            justify-content: space-between;
            align-items: center;
            flex-wrap: wrap;
            gap: 1rem;
        }

        .admin-mentor-page .footer-info {
            color: #6c757d;
            font-size: 0.8rem;
            display: flex;
            align-items: center;
            gap: 0.5rem;
        }

        .admin-mentor-page .refresh-btn {
            padding: 0.5rem 1rem;
            border: 2px solid #007bff;
            background: white;
            color: #007bff;
            border-radius: 8px;
            font-weight: 600;
            cursor: pointer;
            transition: all 0.2s ease;
            display: flex;
            align-items: center;
            gap: 0.5rem;
            font-size: 0.8rem;
        }

        .admin-mentor-page .refresh-btn:hover {
            background: #007bff;
            color: white;
            transform: translateY(-1px);
        }

        /* DataTables responsive overrides */
        .admin-mentor-page .dataTables_wrapper {
            padding: 0;
        }

        .admin-mentor-page .dataTables_length {
            margin: 1rem;
        }

        .admin-mentor-page .dataTables_length label {
            display: flex;
            align-items: center;
            font-weight: 600;
            color: #495057;
            gap: 0.5rem;
            font-size: 0.85rem;
            flex-wrap: wrap;
        }

        .admin-mentor-page .dataTables_length select {
            padding: 0.4rem 1.5rem 0.4rem 0.5rem;
            border: 2px solid #e9ecef;
            border-radius: 6px;
            font-weight: 500;
            background: white;
            font-size: 0.85rem;
        }

        .admin-mentor-page .dataTables_info {
            margin: 1rem;
            color: #495057;
            font-weight: 600;
            font-size: 0.8rem;
        }

        .admin-mentor-page .dataTables_paginate {
            margin: 1rem;
            text-align: center;
        }

        .admin-mentor-page .page-link {
            border: 2px solid #e9ecef;
            border-radius: 6px;
            margin: 0 0.1rem;
            padding: 0.4rem 0.6rem;
            color: #495057;
            font-weight: 600;
            transition: all 0.2s ease;
            font-size: 0.8rem;
        }

        .admin-mentor-page .page-item.active .page-link {
            background: linear-gradient(135deg, #007bff 0%, #0056b3 100%);
            border-color: #007bff;
            color: white;
            box-shadow: 0 2px 6px rgba(0, 123, 255, 0.25);
        }

        /* Alert responsif */
        .admin-mentor-page .alert-success {
            background: linear-gradient(135deg, #d4edda 0%, #c3e6cb 100%);
            color: #155724;
            border-left: 3px solid #28a745;
        }

        .admin-mentor-page .alert-danger {
            background: linear-gradient(135deg, #f8d7da 0%, #f5c6cb 100%);
            color: #721c24;
            border-left: 3px solid #dc3545;
        }

        /* Loading states */
        .admin-mentor-page .processing-state {
            text-align: center;
            padding: 2rem 1rem;
        }

        .admin-mentor-page .loading-spinner {
            width: 2rem;
            height: 2rem;
            border: 0.25rem solid #f3f3f3;
            border-top: 0.25rem solid #007bff;
            border-radius: 50%;
            animation: spin 1s linear infinite;
            margin: 0 auto 1rem;
        }

        .admin-mentor-page .empty-state {
            text-align: center;
            padding: 2rem 1rem;
        }

        .admin-mentor-page .empty-state i {
            font-size: 3rem;
            color: #6c757d;
            margin-bottom: 1rem;
        }

        .admin-mentor-page .empty-state h5 {
            color: #495057;
            margin-bottom: 0.75rem;
            font-weight: 600;
            font-size: 1.1rem;
        }

        .admin-mentor-page .empty-state p {
            color: #6c757d;
            margin-bottom: 1rem;
            font-size: 0.9rem;
        }

        /* ===== TABLET (576px and up) ===== */
        @media (min-width: 576px) {
            .admin-mentor-page .container-fluid {
                padding: 1.5rem;
            }

            .admin-mentor-page .page-header {
                padding: 2rem;
                border-radius: 14px;
            }

            .admin-mentor-page .page-header h2 {
                font-size: 1.5rem;
                justify-content: flex-start;
                text-align: left;
            }

            .admin-mentor-page .page-header p {
                text-align: left;
            }

            .admin-mentor-page .stats-badge {
                margin-top: 0;
                text-align: right;
                padding: 0.75rem 1.25rem;
                font-size: 0.9rem;
            }

            .admin-mentor-page .alert .d-flex {
                flex-direction: row;
                text-align: left;
            }

            .admin-mentor-page .alert-icon {
                margin: 0 1rem 0 0;
            }

            .admin-mentor-page .card-header-custom {
                padding: 1.75rem;
            }

            .admin-mentor-page .card-title-wrapper {
                flex-direction: row;
                justify-content: flex-start;
                text-align: left;
            }

            .admin-mentor-page .icon-wrapper {
                margin-right: 1rem;
                width: 48px;
                height: 48px;
                font-size: 1.2rem;
            }

            .admin-mentor-page .card-title-custom {
                font-size: 1.4rem;
            }

            .admin-mentor-page .controls-section {
                flex-direction: row;
                justify-content: flex-end;
                margin-top: 0;
            }

            .admin-mentor-page .search-wrapper {
                min-width: 250px;
            }

            .admin-mentor-page .custom-table {
                font-size: 0.9rem;
            }

            .admin-mentor-page .custom-table th {
                padding: 1.25rem;
                font-size: 0.8rem;
            }

            .admin-mentor-page .custom-table td {
                padding: 1.25rem;
            }

            .admin-mentor-page .user-card {
                flex-direction: row;
                text-align: left;
                gap: 1rem;
            }

            .admin-mentor-page .avatar {
                width: 50px;
                height: 50px;
                font-size: 1.1rem;
            }

            .admin-mentor-page .user-meta {
                justify-content: flex-start;
            }

            .admin-mentor-page .contact-card {
                text-align: left;
            }

            .admin-mentor-page .email-link {
                justify-content: flex-start;
                font-size: 0.85rem;
            }

            .admin-mentor-page .date-info {
                justify-content: flex-start;
                font-size: 0.8rem;
            }

            .admin-mentor-page .action-buttons {
                flex-direction: row;
                gap: 0.75rem;
            }

            .admin-mentor-page .btn-custom {
                font-size: 0.85rem;
            }

            .admin-mentor-page .card-footer-custom {
                padding: 1.25rem;
                flex-wrap: nowrap;
            }

            .admin-mentor-page .footer-info {
                font-size: 0.85rem;
            }

            .admin-mentor-page .refresh-btn {
                font-size: 0.85rem;
            }

            .admin-mentor-page .empty-state {
                padding: 3rem 2rem;
            }

            .admin-mentor-page .empty-state i {
                font-size: 3.5rem;
            }

            .admin-mentor-page .empty-state h5 {
                font-size: 1.2rem;
            }

            .admin-mentor-page .empty-state p {
                font-size: 0.95rem;
            }
        }

        /* ===== DESKTOP SMALL (768px and up) ===== */
        @media (min-width: 768px) {
            .admin-mentor-page .container-fluid {
                padding: 2rem;
                max-width: 1200px;
            }

            .admin-mentor-page .page-header {
                border-radius: 16px;
            }

            .admin-mentor-page .page-header h2 {
                font-size: 1.65rem;
            }

            .admin-mentor-page .page-header h2 i {
                font-size: 1.4rem;
                margin-right: 1rem;
            }

            .admin-mentor-page .page-header p {
                font-size: 1rem;
            }

            .admin-mentor-page .stats-badge {
                padding: 0.75rem 1.5rem;
                font-size: 0.95rem;
            }

            .admin-mentor-page .card-header-custom {
                padding: 2rem;
            }

            .admin-mentor-page .icon-wrapper {
                width: 50px;
                height: 50px;
                font-size: 1.25rem;
                border-radius: 12px;
            }

            .admin-mentor-page .card-title-custom {
                font-size: 1.5rem;
            }

            .admin-mentor-page .search-wrapper {
                min-width: 300px;
            }

            .admin-mentor-page .search-input {
                padding: 0.75rem 1rem 0.75rem 3rem;
            }

            .admin-mentor-page .search-icon {
                left: 1rem;
                font-size: 1rem;
            }

            .admin-mentor-page .clear-search {
                right: 0.75rem;
                font-size: 1rem;
            }

            .admin-mentor-page .custom-table {
                font-size: 1rem;
            }

            .admin-mentor-page .custom-table th {
                padding: 1.5rem;
                font-size: 0.85rem;
                border-bottom: 3px solid #007bff;
            }

            .admin-mentor-page .custom-table td {
                padding: 1.5rem;
            }

            .admin-mentor-page .custom-table tbody tr:hover {
                background: linear-gradient(135deg, rgba(0, 123, 255, 0.03) 0%, rgba(0, 123, 255, 0.08) 100%);
                transform: scale(1.002);
                box-shadow: 0 4px 12px rgba(0, 0, 0, 0.05);
            }

            .admin-mentor-page .avatar {
                width: 55px;
                height: 55px;
                font-size: 1.2rem;
            }

            .admin-mentor-page .user-info h6 {
                font-size: 1rem;
            }

            .admin-mentor-page .badge-custom {
                font-size: 0.7rem;
                padding: 0.25rem 0.6rem;
            }

            .admin-mentor-page .email-link {
                font-size: 0.9rem;
                margin-bottom: 0.75rem;
            }

            .admin-mentor-page .date-info {
                font-size: 0.85rem;
            }

            .admin-mentor-page .btn-custom {
                padding: 0.5rem 1.1rem;
                font-size: 0.9rem;
                min-width: 110px;
            }

            .admin-mentor-page .card-footer-custom {
                padding: 1.5rem;
            }

            .admin-mentor-page .footer-info {
                font-size: 0.9rem;
            }

            .admin-mentor-page .refresh-btn {
                font-size: 0.9rem;
            }

            .admin-mentor-page .dataTables_length {
                margin: 1.25rem;
            }

            .admin-mentor-page .dataTables_info {
                margin: 1.25rem;
                font-size: 0.85rem;
            }

            .admin-mentor-page .dataTables_paginate {
                margin: 1.25rem;
            }

            .admin-mentor-page .page-link {
                padding: 0.5rem 0.7rem;
                margin: 0 0.15rem;
                font-size: 0.85rem;
            }

            .admin-mentor-page .empty-state {
                padding: 3.5rem;
            }

            .admin-mentor-page .empty-state i {
                font-size: 4rem;
            }

            .admin-mentor-page .empty-state h5 {
                font-size: 1.25rem;
            }
        }

        /* ===== DESKTOP LARGE (992px and up) ===== */
        @media (min-width: 992px) {
            .admin-mentor-page .container-fluid {
                max-width: 1300px;
            }

            .admin-mentor-page .page-header h2 {
                font-size: 1.75rem;
            }

            .admin-mentor-page .page-header h2 i {
                font-size: 1.5rem;
            }

            .admin-mentor-page .stats-badge {
                font-size: 1rem;
            }

            .admin-mentor-page .custom-table th {
                padding: 1.75rem;
                font-size: 0.9rem;
            }

            .admin-mentor-page .custom-table td {
                padding: 1.75rem;
            }

            .admin-mentor-page .avatar {
                width: 60px;
                height: 60px;
                font-size: 1.25rem;
            }

            .admin-mentor-page .user-info h6 {
                font-size: 1.1rem;
            }

            .admin-mentor-page .badge-custom {
                font-size: 0.75rem;
                padding: 0.25rem 0.75rem;
            }

            .admin-mentor-page .email-link {
                font-size: 0.95rem;
            }

            .admin-mentor-page .date-info {
                font-size: 0.9rem;
            }

            .admin-mentor-page .btn-custom {
                padding: 0.5rem 1.25rem;
                font-size: 0.9rem;
                min-width: 120px;
            }

            .admin-mentor-page .dataTables_length {
                margin: 1.5rem;
            }

            .admin-mentor-page .dataTables_info {
                margin: 1.5rem;
                font-size: 0.9rem;
            }

            .admin-mentor-page .dataTables_paginate {
                margin: 1.5rem;
            }

            .admin-mentor-page .page-link {
                padding: 0.5rem 0.75rem;
                margin: 0 0.2rem;
                font-size: 0.9rem;
            }

            .admin-mentor-page .empty-state {
                padding: 4rem;
            }

            .admin-mentor-page .empty-state i {
                font-size: 4.5rem;
            }
        }

        /* ===== DESKTOP XL (1200px and up) ===== */
        @media (min-width: 1200px) {
            .admin-mentor-page .container-fluid {
                max-width: 1400px;
            }

            .admin-mentor-page .custom-table th {
                padding: 2rem;
            }

            .admin-mentor-page .custom-table td {
                padding: 2rem;
            }

            .admin-mentor-page .main-card:hover {
                transform: translateY(-2px);
                box-shadow: 0 20px 60px rgba(0, 0, 0, 0.15);
            }

            .admin-mentor-page .dataTables_length {
                margin: 1.5rem 2rem 0;
            }

            .admin-mentor-page .dataTables_info {
                margin: 1.5rem 2rem;
            }

            .admin-mentor-page .dataTables_paginate {
                margin: 1.5rem 2rem;
            }

            .admin-mentor-page .page-link {
                margin: 0 0.25rem;
            }
        }

        /* ===== UTILITY CLASSES ===== */

        /* Hide elements on specific screens */
        .hide-on-mobile {
            display: none;
        }

        @media (min-width: 576px) {
            .hide-on-mobile {
                display: block;
            }

            .hide-on-tablet-up {
                display: none;
            }
        }

        @media (min-width: 768px) {
            .hide-on-desktop {
                display: none;
            }
        }

        /* Scroll behavior */
        .admin-mentor-page .table-container {
            scrollbar-width: thin;
            scrollbar-color: #007bff transparent;
        }

        .admin-mentor-page .table-container::-webkit-scrollbar {
            height: 6px;
        }

        .admin-mentor-page .table-container::-webkit-scrollbar-track {
            background: #f1f1f1;
            border-radius: 10px;
        }

        .admin-mentor-page .table-container::-webkit-scrollbar-thumb {
            background: #007bff;
            border-radius: 10px;
        }

        .admin-mentor-page .table-container::-webkit-scrollbar-thumb:hover {
            background: #0056b3;
        }

        /* Animations */
        @keyframes spin {
            0% {
                transform: rotate(0deg);
            }

            100% {
                transform: rotate(360deg);
            }
        }

        @keyframes pulse {
            0% {
                opacity: 1;
            }

            50% {
                opacity: 0.5;
            }

            100% {
                opacity: 1;
            }
        }

        @keyframes fadeIn {
            from {
                opacity: 0;
                transform: translateY(10px);
            }

            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        @keyframes slideInFromTop {
            from {
                opacity: 0;
                transform: translateY(-20px);
            }

            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        @keyframes slideInFromBottom {
            from {
                opacity: 0;
                transform: translateY(20px);
            }

            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        .admin-mentor-page .fade-in {
            animation: fadeIn 0.3s ease-in-out;
        }

        .admin-mentor-page .slide-in-top {
            animation: slideInFromTop 0.4s ease-out;
        }

        .admin-mentor-page .slide-in-bottom {
            animation: slideInFromBottom 0.4s ease-out;
        }

        /* Focus states untuk accessibility */
        .admin-mentor-page .btn-custom:focus,
        .admin-mentor-page .search-input:focus,
        .admin-mentor-page .refresh-btn:focus {
            outline: 2px solid #007bff;
            outline-offset: 2px;
        }

        /* High contrast mode support */
        @media (prefers-contrast: high) {
            .admin-mentor-page .page-header {
                background: #000;
                color: #fff;
                border: 2px solid #fff;
            }

            .admin-mentor-page .main-card {
                border: 2px solid #000;
            }

            .admin-mentor-page .btn-custom {
                border-width: 3px;
            }
        }

        /* Reduced motion preference */
        @media (prefers-reduced-motion: reduce) {
            .admin-mentor-page * {
                animation-duration: 0.01ms !important;
                animation-iteration-count: 1 !important;
                transition-duration: 0.01ms !important;
            }

            .admin-mentor-page .main-card:hover {
                transform: none;
            }

            .admin-mentor-page .btn-custom:hover {
                transform: none;
            }
        }

        /* Print styles */
        @media print {
            .admin-mentor-page {
                background: white !important;
            }

            .admin-mentor-page .page-header {
                background: white !important;
                color: black !important;
                box-shadow: none !important;
                border: 1px solid #000;
            }

            .admin-mentor-page .main-card {
                box-shadow: none !important;
                border: 1px solid #000;
            }

            .admin-mentor-page .btn-custom,
            .admin-mentor-page .refresh-btn,
            .admin-mentor-page .controls-section {
                display: none !important;
            }

            .admin-mentor-page .custom-table {
                font-size: 10px !important;
            }

            .admin-mentor-page .custom-table th,
            .admin-mentor-page .custom-table td {
                padding: 0.5rem !important;
                border: 1px solid #000 !important;
            }
        }

        /* Dark mode support (jika diperlukan) */
        @media (prefers-color-scheme: dark) {
            .admin-mentor-page {
                background-color: #1a1a1a;
                color: #e0e0e0;
            }

            .admin-mentor-page .main-card {
                background: #2d2d2d;
                color: #e0e0e0;
            }

            .admin-mentor-page .card-header-custom {
                background: #2d2d2d;
                border-bottom-color: #404040;
            }

            .admin-mentor-page .custom-table {
                background: #2d2d2d;
                color: #e0e0e0;
            }

            .admin-mentor-page .custom-table thead {
                background: #404040;
            }

            .admin-mentor-page .custom-table th {
                color: #e0e0e0;
            }

            .admin-mentor-page .custom-table td {
                border-top-color: #404040;
            }

            .admin-mentor-page .custom-table tbody tr:hover {
                background: rgba(0, 123, 255, 0.1);
            }

            .admin-mentor-page .search-input {
                background-color: #404040;
                border-color: #555;
                color: #e0e0e0;
            }

            .admin-mentor-page .search-input::placeholder {
                color: #aaa;
            }

            .admin-mentor-page .card-footer-custom {
                background: #404040;
                border-top-color: #555;
            }

            .admin-mentor-page .dataTables_length select {
                background: #404040;
                color: #e0e0e0;
                border-color: #555;
            }
        }

        /* Touch device optimizations */
        @media (hover: none) and (pointer: coarse) {
            .admin-mentor-page .btn-custom {
                min-height: 44px;
                /* Minimum touch target size */
                padding: 0.75rem 1rem;
            }

            .admin-mentor-page .search-input {
                min-height: 44px;
                font-size: 16px;
                /* Prevent zoom on iOS */
            }

            .admin-mentor-page .page-link {
                min-height: 44px;
                min-width: 44px;
                display: flex;
                align-items: center;
                justify-content: center;
            }

            .admin-mentor-page .refresh-btn {
                min-height: 44px;
            }

            /* Remove hover effects on touch devices */
            .admin-mentor-page .custom-table tbody tr:hover {
                background: inherit;
                transform: none;
                box-shadow: none;
            }

            .admin-mentor-page .main-card:hover {
                transform: none;
                box-shadow: 0 10px 40px rgba(0, 0, 0, 0.1);
            }
        }

        /* Landscape phone specific styles */
        @media (max-width: 767px) and (orientation: landscape) {
            .admin-mentor-page .page-header {
                padding: 1rem;
            }

            .admin-mentor-page .page-header h2 {
                font-size: 1.1rem;
            }

            .admin-mentor-page .stats-badge {
                font-size: 0.8rem;
                padding: 0.5rem 0.75rem;
            }

            .admin-mentor-page .custom-table th,
            .admin-mentor-page .custom-table td {
                padding: 0.75rem;
                font-size: 0.8rem;
            }

            .admin-mentor-page .avatar {
                width: 40px;
                height: 40px;
                font-size: 0.9rem;
            }

            .admin-mentor-page .user-info h6 {
                font-size: 0.85rem;
            }

            .admin-mentor-page .btn-custom {
                padding: 0.4rem 0.8rem;
                font-size: 0.75rem;
                min-width: 80px;
            }
        }

        /* Very small screens (320px - iPhone 5/SE) */
        @media (max-width: 320px) {
            .admin-mentor-page .container-fluid {
                padding: 0.75rem;
            }

            .admin-mentor-page .page-header {
                padding: 1rem;
                border-radius: 8px;
            }

            .admin-mentor-page .page-header h2 {
                font-size: 1.1rem;
                flex-direction: column;
                gap: 0.5rem;
            }

            .admin-mentor-page .page-header h2 i {
                margin-right: 0;
            }

            .admin-mentor-page .stats-badge {
                font-size: 0.75rem;
                padding: 0.4rem 0.8rem;
            }

            .admin-mentor-page .card-header-custom {
                padding: 1rem;
            }

            .admin-mentor-page .icon-wrapper {
                width: 35px;
                height: 35px;
                font-size: 0.9rem;
            }

            .admin-mentor-page .card-title-custom {
                font-size: 1.1rem;
            }

            .admin-mentor-page .search-input {
                font-size: 0.9rem;
                padding: 0.6rem 0.8rem 0.6rem 2rem;
            }

            .admin-mentor-page .custom-table {
                font-size: 0.75rem;
            }

            .admin-mentor-page .custom-table th,
            .admin-mentor-page .custom-table td {
                padding: 0.75rem 0.5rem;
            }

            .admin-mentor-page .avatar {
                width: 35px;
                height: 35px;
                font-size: 0.8rem;
            }

            .admin-mentor-page .user-info h6 {
                font-size: 0.8rem;
            }

            .admin-mentor-page .badge-custom {
                font-size: 0.6rem;
                padding: 0.15rem 0.4rem;
            }

            .admin-mentor-page .email-link {
                font-size: 0.75rem;
            }

            .admin-mentor-page .date-info {
                font-size: 0.7rem;
            }

            .admin-mentor-page .btn-custom {
                padding: 0.4rem 0.7rem;
                font-size: 0.7rem;
                min-width: 75px;
            }

            .admin-mentor-page .card-footer-custom {
                padding: 0.75rem;
                flex-direction: column;
                gap: 0.75rem;
            }

            .admin-mentor-page .footer-info {
                font-size: 0.7rem;
            }

            .admin-mentor-page .refresh-btn {
                font-size: 0.75rem;
                padding: 0.4rem 0.8rem;
            }

            .admin-mentor-page .dataTables_length,
            .admin-mentor-page .dataTables_info,
            .admin-mentor-page .dataTables_paginate {
                margin: 0.75rem;
            }

            .admin-mentor-page .page-link {
                padding: 0.3rem 0.5rem;
                font-size: 0.7rem;
            }
        }

        /* Large screens optimization (1400px+) */
        @media (min-width: 1400px) {
            .admin-mentor-page .container-fluid {
                max-width: 1600px;
            }

            .admin-mentor-page .custom-table th {
                padding: 2.5rem;
            }

            .admin-mentor-page .custom-table td {
                padding: 2.5rem;
            }

            .admin-mentor-page .avatar {
                width: 65px;
                height: 65px;
                font-size: 1.3rem;
            }

            .admin-mentor-page .user-info h6 {
                font-size: 1.15rem;
            }

            .admin-mentor-page .btn-custom {
                min-width: 130px;
                padding: 0.6rem 1.5rem;
            }
        }

        /* Performance optimizations */
        .admin-mentor-page * {
            -webkit-font-smoothing: antialiased;
            -moz-osx-font-smoothing: grayscale;
        }

        .admin-mentor-page .custom-table {
            table-layout: fixed;
            width: 100%;
        }

        .admin-mentor-page .custom-table td {
            word-wrap: break-word;
            overflow-wrap: break-word;
        }

        /* Accessibility improvements */
        .admin-mentor-page .btn-custom:focus-visible,
        .admin-mentor-page .search-input:focus-visible,
        .admin-mentor-page .refresh-btn:focus-visible {
            outline: 3px solid #007bff;
            outline-offset: 2px;
        }

        .admin-mentor-page .sr-only {
            position: absolute;
            width: 1px;
            height: 1px;
            padding: 0;
            margin: -1px;
            overflow: hidden;
            clip: rect(0, 0, 0, 0);
            white-space: nowrap;
            border: 0;
        }

        /* Error states */
        .admin-mentor-page .has-error .search-input {
            border-color: #dc3545;
            box-shadow: 0 0 0 0.2rem rgba(220, 53, 69, 0.25);
        }

        .admin-mentor-page .error-message {
            color: #dc3545;
            font-size: 0.8rem;
            margin-top: 0.25rem;
            display: flex;
            align-items: center;
            gap: 0.5rem;
        }

        /* Loading states */
        .admin-mentor-page .loading-overlay {
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background: rgba(255, 255, 255, 0.8);
            display: flex;
            align-items: center;
            justify-content: center;
            z-index: 1000;
        }

        .admin-mentor-page .loading-pulse {
            animation: loadingPulse 1s infinite;
        }

        @keyframes loadingPulse {

            0%,
            100% {
                opacity: 1;
            }

            50% {
                opacity: 0.7;
            }
        }

        /* Success/Failure visual feedback */
        .admin-mentor-page .success-flash {
            animation: successFlash 0.6s ease-in-out;
        }

        @keyframes successFlash {
            0% {
                background-color: transparent;
            }

            50% {
                background-color: rgba(40, 167, 69, 0.2);
            }

            100% {
                background-color: transparent;
            }
        }

        .admin-mentor-page .error-flash {
            animation: errorFlash 0.6s ease-in-out;
        }

        @keyframes errorFlash {
            0% {
                background-color: transparent;
            }

            50% {
                background-color: rgba(220, 53, 69, 0.2);
            }

            100% {
                background-color: transparent;
            }
        }
    </style>

    <div class="admin-mentor-page">
        <div class="container-fluid">
            <!-- Header Section -->
            <div class="page-header">
                <div class="row align-items-center">
                    <div class="col-md-8">
                        <h2>
                            <i class="fas fa-user-graduate"></i>
                            Daftar Calon Mentor
                        </h2>
                        <p>Kelola permohonan mentor yang masuk ke sistem</p>
                    </div>
                    <div class="col-md-4 text-md-end mt-3 mt-md-0">
                        <div class="stats-badge">
                            <i class="fas fa-clock me-2"></i>
                            <strong id="pending-count">-</strong> Menunggu Persetujuan
                        </div>
                    </div>
                </div>
            </div>

            <!-- Alert Messages -->
            @if (session('success'))
                <div class="alert alert-success alert-dismissible fade show">
                    <div class="d-flex align-items-center">
                        <div class="alert-icon">
                            <i class="fas fa-check-circle"></i>
                        </div>
                        <div>
                            <strong>Berhasil!</strong> {{ session('success') }}
                        </div>
                        <button type="button" class="btn-close ms-auto" data-bs-dismiss="alert"></button>
                    </div>
                </div>
            @endif

            @if (session('error'))
                <div class="alert alert-danger alert-dismissible fade show">
                    <div class="d-flex align-items-center">
                        <div class="alert-icon">
                            <i class="fas fa-exclamation-triangle"></i>
                        </div>
                        <div>
                            <strong>Error!</strong> {{ session('error') }}
                        </div>
                        <button type="button" class="btn-close ms-auto" data-bs-dismiss="alert"></button>
                    </div>
                </div>
            @endif

            <!-- Main Card -->
            <div class="main-card">
                <!-- Card Header -->
                <div class="card-header-custom">
                    <div class="row align-items-center">
                        <div class="col-lg-6">
                            <div class="card-title-wrapper">
                                <div class="icon-wrapper">
                                    <i class="fas fa-users"></i>
                                </div>
                                <div>
                                    <h5 class="card-title-custom">Data Calon Mentor</h5>
                                    <p class="card-subtitle">Daftar permohonan yang perlu diproses</p>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-6 mt-3 mt-lg-0">
                            <div class="controls-section">
                                <!-- Filter Dropdown -->


                                <!-- Search Box -->
                                <div class="search-wrapper">
                                    <i class="fas fa-search search-icon"></i>
                                    <input type="text" class="search-input" id="search-box"
                                        placeholder="Cari nama mentor atau email...">
                                    <button class="clear-search" id="clear-search" style="display: none;">
                                        <i class="fas fa-times"></i>
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Table Container -->
                <div class="table-container">
                    <table class="custom-table" id="mentors-table">
                        <thead>
                            <tr>
                                <th>
                                    <i class="fas fa-user me-2"></i>
                                    Informasi Mentor
                                </th>
                                <th>
                                    <i class="fas fa-envelope me-2"></i>
                                    Kontak & Detail
                                </th>
                                <th style="text-align: center;">
                                    <i class="fas fa-cogs me-2"></i>
                                    Tindakan
                                </th>
                            </tr>
                        </thead>
                        <tbody>
                            <!-- Data will be loaded by DataTables -->
                        </tbody>
                    </table>
                </div>

                <!-- Card Footer -->
                <div class="card-footer-custom">
                    <div class="footer-info">
                        <i class="fas fa-info-circle"></i>
                        Data diperbarui secara real-time
                    </div>
                    <button class="refresh-btn" onclick="refreshTable()">
                        <i class="fas fa-sync-alt"></i>
                        Refresh Data
                    </button>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('styles')
    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.4/css/dataTables.bootstrap5.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
@endpush

@push('scripts')
    <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
    <script src="https://cdn.datatables.net/1.13.4/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/1.13.4/js/dataTables.bootstrap5.min.js"></script>

    <script>
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });
        $(function() {
            let table;

            // Initialize DataTable
            table = $('#mentors-table').DataTable({
                processing: true,
                serverSide: true,
                ajax: {
                    url: '{{ route('mentor.pending') }}',
                    dataSrc: function(json) {
                        // Update pending count
                        $('#pending-count').text(json.recordsTotal || 0);
                        return json.data;
                    }
                },
                columns: [{
                        data: 'name',
                        name: 'name',
                        render: function(data, type, row) {
                            // Generate colors for avatars
                            const colors = [
                                'linear-gradient(135deg, #667eea 0%, #764ba2 100%)',
                                'linear-gradient(135deg, #f093fb 0%, #f5576c 100%)',
                                'linear-gradient(135deg, #4facfe 0%, #00f2fe 100%)',
                                'linear-gradient(135deg, #43e97b 0%, #38f9d7 100%)',
                                'linear-gradient(135deg, #fa709a 0%, #fee140 100%)',
                                'linear-gradient(135deg, #a8edea 0%, #fed6e3 100%)',
                                'linear-gradient(135deg, #ff9a9e 0%, #fecfef 100%)',
                                'linear-gradient(135deg, #ffecd2 0%, #fcb69f 100%)'
                            ];
                            const colorIndex = data.charAt(0).toLowerCase().charCodeAt(0) % colors
                                .length;

                            return `
                        <div class="user-card fade-in">
                            <div class="avatar" style="background: ${colors[colorIndex]};">
                                ${data.charAt(0).toUpperCase()}
                            </div>
                            <div class="user-info">
                                <h6>${data}</h6>
                                <div class="user-meta">
                                    <span class="badge-custom">
                                        <i class="fas fa-id-badge"></i>
                                        ID: ${row.id || 'N/A'}
                                    </span>

                                </div>
                            </div>
                        </div>
                    `;
                        }
                    },
                    {
                        data: 'email',
                        name: 'email',
                        render: function(data, type, row) {
                            let createdDateFormatted = 'Tidak diketahui';

                            if (row.created_at) {
                                // Pecah string tanggal manual
                                const parts = row.created_at.split(
                                    ' '); // ["11", "Agustus", "2025", "12:23"]
                                const bulanMap = {
                                    'Januari': 0,
                                    'Februari': 1,
                                    'Maret': 2,
                                    'April': 3,
                                    'Mei': 4,
                                    'Juni': 5,
                                    'Juli': 6,
                                    'Agustus': 7,
                                    'September': 8,
                                    'Oktober': 9,
                                    'November': 10,
                                    'Desember': 11
                                };

                                const day = parseInt(parts[0]);
                                const month = bulanMap[parts[1]];
                                const year = parseInt(parts[2]);

                                // Buat object date
                                const jsDate = new Date(year, month, day);

                                createdDateFormatted = jsDate.toLocaleDateString('id-ID', {
                                    year: 'numeric',
                                    month: 'short',
                                    day: 'numeric'
                                });
                            }

                            return `
        <div class="contact-card fade-in">
            <a href="mailto:${data}" class="email-link">
                <i class="fas fa-envelope"></i>
                ${data}
            </a>
            <div class="date-info">
                <i class="fas fa-calendar-plus"></i>
                Mendaftar: ${createdDateFormatted}
            </div>
        </div>
    `;
                        }

                    },
                    {
                        data: 'aksi',
                        name: 'aksi',
                        orderable: false,
                        searchable: false,
                        className: 'text-center',
                        render: function(data, type, row) {
                            // Parse the action buttons and enhance them
                            const tempDiv = $('<div>').html(data);

                            // Find and enhance approve button
                            tempDiv.find('form').each(function() {
                                const form = $(this);
                                const button = form.find('button');

                                if (button.hasClass('btn-success')) {
                                    button.removeClass('btn btn-success btn-sm').addClass(
                                        'btn-custom btn-approve');
                                    button.html('<i class="fas fa-check"></i> Setujui');
                                } else if (button.hasClass('btn-danger')) {
                                    button.removeClass('btn btn-danger btn-sm').addClass(
                                        'btn-custom btn-reject');
                                    button.html('<i class="fas fa-times"></i> Tolak');
                                }
                            });

                            return `<div class="action-buttons fade-in">${tempDiv.html()}</div>`;
                        }
                    }
                ],
                dom: '<"row"<"col-sm-12 col-md-6"l>>rt<"row"<"col-sm-12 col-md-5"i><"col-sm-12 col-md-7"p>>',
                language: {
                    processing: `
                <div class="processing-state">
                    <div class="loading-spinner"></div>
                    <h5>Memuat Data...</h5>
                    <p>Harap tunggu sebentar</p>
                </div>
            `,
                    lengthMenu: "Tampilkan _MENU_ data per halaman",
                    zeroRecords: `
                <div class="empty-state">
                    <i class="fas fa-search"></i>
                    <h5>Tidak Ada Data Ditemukan</h5>
                    <p>Coba ubah kata kunci pencarian atau filter yang Anda gunakan</p>
                    <button class="btn-custom btn-approve" onclick="resetFilters()">
                        <i class="fas fa-undo"></i> Reset Filter
                    </button>
                </div>
            `,
                    info: "Menampilkan _START_ sampai _END_ dari _TOTAL_ data",
                    infoEmpty: "Tidak ada data untuk ditampilkan",
                    infoFiltered: "(difilter dari _MAX_ total data)",
                    search: "",
                    searchPlaceholder: "Cari nama atau email...",
                    paginate: {
                        first: '<i class="fas fa-angle-double-left"></i>',
                        last: '<i class="fas fa-angle-double-right"></i>',
                        next: '<i class="fas fa-angle-right"></i>',
                        previous: '<i class="fas fa-angle-left"></i>'
                    }
                },
                pageLength: 10,
                lengthMenu: [
                    [10, 25, 50, 100],
                    [10, 25, 50, 100]
                ],
                order: [
                    [0, 'asc']
                ],
                drawCallback: function() {
                    // Reinitialize tooltips and add animations
                    $('[data-bs-toggle="tooltip"]').tooltip();

                    // Add entrance animations
                    $('#mentors-table tbody tr').addClass('fade-in');
                },

            });

            // Enhanced search functionality
            let searchTimeout;
            $('#search-box').on('keyup input', function() {
                const $this = $(this);
                const searchTerm = $this.val().trim();

                // Show/hide clear button
                $('#clear-search').toggle(searchTerm.length > 0);

                // Clear previous timeout
                clearTimeout(searchTimeout);

                // Set new timeout for search
                searchTimeout = setTimeout(function() {
                    table.search(searchTerm).draw();
                }, 300);
            });

            // Clear search functionality
            $('#clear-search').on('click', function() {
                $('#search-box').val('').focus();
                $(this).hide();
                table.search('').draw();
                showToast('Pencarian dibersihkan', 'info', 2000);
            });

            // Filter functionality
            $(document).on('click', '[data-filter]', function(e) {
                e.preventDefault();
                const filter = $(this).data('filter');
                const filterText = $(this).text();

                // Update dropdown button text
                $(this).closest('.dropdown').find('.dropdown-toggle').html(`
            <i class="fas fa-filter me-2"></i>${filterText}
        `);

                // Apply filter logic (customize based on your backend)
                let searchTerm = '';
                const today = new Date();

                switch (filter) {
                    case 'today':
                        // You can implement date filtering on backend
                        showToast(`Filter "${filterText}" diterapkan`, 'info', 3000);
                        break;
                    case 'week':
                        showToast(`Filter "${filterText}" diterapkan`, 'info', 3000);
                        break;
                    case 'month':
                        showToast(`Filter "${filterText}" diterapkan`, 'info', 3000);
                        break;
                    default:
                        // Show all
                        table.search('').draw();
                        showToast('Semua data ditampilkan', 'info', 2000);
                }

                // You can extend this to send additional parameters to your backend
                // table.ajax.url('{{ route('mentor.pending') }}?filter=' + filter).load();
            });

            // Refresh table function
            window.refreshTable = function() {
                const btn = event.target.closest('.refresh-btn');
                const originalHtml = btn.innerHTML;

                // Show loading state
                btn.innerHTML = '<i class="fas fa-spinner fa-spin"></i> Memuat...';
                btn.disabled = true;

                // Reload table data
                table.ajax.reload(function() {
                    // Restore button state
                    btn.innerHTML = originalHtml;
                    btn.disabled = false;

                    // Show success message
                    showToast('Data berhasil diperbarui', 'success', 3000);
                }, false);
            };

            // Reset filters function
            window.resetFilters = function() {
                // Clear search
                $('#search-box').val('');
                $('#clear-search').hide();



                // Clear table search and reload
                table.search('').draw();

                showToast('Semua filter berhasil direset', 'info', 3000);
            };

            // Enhanced form submission handling
            $(document).on('submit', 'form', function(e) {
                e.preventDefault();
                const form = $(this);
                const submitBtn = form.find('button[type="submit"]');
                const originalText = submitBtn.html();
                const mentorName = form.closest('tr').find('.user-info h6').text().trim();
                const isApprove = submitBtn.hasClass('btn-approve');

                // Show loading state
                submitBtn.prop('disabled', true).html(`
            <i class="fas fa-spinner fa-spin"></i>
            ${isApprove ? 'Menyetujui...' : 'Menolak...'}
        `);

                // AJAX request
                $.ajax({
                    url: form.attr('action'),
                    method: 'POST',
                    data: form.serialize(),
                    success: function(response) {
                        // Reload table
                        table.ajax.reload(null, false);

                        // Show success message

                        showToast(`Permohonan mentor "${mentorName}" berhasil`,
                            'success', 5000);
                    },

                    error: function(xhr) {
                        console.error('Form submission error:', xhr);
                        let errorMsg = 'Terjadi kesalahan sistem';

                        if (xhr.responseJSON && xhr.responseJSON.message) {
                            errorMsg = xhr.responseJSON.message;
                        } else if (xhr.status === 422) {
                            errorMsg = 'Data yang dikirim tidak valid';
                        } else if (xhr.status === 500) {
                            errorMsg = 'Terjadi kesalahan server';
                        }

                        showToast(errorMsg, 'error', 7000);
                    },
                    complete: function() {
                        // Restore button state after delay
                        setTimeout(() => {
                            submitBtn.prop('disabled', false).html(originalText);
                        }, 500);
                    }
                });
            });

            // Enhanced toast notification system
            function showToast(message, type = 'info', duration = 5000) {
                const toastId = 'toast-' + Date.now();
                const iconMap = {
                    'success': 'check-circle',
                    'error': 'exclamation-triangle',
                    'warning': 'exclamation-circle',
                    'info': 'info-circle'
                };

                const colorMap = {
                    'success': 'success',
                    'error': 'danger',
                    'warning': 'warning',
                    'info': 'info'
                };

                const toastHtml = `
            <div id="${toastId}" class="toast align-items-center text-white bg-${colorMap[type]} border-0 shadow-lg"
                 role="alert" data-bs-delay="${duration}" style="min-width: 350px;">
                <div class="d-flex">
                    <div class="toast-body d-flex align-items-center py-3">
                        <i class="fas fa-${iconMap[type]} me-3 fs-5"></i>
                        <div>
                            <div class="fw-bold mb-1">${type.charAt(0).toUpperCase() + type.slice(1)}</div>
                            <div>${message}</div>
                        </div>
                    </div>
                    <button type="button" class="btn-close btn-close-white me-2 m-auto"
                            data-bs-dismiss="toast" aria-label="Close"></button>
                </div>
            </div>
        `;

                // Create toast container if needed
                if (!$('#toast-container').length) {
                    $('body').append(`
                <div id="toast-container" class="toast-container position-fixed top-0 end-0 p-3"
                     style="z-index: 1060;"></div>
            `);
                }

                // Add toast to container
                const $toast = $(toastHtml);
                $('#toast-container').append($toast);

                // Initialize Bootstrap toast
                const toast = new bootstrap.Toast($toast[0], {
                    autohide: true,
                    delay: duration
                });

                // Show toast with animation
                toast.show();
                $toast.addClass('fade-in');

                // Clean up after toast is hidden
                $toast.on('hidden.bs.toast', function() {
                    $(this).remove();
                });

                // Limit number of toasts
                const toastCount = $('#toast-container .toast').length;
                if (toastCount > 3) {
                    $('#toast-container .toast').first().remove();
                }
            }

            // Keyboard shortcuts
            $(document).on('keydown', function(e) {
                // Ctrl/Cmd + K for search focus
                if ((e.ctrlKey || e.metaKey) && e.keyCode === 75) {
                    e.preventDefault();
                    $('#search-box').focus();
                    showToast('Mode pencarian aktif', 'info', 2000);
                }

                // ESC to clear search and blur
                if (e.keyCode === 27) {
                    if ($('#search-box').is(':focus')) {
                        $('#search-box').val('').blur();
                        $('#clear-search').hide();
                        table.search('').draw();
                        showToast('Pencarian dibatalkan', 'info', 2000);
                    }
                }
            });

            // Auto-refresh functionality (every 5 minutes)
            setInterval(function() {
                // Only refresh if page is visible
                if (document.visibilityState === 'visible') {
                    table.ajax.reload(null, false);
                }
            }, 300000); // 5 minutes

            // Enhanced table interactions
            $(document).on('click', '#mentors-table tbody tr', function(e) {
                // Don't trigger if clicking on action buttons
                if (!$(e.target).closest('.action-buttons').length) {
                    $(this).toggleClass('table-active');
                }
            });

            // Tooltip initialization for dynamic content
            $(document).on('mouseenter', '.btn-custom', function() {
                let tooltipText = '';


                if (tooltipText) {
                    $(this).attr('title', tooltipText).tooltip({
                        placement: 'top',
                        trigger: 'hover'
                    });
                }
            });

            // Performance optimization
            let resizeTimeout;
            $(window).on('resize', function() {
                clearTimeout(resizeTimeout);
                resizeTimeout = setTimeout(function() {
                    table.columns.adjust().responsive.recalc();
                }, 250);
            });

            // Error handling for DataTables
            table.on('error.dt', function(e, settings, techNote, message) {
                console.error('DataTable Error:', message);
                showToast('Gagal memuat data. Silakan refresh halaman atau coba lagi.', 'error', 8000);
            });

            // Success indicator for operations
            $(document).on('click', '.btn-approve', function() {
                const mentorName = $(this).closest('tr').find('.user-info h6').text();
                // Visual feedback before AJAX
                $(this).addClass('loading-pulse');
            });

            $(document).on('click', '.btn-reject', function() {
                const mentorName = $(this).closest('tr').find('.user-info h6').text();
                // Visual feedback before AJAX
                $(this).addClass('loading-pulse');
            });

            // Initialize page

        });

        // Utility functions for external use
        window.mentorDashboard = {
            refreshTable: function() {
                refreshTable();
            },
            resetFilters: function() {
                resetFilters();
            },
            showToast: function(message, type, duration) {
                showToast(message, type, duration);
            },
            searchMentor: function(term) {
                $('#search-box').val(term).trigger('keyup');
            }
        };

        // Add loading pulse animation CSS
        const style = document.createElement('style');
        style.textContent = `
    .loading-pulse {
        animation: loadingPulse 1s infinite;
    }

    @keyframes loadingPulse {
        0%, 100% { opacity: 1; }
        50% { opacity: 0.7; }
    }
`;
        document.head.appendChild(style);
    </script>
@endpush
