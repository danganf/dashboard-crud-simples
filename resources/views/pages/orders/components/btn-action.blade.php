@define $saleCode = $order['sale_code'];

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

@if( ( !empty( $order['next_status'] ) || $order['state'] === 'new' ) /*&& $showCardFooter == 'true'*/ )
<div class="card-footer card-all border-top-blue-grey border-top-lighten-5 text-muted collapse {{$cardContent}}">
    <div class="decision-buttons pull-right">
        @if( $order['state'] === 'new' )
            <button type="button" class="btn btn-primary btn-min-width mr-1 mb-1 confirm-order" data-pos-id="{{$posID}}" data-code="{{$saleCode}}"><i class="ft-check"></i> Aprovar</button>
            <button type="button" class="btn btn-warning btn-min-width mr-1 mb-1 refuse-order" data-pos-id="{{isset($posID) ? $posID : ''}}" data-code="{{$saleCode}}"><i class="ft-x"></i> Recusar</button>
        {{--@elseif( $itemsComplete == 'true' )--}}
        @else
            @define $nameAction = 'Seguir com o Pedido';
            @if( $order['status'] == 'in_delivery' )
                @define $nameAction = 'Finalizar entrega';
            @elseif( isset( $isCancel ) )
                @define $nameAction = $isCancel;
            @endif
            <button type="button" class="truncate btn btn-info btn-min-width mr-1 mb-1 next-status-order" data-code="{{$saleCode}}" data-payment-code="{{$order['payment_code']}}"
                    data-json-next-status="{{json_encode($order['next_status'])}}" data-final-price="{{$order['final_price']}}"
                    data-is-delivery="{{$order['is_delivery']}}" data-its-paid="{{$order['its_paid'] ? '1' : '0'}}">
                <i class="ft-chevrons-right"></i> {{$nameAction}}
            </button>
        @endif
    </div>
</div>
@endif
