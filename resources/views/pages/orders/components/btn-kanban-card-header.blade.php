@define $saleCode = $order['sale_code'];
@define $next_status = '';

@if( $approvedInPreparingAll == '0' )
    @if( $itemsComplete != 'true' )
        @php
            $tmp                  = $order['next_status'];
            $order['next_status'] = [];
            foreach ( $tmp as $key => $status ){
                
                if(  array_get( $status, 'state' )  !== 'processing' ){
                    $order['next_status'][] = $status;
                    $isCancel='Processar pedido';
                }
            }
        @endphp
    @endif
@endif

@if( ( !empty( $order['next_status'] ) || $order['state'] === 'new' ) )

       @if( $order['state'] !== 'new' && $order['status'] !== 'in_preparing' )
                <button type="button" class="btn btn-default next-status-order" data-code="{{$saleCode}}" data-payment-code="{{$order['payment_code']}}"
                        data-json-next-status="{{json_encode($order['next_status'])}}" data-final-price="{{$order['final_price']}}"
                        data-is-delivery="{{$order['is_delivery']}}" data-its-paid="{{$order['its_paid'] ? '1' : '0'}}"
                        data-status="{{$order['status']}}">
                    <i class="ft-chevrons-right"></i>
                </button>
        @endif

@endif
