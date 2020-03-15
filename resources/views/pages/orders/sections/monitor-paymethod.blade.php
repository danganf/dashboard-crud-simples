@define $icon     = '';
@define $payType  = '';
@define $payMethod = '';

@if( $order['its_paid'] )
    @define $icon     = 'la la-thumbs-o-up';
    @define $payType  = 'Já pago';

    @foreach( $order['payments'] as $row )
        @define $method = $row['method'];
        @if( $row['syscontrol'] )
            @define $method = \Lang::get('default.'.strtolower( $row['obs'] ));
        @endif
        @php
            $payMethod .= $method.':<span> R$ '.format_number( $row['value'], 2 ).'</span><br>'
        @endphp

    @endforeach

    @if( $payMethod )
        @php $payMethod = '<div class="section-delivery-pay-method">'.$payMethod.'</div>'; @endphp
    @endif

@elseif( !empty( $order['payment_code'] ) )
    @php
        if( $order['payment_code'] !== 'money' ){
            if( strpos( $order['payment_label'], '-' ) !== FALSE ){
                list($payType, $payMethod) = explode('-', $order['payment_label']);
                $payType   = trim($payType);
                $payMethod = trim($payMethod);
            } else {
                $payType   = $order['payment_label'];
                $payMethod = $order['its_paid'] ? '' : 'Pendente';
            }
            $icon      = 'la la-credit-card';
        } else {
            $payType   = $order['payment_label'];
            $payMethod = '';
            $icon      = 'la la-money';
        }
    @endphp
@elseif( !empty( $order['payment_label'] ) )
    @php
        $icon      = 'la la-thumbs-o-down';
        $payType   = $order['payment_label'];
        $payMethod = 'Pendente';
    @endphp
@endif
@if( $icon )
    <i class="{{$icon}} pull-left"></i>
    <strong>{{$payType}}</strong>
    <br>
    <small>{!! $payMethod !!}</small>
@endif
