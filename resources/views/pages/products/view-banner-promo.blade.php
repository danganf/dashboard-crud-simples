@extends('layout')

@section('content')

    <section class="row">
        <div class="col-sm-12">
            <div class="card">
                <div class="card-header reload-card">
                    <div class="heading-elements">
                        <a data-action="collapse"><i id="icon-filter" class="ft-minus"></i></a>
                        <a data-action="expand"><i class="ft-maximize"></i></a>
                    </div>
                </div>
                <div id="cardFilter" class="card-content collapse show">
                    <div class="card-body">

                        <div class="form-body">
                            @php $productTmp = []; @endphp
                            @if( !empty( $product['banner'] ) )
                                @php
                                    $productTmp = current($product['banner']);
                                @endphp
                                <div class="form-group row">
                                    <div class="col-lg">
                                        <ul class="list-unstyled users-list m-0">
                                            <img class="height-150 img-fluid" src="{{$productTmp['image']}}" alt="Avatar">
                                            <button type="button" data-code="{{$product['id']}}" id="btn-delete" class="btn btn-danger btn-sm"><i class="la la-trash"></i>Excluir</button>
                                        </ul>
                                    </div>
                                </div>
                            @endif
                            <form class="form form-horizontal striped-labels form-bordered" id="formBanner">
                                <h4></h4>
                                <div class="form-group row">
                                    <label class="col-md-2 label-control" for="name">Nome*</label>
                                    <div class="col-md-10">
                                        <input type="text" id="name" name="banner_name" class="form-control" value="{{array_get($productTmp, 'name', '')}}" placeholder="Nome">
                                    </div>
                                </div>
                                <div class="form-group row last">
                                    <label class="col-md-2 label-control" for="desc">Descrição</label>
                                    <div class="col-md-10">
                                        <input type="text" id="desc" name="banner_desc" class="form-control" value="{{array_get($productTmp, 'description', '')}}" placeholder="Descrição curta">
                                    </div>
                                </div>
                                <div class="form-group row last">
                                    <label class="col-md-2 label-control" for="desc">Status*</label>
                                    <div class="col-md-10">
                                        <div class="switch-toggle">
                                            <input type="checkbox" class="switchBootstrap" name="banner_status" value="0"
                                                   data-size="small" data-on-text="Sim" data-off-text="Não" data-on-color="success" data-off-color="danger" {{array_get($productTmp, 'status', '') ? 'checked' : ''}}/>
                                        </div>
                                    </div>
                                </div>
                            </form>
                            @if( empty( $product['banner'] ) )
                                <div class="form-group row">
                                    <div class="col-lg-12">
                                        <form action="{{route('api.product.banner_promo',[$product['sku']])}}" class="dropzone" id="formBannerProduct">
                                            <div id="dropzonePreview2"></div>
                                            <div class="fallback">
                                                <input name="file" type="file" />
                                            </div>
                                            <input type="hidden" name="banner_name" value="" />
                                            <input type="hidden" name="banner_desc" value="" />
                                            <input type="hidden" name="banner_status" value="0" />
                                        </form>
                                    </div>
                                </div>
                            @endif
                        </div>


                    </div>
                </div>
            </div>
            <div class="card">
                <div id="cardFilter" class="card-content">
                    <div class="card-body text-right">
                        <div>
                            <button type="submit" class="btn btn-primary btn-upload"><i class="la la-check-square-o"></i> Salvar</button>
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
    <link rel="stylesheet" type="text/css" href="/app-assets/vendors/css/file-uploaders/dropzone.min.css">
    <link rel="stylesheet" type="text/css" href="/app-assets/css/plugins/file-uploaders/dropzone.css">
    <style>
        .dropzone{
            min-height: 200px;
        }
        .dz-message{
            top: 30% !important;
        }
    </style>
@endsection

@section('js')
    <script src="/app-assets/vendors/js/extensions/dropzone.min.js" type="text/javascript"></script>
    <script>

    $( document ).ready(function() {
        {!! js_code_product_page() !!}
    });

    @if( empty( $product['banner'] ) )
        let maxImageWidth  = 1200;
        let maxImageHeight = 1024;
        let submitButton   = document.querySelector(".btn-upload");
        let htmlSubmitButton = submitButton.innerHTML;

        Dropzone.autoDiscover = false;

        let formBanner = $('#formBannerProduct');

        formBanner.dropzone({
            dictRemoveFile: "Remover arquivo",
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
            paramName: 'image_banner_product',
            addRemoveLinks: true,
            parallelUploads: 1,
            acceptedFiles: 'image/jpeg, image/jpg, image/png',
            thumbnailWidth: 460,
            thumbnailHeight: 320,
            autoProcessQueue: false,
            accept: function (file, done) {
                done();
            },
            success: function (file, response) {

                console.log(response);
                if (typeof response === 'object' && typeof response.error === 'undefined') {

                    helper.alertSucess('Banner carregado com sucesso!','');
                    location.reload();

                } else {
                    this.defaultOptions.error(file, response.messages );
                }

            },
            removedfile: function (file) {

                submitButton.disabled = false;
                let _ref;
                return (_ref = file.previewElement) != null && file.previewElement.parentNode ? _ref.parentNode.removeChild(file.previewElement) : void 0;

            },
            init: function () {

                let drop              = this; // Closure
                submitButton.disabled = true;

                this.on('addedfile', function(file) {
                    if (this.files.length > 1) {
                        this.removeFile(this.files[0]);
                    }
                    submitButton.disabled = false;
                });

                submitButton.addEventListener("click", function() {
                    let bannerName = $('#name');

                         if( bannerName.val() === '' ){helper.alertError('Nome obrigatório');bannerName.focus();}
                    else {
                             $('input[name="banner_name"]').val(bannerName.val());
                             $('input[name="banner_desc"]').val($('#desc').val());
                             $('input[name="banner_status"]').val( $(".switchBootstrap").bootstrapSwitch('state') ? 1 : 0 );
                             drop.processQueue();
                             $(this).html( helper.htmlSpinner() ).attr('disabled',true);
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

                    submitButton.innerHTML = htmlSubmitButton;
                    submitButton.disabled  = true;

                });

            }
        });
    @else
        let bannerName   = $('input[name="banner_name"]');
        let bannerDesc   = $('input[name="banner_desc"]');


        $('.btn-upload').on('click',function(){
            if( bannerName.val() === '' ){helper.alertError('Nome obrigatório');bannerName.focus();}
            else {

                let bannerStatus = $(".switchBootstrap").bootstrapSwitch('state') ? 1 : 0;

                $(this).html( helper.htmlSpinner() ).attr('disabled',true);
                let productID = $('#btn-delete').attr('data-code');

                $.ajax({
                    url: "/api/put/banner@product@"+productID,
                    method: 'POST',
                    data: {name: bannerName.val(), status: bannerStatus, 'description': bannerDesc.val()},
                    success: function (data, jqXHR) {
                        helper.alertSucess('Banner atualizado com sucesso!');
                        location.reload();
                    },
                    error: function(data, jqXHR) {
                        console.log(data);
                        helper.alertError('Ocorreu um erro!')
                    }
                });
            }
        });

        bannerName.focus();

        $('#btn-delete').on('click',function(){

            swal({
                title: "Você tem certeza?",
                text: "Não será possível resgatar as informações novamente!",
                icon: "warning",
                showCancelButton: true,
                closeOnEsc: true,
                buttons: {
                    cancel: {
                        text: "Fechar",
                        value: null,
                        visible: true,
                        className: "",
                        closeModal: true,
                    },
                    confirm: {
                        text: "Excluir",
                        value: true,
                        visible: true,
                        className: "btn-danger",
                        style: "border: 2px solid red",
                        closeModal: false
                    }
                }
            }).then(isConfirm => {
                let productID = $(this).attr('data-code');
                if (isConfirm === true) {
                    helper.alertProcess();
                    $.ajax({
                        url: "/api/delete/banner@product@"+productID,
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

    $( document ).ready(function() {
        $(".switchBootstrap").bootstrapSwitch();
    });

    </script>
@endsection
