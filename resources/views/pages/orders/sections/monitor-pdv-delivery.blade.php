<ul class="list-group list-delivery list-group-flush">
    @define $icon          = 'la la-group';
    @define $title         = 'Presencial';
    @define $deliveryPlace = '';
    @if( $order['Tipo'] === 'Entrega' )
        @define $icon  = 'la la-truck';
        @define $title = 'Delivery';
        @php
            $deliveryPlace  = '<strong>'.str_limit( array_get( $order, 'address.Logradouro' ), 30 ).':</strong> ';
            $deliveryPlace .= array_get( $order, 'address.Complemento' );
        @endphp
    @endif
    <li class="list-group-item delivery" style="background: transparent;">
        <i class="{{$icon}} icon pull-left @if(empty( $deliveryPlace )) no-place @endif" title="{{$title}}" data-order-icon="{{$icon}}"></i>
        <div>{{( !empty( array_get( $order, 'customer.Nome' ) ) ? array_get( $order, 'customer.Nome' ) : 'Não identificado' )}}</div>
        @if( !empty( $deliveryPlace ) )
            <div class="place">
                <small>{!! $deliveryPlace !!}</small>
            </div>
        @endif
        @if( !empty( array_get($order, 'Descricao.message') ) )
        <div class="place" style="margin-top: -11px;">
                <div class="badge badge-secondary badge-pdv-obs round">
                    <span>{{array_get($order, 'Descricao.message')}}</span>
                </div>
        </div>
        @endif
    </li>
    @if( !empty( array_get( $order, 'deliveryman' ) ) )
    <li class="list-group-item deliveryman" style="background: transparent">
        <i class="la la-user pull-left" title="Entregador" data-order-icon="{{$icon}}"></i>
        <div><strong>Entregador(a):</strong> {{ array_get( $order, 'deliveryman.Nome' ) }}</div>
    </li>
    @endif
</ul>
