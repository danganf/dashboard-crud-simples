@extends('layout')

@section('content')

    <section class="row">
        <div class="col-sm-12">
            <div class="card">
                <div class="card-header reload-card">
                    <h4 class="card-title info click-collpase"><i class="la la-picture-o"></i> Imagem principal <small class="text-muted">Tamanho ideal: 800X600</small></h4>
                    <div class="heading-elements">
                        <a data-action="collapse"><i id="icon-filter" class="ft-minus"></i></a>
                        <a data-action="expand"><i class="ft-maximize"></i></a>
                    </div>
                </div>
                <div class="card-content collapse show">
                    <div class="card-body">

                        <div class="form-body">
                            @if( !empty( $product['image'] ) )
                                @php
                                    $productImage = current($product['image']);
                                @endphp
                                <div class="form-group row">
                                    <div class="col-lg">
                                        <ul class="list-unstyled users-list m-0">
                                            <img class="height-150 img-fluid" src="{{$productImage}}" alt="Avatar">
                                            <button type="button" data-code="{{$product['sku']}}" id="btn-delete" class="btn btn-danger btn-sm"><i class="la la-trash"></i>Excluir</button>
                                        </ul>
                                    </div>
                                </div>
                            @endif
                            @if( empty( $product['image'] ) )
                                <div class="form-group row">
                                    <div class="col-lg-12">
                                        <form action="{{route('api.product.image',[$product['sku'],'main'])}}" class="dropzone" id="formMainImgProduct">
                                            {{--<div id="dropzonePreview2"></div>--}}
                                            <div class="fallback">
                                                <input name="file" type="file" />
                                            </div>
                                        </form>
                                    </div>
                                    {{--<div class="col-lg-12 text-right" style="margin-top: 20px">
                                        <button type="submit" class="btn btn-primary btn-upload"><i class="la la-check-square-o"></i> Salvar</button>
                                    </div>--}}
                                </div>
                            @endif
                        </div>


                    </div>
                </div>
            </div>

            @php
                $icon1    = 'plus';
                $collapse = 'collapse';
            @endphp

            @if( !empty( $product['image_inside'] ) )
                @php
                    $icon1 = 'minus';
                    $collapse = '';
                @endphp
            @endif

            <div class="card">
                <div class="card-header reload-card">
                    <h4 class="card-title info click-collpase"><i class="la la-picture-o"></i> Imagem Interna <small class="text-muted">Tamanho ideal: 1980X1024</small></h4>
                    <div class="heading-elements">
                        <a data-action="collapse"><i id="icon-filter" class="ft-{{$icon1}}"></i></a>
                        <a data-action="expand"><i class="ft-maximize"></i></a>
                    </div>
                </div>
                <div class="card-content {{$collapse}}">
                    <div class="card-body">

                        <div class="form-body">
                            @if( !empty( $product['image_inside'] ) )
                                @php
                                    $productImage = current($product['image_inside']);
                                @endphp
                                <div class="form-group row">
                                    <div class="col-lg">
                                        <ul class="list-unstyled users-list m-0">
                                            <img class="height-150 img-fluid" src="{{$productImage}}" alt="Avatar">
                                            <button type="button" data-code="{{$product['sku']}}" id="btn-delete-inside" class="btn btn-danger btn-sm"><i class="la la-trash"></i>Excluir</button>
                                        </ul>
                                    </div>
                                </div>
                            @endif
                            @if( empty( $product['image_inside'] ) )
                                <div class="form-group row">
                                    <div class="col-lg-12">
                                        <form action="{{route('api.product.image',[$product['sku'],'inside'])}}" class="dropzone" id="formInsideImgProduct">
                                            {{--<div id="dropzonePreview3"></div>--}}
                                            <div class="fallback">
                                                <input name="file" type="file" />
                                            </div>
                                        </form>
                                    </div>
                                    {{--<div class="col-lg-12 text-right" style="margin-top: 20px">
                                        <button type="submit" class="btn btn-primary btn-upload-inside"><i class="la la-check-square-o"></i> Salvar</button>
                                    </div>--}}
                                </div>
                            @endif
                        </div>


                    </div>
                </div>
            </div>
        </div>
        <nav class="cbp-spmenu cbp-spmenu-horizontal cbp-spmenu-bottom" id="cbp-spmenu-s4">
            @include('pages.products.includes.list-grup')
        </nav>
    </section>

@endsection

@section('css')
    <style>
        .dropzone{
            min-height: 160px;
        }
        .dz-message{
            top: 30% !important;
        }
    </style>
@endsection

@section('js')
    <script>
    @if( empty( $product['image'] ) || empty( $product['image_inside'] ) )
        let maxImageWidth     = 1200;
        let maxImageHeight    = 1024;
        Dropzone.autoDiscover = false;
    @endif;

    $( document ).ready(function() {
        {!! js_code_product_page() !!}
    });

    @if( empty( $product['image'] ) )

        let formMainImg   = $('#formMainImgProduct');

        formMainImg.dropzone({
            dictRemoveFile: "Remover imagem",
            dictFallbackMessage: "Seu navegador não supoorta upload de arquivo estilo Drag n Drop.",
            dictFallbackText: "Please use the fallback form below to upload your files like in the olden days.",
            dictFileTooBig: "Arquivo muito grande. Tamanho máximo: 2MB.",
            dictInvalidFileType: "Nao é possível fazer upload com esse tipo de arquivo.",
            dictResponseError: "Servidor respondeu com código de erro.",
            dictCancelUpload: "Cancelar upload",
            dictCancelUploadConfirmation: "Tem certeza que deseja cancelar esse upload?",
            dictMaxFilesExceeded: "Você não pode carregar mais arquivos.",
            dictDefaultMessage: "Click ou arraste.",
            maxFilesize: 1,
            paramName: 'image_product',
            addRemoveLinks: true,
            parallelUploads: 1,
            acceptedFiles: 'image/jpeg, image/jpg, image/png',
            thumbnailWidth: 460,
            thumbnailHeight: 320,
            autoProcessQueue: true,
            accept: function (file, done) {
                done();
            },
            success: function (file, response) {

                console.log(response);
                if (typeof response === 'object' && typeof response.error === 'undefined') {

                    helper.alertSucess('Image principal definida com sucesso!','');
                    location.reload();

                } else {
                    this.removeFile(file);
                    this.defaultOptions.error(file, response.messages );
                }

            },
            removedfile: function (file) {

                let _ref;
                return (_ref = file.previewElement) != null && file.previewElement.parentNode ? _ref.parentNode.removeChild(file.previewElement) : void 0;

            },
            init: function () {

                let drop = this; // Closure

                this.on('addedfile', function(file) {
                    if (this.files.length > 1) {
                        this.removeFile(this.files[0]);
                    }
                });

                drop.on("thumbnail", function(file) {
                    if (file.width > maxImageWidth || file.height > maxImageHeight) {
                        var errorDisplay = document.querySelectorAll('[data-dz-errormessage]');
                        errorDisplay[errorDisplay.length - 1].innerHTML = 'Verifique se a largura e altura da imagem são maiores que '+maxImageWidth+'x'+maxImageHeight+'px.';
                    }
                });

                drop.on('error', function (file, errorMessage) {

                    $(file.previewElement).find('div.dz-image img');

                    if (typeof errorMessage === 'object' && typeof errorMessage.error !== 'undefined') {
                        helper.alertError(errorMessage.messages);
                        this.removeFile(file);
                    } else {
                        if (errorMessage.indexOf('Error 404') !== -1) {
                            let errorDisplay = document.querySelectorAll('[data-dz-errormessage]');
                            errorDisplay[errorDisplay.length - 1].innerHTML = 'Error 404: The upload page was not found on the server';
                        }
                        if (errorMessage.indexOf('File is too big') !== -1) {
                            drop.removeFile(file);
                        }
                        if (errorMessage.indexOf('pode carregar mais arquivos') !== -1) {
                            drop.removeFile(file);
                        }
                    }

                });

            }
        });
    @else

        $('#btn-delete').on('click',function(){
            swal({
                title: "Você tem certeza?",
                html: "Não será possível resgatar as informações novamente!",
                type: "warning",
                confirmButtonText: "CONTINUAR MESMO ASSIM >>",
                cancelButtonText: "CANCELAR",
                showCancelButton: true,
                width: '462px',
            }).then((dismiss) => {
                let productSku = $(this).attr('data-code');
                if (dismiss.value) {
                    helper.alertProcess();
                    console.log(productSku);
                    $.ajax({
                        method: 'POST',
                        url: "/api/delete/product@"+productSku+'@image@main',
                        success: function (data, jqXHR) {
                            helper.alertClose();
                            location.reload();
                        },
                        error: function(data, jqXHR) {
                            console.log(data);
                            helper.alertError('Ocorreu um erro!')
                        }
                    });
                }
            });
        });
    @endif

    @if( empty( $product['image_inside'] ) )

        let formInsideImg = $('#formInsideImgProduct');

        formInsideImg.dropzone({
            dictRemoveFile: "Remover imagem",
            dictFallbackMessage: "Seu navegador não supoorta upload de arquivo estilo Drag n Drop.",
            dictFallbackText: "Please use the fallback form below to upload your files like in the olden days.",
            dictFileTooBig: "Arquivo muito grande. Tamanho máximo: 2MB.",
            dictInvalidFileType: "Nao é possível fazer upload com esse tipo de arquivo.",
            dictResponseError: "Servidor respondeu com código de erro.",
            dictCancelUpload: "Cancelar upload",
            dictCancelUploadConfirmation: "Tem certeza que deseja cancelar esse upload?",
            dictMaxFilesExceeded: "Você não pode carregar mais arquivos.",
            dictDefaultMessage: "Click ou arraste.",
            maxFilesize: 1,
            paramName: 'image_product',
            addRemoveLinks: true,
            parallelUploads: 1,
            acceptedFiles: 'image/jpeg, image/jpg, image/png',
            thumbnailWidth: 460,
            thumbnailHeight: 320,
            autoProcessQueue: true,
            accept: function (file, done) {
                done();
            },
            success: function (file, response) {

                console.log(response);
                if (typeof response === 'object' && typeof response.error === 'undefined') {

                    helper.alertSucess('Image interna definida com sucesso!','');
                    location.reload();

                } else {
                    this.removeFile(file);
                    this.defaultOptions.error(file, response.messages );
                }

            },
            removedfile: function (file) {

                let _ref;
                return (_ref = file.previewElement) != null && file.previewElement.parentNode ? _ref.parentNode.removeChild(file.previewElement) : void 0;

            },
            init: function () {

                let drop                    = this; // Closure

                this.on('addedfile', function(file) {
                    if (this.files.length > 1) {
                        this.removeFile(this.files[0]);
                    }
                });

                drop.on("thumbnail", function(file) {
                    if (file.width > maxImageWidth || file.height > maxImageHeight) {
                        var errorDisplay = document.querySelectorAll('[data-dz-errormessage]');
                        errorDisplay[errorDisplay.length - 1].innerHTML = 'Verifique se a largura e altura da imagem são maiores que '+maxImageWidth+'x'+maxImageHeight+'px.';
                    }
                });

                drop.on('error', function (file, errorMessage) {

                    $(file.previewElement).find('div.dz-image img');

                    if (typeof errorMessage === 'object' && typeof errorMessage.error !== 'undefined') {
                        helper.alertError(errorMessage.messages);
                        this.removeFile(file);
                    } else {
                        if (errorMessage.indexOf('Error 404') !== -1) {
                            let errorDisplay = document.querySelectorAll('[data-dz-errormessage]');
                            errorDisplay[errorDisplay.length - 1].innerHTML = 'Error 404: The upload page was not found on the server';
                        }
                        if (errorMessage.indexOf('File is too big') !== -1) {
                            drop.removeFile(file);
                        }
                        if (errorMessage.indexOf('pode carregar mais arquivos') !== -1) {
                            drop.removeFile(file);
                        }
                    }

                });

            }
        });
    @else

    $('#btn-delete-inside').on('click',function(){

        swal({
            title: "Você tem certeza?",
            html: "Não será possível resgatar as informações novamente!",
            type: "warning",
            confirmButtonText: "CONTINUAR MESMO ASSIM >>",
            cancelButtonText: "CANCELAR",
            showCancelButton: true,
            width: '462px',
        }).then((dismiss) => {
            let productSku = $(this).attr('data-code');
            if (dismiss.value) {
                helper.alertProcess();
                console.log(productSku);
                $.ajax({
                    method: 'POST',
                    url: "/api/delete/product@"+productSku+'@image@inside',
                    success: function (data, jqXHR) {
                        helper.alertClose();
                        location.reload();
                    },
                    error: function(data, jqXHR) {
                        console.log(data);
                        helper.alertError('Ocorreu um erro!')
                    }
                });
            }
        });

    });
    @endif

    </script>
@endsection
