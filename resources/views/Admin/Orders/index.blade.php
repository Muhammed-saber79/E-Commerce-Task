@extends('Layouts.admin')

@section('title')
    Listing Orders
@endsection

@section('content')
    <main role="main" class="main-content">
        <div class="container-fluid">
            <div class="row justify-content-center">

                <div class="col-12">
                    <h2 class="mb-2 page-title">Listing All orders in the system</h2>
                    <div class="row my-4">
                        <div class="col-md-12">
                            <div class="card shadow">
                                <div class="card-body">
                                    <!-- الجدول -->
                                    <table class="table datatables" id="dataTable-1">
                                        <thead>
                                            <tr>
                                            <th>id</th>
                                            <th>Client</th>
                                            <th>Number of items</th>
                                            <th>Ordered At</th>
                                        </tr>
                                        </thead>
                                        <tbody>

                                            @forelse($orders as $order)
                                                <tr>
                                                    <td>{{ $order->id }}</td>
                                                    <td>{{ $order->user->name }}</td>
                                                    <td>{{ $order->orderItems()->count() }}</td>
                                                    <td>{{ $order->created_at }}</td>
                                                </tr>
                                            @empty
                                                <tr>
                                                    <td style="color: red; text-align: center" colspan="11">No orders added</td>
                                                </tr>
                                            @endforelse

                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div> <!-- الجدول البسيط -->
                    </div>
                </div>

            </div> <!-- .row -->
        </div> <!-- .container-fluid -->
    </main> <!-- main -->
@endsection
