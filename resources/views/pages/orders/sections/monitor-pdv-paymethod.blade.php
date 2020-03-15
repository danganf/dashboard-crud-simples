@php
    $payDescricao = array_get($order, 'Descricao.original');

    if( strpos( strtolower( $payDescricao ), 'dinheiro' ) === false ){
        $payType   = array_get($order, 'Descricao.pay_method');
        $payMethod = array_get($order, 'Descricao.pay_card_name');
        $icon      = 'la la-credit-card';
    } else {
        $payType   = array_get($order, 'Descricao.pay_method');
        $payMethod = '';
        $icon      = 'la la-money';
    }

@endphp
<i class="{{$icon}} pull-left"></i>
<strong>{{$payType}}</strong>
<br>
<small>{{$payMethod}}</small>
