@php
$tt = count( $orders );
@endphp
@if( $tt > 0 )
<div class="order-conclusion pull-right">
    <div class="dropdown nav-item">
        <a class="nav-link nav-link-label" href="#" data-toggle="dropdown" aria-expanded="false"><i class="icon icon-basket-loaded"></i>Concluídos
            <span class="badge badge-pill badge-default badge-danger badge-default badge-up badge-glow">{{$tt}}</span>
        </a>
        <ul class="mega-dropdown-menu dropdown-menu row">
            <li style="border-bottom: 1px solid #b3b3b3" class="dropdown-menu-header"><h6 class="dropdown-header truncate m-0"><span class="grey darken-2">Pedidos concluídos</span></h6></li>
            <li class="scrollable-container media-list w-100 ps-container ps-theme-dark ps-active-y">
                @foreach( $orders as $key => $order )

                        <div class="media">
                            <div class="media-body">


                                <div id="headingCollapse{{$key}}">
                                    <a data-toggle="collapse" href="#collapse{{$key}}" aria-expanded="false" aria-controls="collapse{{$key}}">
                                        <h6 class="media-heading font-small-4 font-weight-bold">
                                            <i class="la la-angle-double-right" style="font-size: 1rem;"></i>n&ordm {{$order['sale_code']}} às {{$order['created_at']}}
                                        </h6>
                                        <hr class="line">
                                        <p class="notification-text text-uppercase font-small-3 text-muted">
                                            {{$order['origin']}} -
                                            {{ ($order['is_delivery']) ? 'DELIVERY' : \Lang::get('default.'.strtolower( $order['type'] ))}} -
                                            <span style="font-weight: 600">R$ {{$order['final_price']}}</span>
                                        </p>
                                        <div class="timer text-danger"><i class="la la-clock-o pull-left"></i> {{format_number( $order['timer_minutes'] )}}min</div>
                                    @if( $order['state'] != 'complete' )
                                        <hr class="line">
                                        <p class="notification-text font-small-3 text-muted">
                                            <span class="badge  border-left-success badge-order-item badge-striped">{{$order['status_label']}}</span>
                                        </p>
                                    @endif
                                    </a>
                                </div>

                                <div id="collapse{{$key}}" role="tabpanel" aria-labelledby="headingCollapse{{$key}}" class="collapse" style="">
                                    <hr class="line">
                                    <p class="notification-text font-small-3 text-muted" style="font-weight:600;padding: 3px 0 6px 10px;">
                                        @foreach( $order['items'] as $item )
                                            {{$item['qty']}}x {{$item['product_name']}}
                                            @if( $item['state'] != 'complete' )
                                                <span class="badge badge-secondary">{{$item['status_label']}}</span>
                                            @endif
                                            <br/>
                                        @endforeach
                                    </p>
                                    <hr class="line">
                                    <p class="notification-text font-small-3 text-muted">
                                        <i class="la la-user pull-left"></i>
                                        @php
                                            $name = $order['client_name'];
                                            $name = !empty( $name ) ? $name : ( !empty( $order['user_name'] ) ? $order['user_name'] : \Lang::get('default.not_identify') );
                                        @endphp
                                        {{$name}}
                                    </p>
                                @if( $order['is_delivery'] )
                                    <hr class="line">
                                    <p class="notification-text font-small-3 text-muted">
                                        <i class="la la-map-marker pull-left" title="Local da entrega"></i>
                                            @define $deliveryPlace = '';
                                            @foreach ( $order['delivery_json_info'] as $info )
                                                @php $deliveryPlace .= $info['label'].' '.$info['value'].', '; @endphp
                                            @endforeach
                                        {{$order['delivery_label']}}: {{rtrim( $deliveryPlace, ', ' )}}
                                    </p>
                                    @if( !empty( $order['deliveryman_name'] ) )
                                    <hr class="line">
                                    <p class="notification-text font-small-3 text-muted">
                                        <i class="la la-share pull-left" title="Entregador"></i> {{$order['deliveryman_name']}}
                                    </p>
                                    @endif
                                @endif
                                </div>

                            </div>
                        </div>

                @endforeach
                <div class="ps-scrollbar-y-rail" style="top: 0; right: 3px; height: 255px;">
                    <div class="ps-scrollbar-y" tabindex="0" style="top: 0; height: 162px;display: none"></div>
                </div>
            </li>
        </ul>
    </div>
</div>
@endif
