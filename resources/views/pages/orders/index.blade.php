@extends('layout')

@section('css')
    <style>
        .btn-nfc:hover{opacity: 0.7;}
    </style>
@endsection
@section('content')

    <!-- eCommerce statistic -->
    <div class="row">
        @include('pages.orders.sections.filter')
    </div>
    <!--/ eCommerce statistic -->

    <div class="row">
        <div class="col-lg-12">
            <div class="card">
                <div class="card-header reload-card" id="last-orders">
                    <h4 class="card-title"></h4>
                </div>
                <div class="card-content collapse show">
                    <div id="last-orders" class="media-list position-relative">
                        <div class="table-responsive">
                            <table class="table table-hover table-xl mb-0">
                                <thead>
                                <tr>
                                    <th class="border-top-0">Código</th>
                                    <th class="border-top-0">Status</th>
                                    <th class="border-top-0">Data</th>
                                    <th class="border-top-0">Produtos</th>
                                    <th class="border-top-0">Valor(R$)</th>
                                    <th class="border-top-0">Ações</th>
                                </tr>
                                </thead>
                                <tbody class="value-last-orders">
                        @if( count( $orders ) > 0 )
                            @foreach( $orders AS $order )

                                @php $classI = 'success'; @endphp
                                @switch($order['state'])
                                    @case('new')
                                            @php $classI = 'warning'; @endphp
                                            @break
                                    @case('closed')
                                    @case('canceled')
                                            @php $classI = 'danger'; @endphp
                                            @break
                                    @case('processing')
                                            @php $classI = 'info'; @endphp
                                            @break
                                @endswitch

                                <tr>
                                    <td class="text-truncate">
                                        <a href="{{route('orders.view', $order['sale_code'])}}">{{$order['sale_code']}}</a>
                                        <p class="p-0 m-0"><small>{{$order['origin'].' - '. format_order_type( $order['type'] ) }}</small></p>
                                    </td>
                                    <td class="text-truncate">
                                        <i class="la la-dot-circle-o {!! $classI !!} font-medium-1 mr-1"></i>{{$order['status_label']}}
                                    </td>
                                    <td class="text-truncate">{{$order['created_at']}}</td>
                                    <td>
                                        <div class="btn-group">
                                            <button type="button" style="opacity: 0.8" class="btn btn-icon btn-sm dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="true"><i style="font-size: 1.1em;" class="la la-list-alt"></i> Itens</button>
                                            <div class="dropdown-menu">
                                                @foreach($order['items'] AS $item)
                                                <a @if( !empty( array_get( $item, 'product_id_parent', null ) ) ) style="margin-left: 10px" @endif class="dropdown-item">{{$item['qty'].'x '.$item['product_name']}}</a>
                                                @endforeach
                                            </div>
                                        </div>
                                    </td>
                                    <td class="text-truncate @if( !$order['its_paid']) danger font-weight-bold @endif">
                                        {{$order['final_price']}}
                                    </td>
                                    <td>@component('components.btn-orders-print', [ 'order' => $order ] ) @endcomponent</td>
                                </tr>
                            @endforeach
                        @else
                            <tr><td colspan="5">Sem registros...</td></tr>
                        @endif
                                </tbody>
                            </table>
                        </div>
                    </div>

                    @component('components.paginator-new', [ 'paginator' => $paginate ] ) @endcomponent

                </div>
            </div>
        </div>
    </div>

@endsection

@section('js')
    <script>
        $(document).ready(function () {
            let pdvMenus = new PDVMenus();
            pdvMenus.bindNFCe( pdvMenus, true );
            pdvMenus.bindRePrint( pdvMenus, true );
        });

        $('.btn-filter').click(function () {
            $('form.form').submit();
        });
        @foreach($filters as $key => $value)
        $('*[name={{$key}}]').val('{{$value}}');
        @endforeach

        @php
            array_pull( $filters, 'limit' );
            array_pull( $filters, 'offset' );
        @endphp
        @if( count( $filters ) > 0 )
        $('#cardFilter').addClass('show');
        $('.btn-clear').removeClass('hidden');
        $('#icon-filter').removeClass('ft-plus').addClass('ft-minus');
        @endif

    </script>
@endsection
