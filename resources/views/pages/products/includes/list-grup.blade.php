@if( !empty( $sku ) && $isDuplicate === FALSE )
<h3></h3>
<a href="{{route('catalog.products.view_'.$action,[$sku])}}">
    <button class="btn-default-magali cursor-pointer" style="padding: 10px;">Principal</button>
</a>
<a href="{{route('catalog.products.images_'.$action,[$sku])}}">
    <button class="btn-default-magali cursor-pointer" style="padding: 10px;">Imagens</button>
</a>
@if( $action !== 'inputs' && $product['type'] !== 'ITEM' )
    <a href="{{route('catalog.products.banner_promo',[$sku])}}">
        <button class="btn-default-magali cursor-pointer" style="padding: 10px;">Banner promoção</button>
    </a>
    <a href="{{route('catalog.products.additional',[$sku])}}">
        <button class="btn-default-magali cursor-pointer" style="padding: 10px;">Itens adicionais</button>
    </a>
    @if( array_get( $product, 'manufacture' ) === 'PRÓPRIA' )
    <a href="{{route('catalog.products.production_sheet',[$sku])}}">
        <button class="btn-default-magali cursor-pointer" style="padding: 10px;">Ficha de produção</button>
    </a>
    @endif
    <a href="{{route('catalog.products.stock_history',[$sku])}}">
        <button class="btn-default-magali cursor-pointer" style="padding: 10px;">Movimentação estoque</button>
    </a>
@endif

@php
    $jsCode = "alert('agora sim!!!!')";
@endphp

@endif
