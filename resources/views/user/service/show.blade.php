@extends('layouts.user.app')

@section('title', $title)

@section('content')
    <style>
        .service__echoes-section {
            margin-top: 2rem;
            text-align: center;
        }

        .service__echoes-title {
            font-size: 2rem;
            font-weight: 800;
            color: #1f2937;
            text-align: center;
            margin-bottom: 1.75rem;
            text-transform: uppercase;
            letter-spacing: 1px;
            display: inline-block;
            border-bottom: 3px solid #1f2937;
            padding-bottom: 8px;
        }

        .service__echoes-container {
            background: #fff;
            border-radius: 12px;
            box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1), 0 2px 4px -1px rgba(0, 0, 0, 0.06);
            overflow: hidden;
            margin-bottom: 1.5rem;
        }

        .service__echoes-table {
            width: 100%;
            border-collapse: collapse;
            font-size: 1.15rem;
        }

        .service__echoes-table thead {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        }

        .service__echoes-table th {
            padding: 1.1rem;
            text-align: center;
            color: #fff;
            font-weight: 600;
            font-size: 1.3rem;
            text-transform: uppercase;
            letter-spacing: 0.5px;
        }

        .service__echoes-table tbody tr {
            border-bottom: 1px solid #e5e7eb;
            transition: background-color 0.2s ease;
        }

        .service__echoes-table tbody tr:hover {
            background-color: #f8fafc;
        }

        .service__echoes-table tbody tr:last-child {
            border-bottom: none;
        }

        .service__echoes-table td {
            padding: 1.1rem;
            text-align: center;
            color: #374151;
            font-weight: 500;
        }

        .service__echoes-table td:first-child {
            font-weight: 600;
            color: #1f2937;
            font-size: 1.35rem;
        }

        .service__echoes-table td:last-child {
            color: #059669;
            font-weight: 700;
            font-size: 1.4rem;
        }

        .service__echoes-actions {
            text-align: center;
        }

        .service__btn {
            display: inline-block;
            padding: 0.75rem 2rem;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: #fff;
            text-decoration: none;
            border-radius: 8px;
            font-weight: 600;
            font-size: 1rem;
            transition: all 0.3s ease;
            border: none;
            cursor: pointer;
            text-align: center;
        }

        .service__btn:hover {
            transform: translateY(-2px);
            box-shadow: 0 8px 25px rgba(102, 126, 234, 0.4);
            color: #fff;
            text-decoration: none;
        }

        .service__btn--block {
            width: 100%;
            max-width: 300px;
        }

        .service__btn i {
            margin-right: 0.5rem;
        }

        @media (max-width: 768px) {
            .service__echoes-table {
                font-size: 0.9rem;
            }
            
            .service__echoes-table th,
            .service__echoes-table td {
                padding: 0.75rem 0.5rem;
            }
        }
    </style>

    <div class="service">
        <div class="container">
            

            <!-- Bảng Echoes -->
            <div class="service__echoes-section">
                @php($echoesCover = config_get('echoes_cover_image'))
                @if(!empty($echoesCover))
                    <div class="mb-3">
                        <img src="{{ $echoesCover }}" alt="Echoes Cover" style="max-width: 100%; height: auto; border-radius: 12px;">
                    </div>
                @endif
                <h3 class="service__echoes-title">BẢNG GIÁ ECHOES</h3>
                <div class="service__echoes-container">
                    <table class="service__echoes-table">
                        <thead>
                            <tr>
                                <th class="service__echoes-col--amount">Số lượng Echoes</th>
                                <th class="service__echoes-col--price">Giá tiền</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td>66 Echoes</td>
                                <td>22,000 đ</td>
                            </tr>
                            <tr>
                                <td>203 Echoes</td>
                                <td>66,000 đ</td>
                            </tr>
                            <tr>
                                <td>335 Echoes</td>
                                <td>100,000 đ</td>
                            </tr>
                            <tr>
                                <td>759 Echoes</td>
                                <td>220,000 đ</td>
                            </tr>
                            <tr>
                                <td>1,518 Echoes</td>
                                <td>440,000 đ</td>
                            </tr>
                            <tr>
                                <td>2,227 Echoes</td>
                                <td>660,000 đ</td>
                            </tr>
                            <tr>
                                <td>3,795 Echoes</td>
                                <td>880,000 đ</td>
                            </tr>
                            <tr>
                                <td>7,590 Echoes</td>
                                <td>2,200,000 đ</td>
                            </tr>
                        </tbody>
                    </table>
                </div>
                
                <div class="service__echoes-actions">
                    <a href="{{ config_get('contact_admin_url') }}" target="_blank" class="service__btn service__btn--primary service__btn--block">
                        <i class="fas fa-headset"></i> Liên hệ Admin
                    </a>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('scripts')
@endpush
